@extends('layouts.app')

@section('title', 'Checkout - ' . $plan->title)

@section('content')
<div class="min-h-screen py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-8">
            <a href="{{ route('subscribe.plans') }}" class="hover:text-white">Plans</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-white">Checkout</span>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2 lg:order-2">
                <div class="bg-codeflix-card rounded-2xl p-6 sticky top-24">
                    <h3 class="font-outfit text-lg font-semibold text-white mb-4">Order Summary</h3>
                    
                    <div class="space-y-4 pb-4 border-b border-gray-800">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-codeflix-primary to-emerald-600 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-crown text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $plan->title }}</p>
                                <p class="text-sm text-gray-400">{{ $plan->duration }} days subscription</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 py-4 border-b border-gray-800 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Plan</span>
                            <span class="text-white">{{ $plan->title }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Resolution</span>
                            <span class="text-white">{{ $plan->resolution }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Devices</span>
                            <span class="text-white">{{ $plan->max_devices }} screens</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Duration</span>
                            <span class="text-white">{{ $plan->duration }} days</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Total</span>
                            <span class="text-2xl font-bold text-codeflix-primary">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3 text-sm text-gray-500">
                        <i class="fa-solid fa-shield-halved text-codeflix-primary"></i>
                        <span>Secure payment via Midtrans</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="lg:col-span-3 lg:order-1">
                <h2 class="font-outfit text-2xl font-bold text-white mb-6">Complete Your Purchase</h2>

                <form id="checkout-form" action="{{ route('subscribe.process') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                    <!-- Account Info -->
                    <div class="bg-codeflix-card rounded-2xl p-6">
                        <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user text-codeflix-primary"></i>
                            Account Information
                        </h3>
                        
                        <div class="grid gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name }}" disabled
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-gray-400">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Email Address</label>
                                <input type="email" value="{{ auth()->user()->email }}" disabled
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-gray-400">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Info -->
                    <div class="bg-codeflix-card rounded-2xl p-6">
                        <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-credit-card text-codeflix-primary"></i>
                            Payment Method
                        </h3>
                        
                        <div class="grid grid-cols-4 gap-3 mb-4">
                            <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-6">
                            </div>
                            <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                            </div>
                            <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                                <img src="https://gopay.co.id/assets/img/og-new.jpg" alt="GoPay" class="h-6 object-contain">
                            </div>
                            <div class="bg-white rounded-lg p-3 flex items-center justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" alt="OVO" class="h-6">
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-400">
                            You will be redirected to our secure payment partner to complete your purchase.
                        </p>
                    </div>

                    <input type="hidden" name="amount" value="{{ $plan->price }}">

                    <!-- Submit -->
                    <button type="submit" id="pay-button"
                            class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-4 rounded-xl transition flex items-center justify-center gap-2 text-lg">
                        <i class="fa-solid fa-lock"></i>
                        Pay Rp{{ number_format($plan->price, 0, ',', '.') }}
                    </button>

                    <p class="text-center text-sm text-gray-500">
                        By completing this purchase, you agree to our 
                        <a href="#" class="text-codeflix-primary hover:underline">Terms of Service</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if(config('midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endif
<script>
    const payButton = document.querySelector('#pay-button');
    const form = document.querySelector('#checkout-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Disable button
        payButton.disabled = true;
        payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

        try {
            const formData = new FormData(form);
            const response = await fetch("{{ route('checkout') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        window.location.href = "{{ route('subscribe.success') }}";
                    },
                    onPending: function(result){
                        alert("Pending payment! Please complete your payment.");
                        window.location.href = "{{ route('subscribe.success') }}"; 
                    },
                    onError: function(result){
                        alert("Payment failed!");
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa-solid fa-lock"></i> Pay Again';
                    },
                    onClose: function(){
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa-solid fa-lock"></i> Pay Again';
                    }
                });
            } else {
                alert('Transaction Failed: ' + (data.message || 'Unknown error'));
                payButton.disabled = false;
                payButton.innerText = 'Try Again';
            }
        } catch (error) {
            console.error(error);
            alert('Error processing transaction');
            payButton.disabled = false;
             payButton.innerText = 'Try Again';
        }
    });
</script>
@endpush
@endsection
