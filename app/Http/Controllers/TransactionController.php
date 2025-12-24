<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Initialize Midtrans configuration.
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Handle the checkout process.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Generate a unique transaction number
        $transactionNumber = 'ORDER-' . time() . '-' . $user->id;

        // Create a new transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'plan_id' => $request->plan_id,
            'transaction_number' => $transactionNumber,
            'total_amount' => $request->amount,
            'payment_status' => 'pending',
        ]);

        Log::info('Checkout initiated', [
            'user_id' => $user->id,
            'transaction_number' => $transactionNumber,
            'plan_id' => $request->plan_id,
        ]);

        // Prepare the payload for Midtrans
        $payload = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_number,
                'gross_amount' => (int) round($transaction->total_amount, 0, PHP_ROUND_HALF_UP),
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? config('app.default_phone', '000000000000'),
            ],
            'item_details' => [
                [
                    'id' => $transaction->plan_id,
                    'price' => (int) round($transaction->total_amount, 0, PHP_ROUND_HALF_UP),
                    'quantity' => 1,
                    'name' => $transaction->plan->title,
                ],
            ],
        ];

        try {
            // Request Snap token from Midtrans
            $snapToken = Snap::getSnapToken($payload);
            $transaction->update(['snap_token' => $snapToken]);

            Log::info('Snap token generated', ['transaction_number' => $transactionNumber]);

            // Return success response with Snap token
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate Snap token', [
                'transaction_number' => $transactionNumber,
                'error' => $e->getMessage(),
            ]);

            // Return error response if an exception occurs
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        // Retrieve the Midtrans server key from config
        $serverKey = config('midtrans.server_key');
        
        // Generate the hash signature
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Compare the generated signature with the request signature
        if ($hashed !== $request->signature_key) {
            Log::warning('Invalid Midtrans callback signature', [
                'order_id' => $request->order_id,
            ]);
            return response()->json(['status' => 'error'], 403);
        }

        // Find the transaction using the order ID
        $transaction = Transaction::with('user', 'plan')->where('transaction_number', $request->order_id)->first();
    
        if (!$transaction) {
            Log::warning('Transaction not found for callback', [
                'order_id' => $request->order_id,
            ]);
            return response()->json(['status' => 'error'], 404);
        }

        Log::info('Midtrans callback received', [
            'order_id' => $request->order_id,
            'transaction_status' => $request->transaction_status,
        ]);

        // Handle different transaction statuses
        $transactionStatus = $request->transaction_status;

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Payment successful
            return $this->handleSuccessfulPayment($transaction, $request);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            // Payment failed
            return $this->handleFailedPayment($transaction, $request, $transactionStatus);
        } elseif ($transactionStatus == 'pending') {
            // Payment pending - no action needed, already pending
            Log::info('Payment still pending', ['order_id' => $request->order_id]);
            return response()->json(['status' => 'success']);
        }

        // Unknown status
        Log::warning('Unknown transaction status', [
            'order_id' => $request->order_id,
            'status' => $transactionStatus,
        ]);
        return response()->json(['status' => 'success']);
    }

    /**
     * Handle successful payment callback.
     */
    private function handleSuccessfulPayment(Transaction $transaction, Request $request)
    {
        $user = $transaction->user;
        $plan = $transaction->plan;

        try {
            DB::beginTransaction();

            // Create a new membership for the user
            $user->memberships()->create([
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration),
                'active' => true,
            ]);

            // Update transaction with successful payment status
            $transaction->update([
                'payment_status' => 'success',
                'midtrans_transaction_id' => $request->transaction_id,
            ]);

            DB::commit();

            Log::info('Payment processed successfully', [
                'order_id' => $request->order_id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to process successful payment', [
                'order_id' => $request->order_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process membership',
            ], 500);
        }
    }

    /**
     * Handle failed payment callback.
     */
    private function handleFailedPayment(Transaction $transaction, Request $request, string $status)
    {
        $transaction->update([
            'payment_status' => 'failed',
            'midtrans_transaction_id' => $request->transaction_id,
        ]);

        Log::info('Payment failed', [
            'order_id' => $request->order_id,
            'status' => $status,
        ]);

        return response()->json(['status' => 'success']);
    }
}
