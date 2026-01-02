<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReferralController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    /**
     * Display referral dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user has referral code
        if (!$user->referral_code) {
            $user->update([
                'referral_code' => strtoupper(\Illuminate\Support\Str::random(8))
            ]);
        }

        $referrals = Referral::where('referrer_id', $user->id)
            ->with('referred')
            ->latest()
            ->get();

        $referralCount = $referrals->count();
        $completedReferrals = $referrals->where('status', 'completed')->count();
        $pendingReferrals = $referrals->where('status', 'pending')->count();

        return view('referral.index', compact(
            'referrals',
            'referralCount',
            'completedReferrals',
            'pendingReferrals'
        ));
    }

    /**
     * Apply referral code during registration
     */
    public static function applyReferralCode(string $code, int $newUserId): bool
    {
        $referrer = \App\Models\User::where('referral_code', $code)->first();
        
        if (!$referrer || $referrer->id === $newUserId) {
            return false;
        }

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $newUserId,
            'code' => $code,
            'status' => 'pending',
        ]);

        return true;
    }
}
