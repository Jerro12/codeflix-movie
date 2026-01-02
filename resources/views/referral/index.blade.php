@extends('layouts.app')

@section('title', 'Invite Friends & Earn')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-gradient-to-br from-codeflix-primary to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-gift text-3xl text-white"></i>
            </div>
            <h1 class="font-outfit text-4xl font-bold text-white mb-4">Invite Friends, Get Rewards</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Share Codeflix with your friends and both of you will get <span class="text-codeflix-primary font-semibold">{{ config('app.referral_bonus_days', 7) }} free days</span> added to your subscription!
            </p>
        </div>

        <!-- Referral Code Card -->
        <div class="bg-gradient-to-r from-codeflix-primary/20 via-codeflix-card to-codeflix-primary/20 rounded-2xl p-8 mb-8 text-center">
            <p class="text-gray-400 mb-3">Your unique referral code</p>
            <div class="flex items-center justify-center gap-4">
                <div class="bg-codeflix-dark border-2 border-dashed border-codeflix-primary rounded-xl px-8 py-4">
                    <span class="font-mono text-3xl font-bold text-white tracking-widest">{{ auth()->user()->referral_code ?? 'CODEFLIX' }}</span>
                </div>
                <button onclick="copyCode()" class="w-12 h-12 bg-codeflix-primary hover:bg-codeflix-primary/80 rounded-xl flex items-center justify-center text-white transition">
                    <i class="fa-solid fa-copy text-xl"></i>
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-4">Share this code with friends to start earning rewards</p>
        </div>

        <!-- Share Options -->
        <div class="bg-codeflix-card rounded-2xl p-6 mb-8">
            <h3 class="font-semibold text-white mb-4">Share via</h3>
            <div class="grid grid-cols-4 gap-4">
                <a href="https://wa.me/?text={{ urlencode('Join Codeflix with my referral code ' . auth()->user()->referral_code . ' and get free days! ' . url('/register?ref=' . auth()->user()->referral_code)) }}" 
                   target="_blank"
                   class="flex flex-col items-center gap-2 p-4 bg-codeflix-dark hover:bg-green-600/20 rounded-xl transition">
                    <i class="fa-brands fa-whatsapp text-2xl text-green-500"></i>
                    <span class="text-sm text-gray-400">WhatsApp</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode('Join Codeflix with my referral code and get free streaming days! ' . url('/register?ref=' . auth()->user()->referral_code)) }}" 
                   target="_blank"
                   class="flex flex-col items-center gap-2 p-4 bg-codeflix-dark hover:bg-blue-600/20 rounded-xl transition">
                    <i class="fa-brands fa-twitter text-2xl text-blue-400"></i>
                    <span class="text-sm text-gray-400">Twitter</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/register?ref=' . auth()->user()->referral_code)) }}" 
                   target="_blank"
                   class="flex flex-col items-center gap-2 p-4 bg-codeflix-dark hover:bg-blue-800/20 rounded-xl transition">
                    <i class="fa-brands fa-facebook text-2xl text-blue-600"></i>
                    <span class="text-sm text-gray-400">Facebook</span>
                </a>
                <a href="mailto:?subject=Join Codeflix!&body={{ urlencode('Hey! Join Codeflix with my referral code ' . auth()->user()->referral_code . ' and get free days! ' . url('/register?ref=' . auth()->user()->referral_code)) }}" 
                   class="flex flex-col items-center gap-2 p-4 bg-codeflix-dark hover:bg-gray-600/20 rounded-xl transition">
                    <i class="fa-solid fa-envelope text-2xl text-gray-400"></i>
                    <span class="text-sm text-gray-400">Email</span>
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-codeflix-card rounded-2xl p-6 text-center">
                <p class="text-4xl font-bold text-white mb-2">{{ $referralCount ?? 0 }}</p>
                <p class="text-gray-400">Friends Invited</p>
            </div>
            <div class="bg-codeflix-card rounded-2xl p-6 text-center">
                <p class="text-4xl font-bold text-codeflix-primary mb-2">{{ ($completedReferrals ?? 0) * config('app.referral_bonus_days', 7) }}</p>
                <p class="text-gray-400">Days Earned</p>
            </div>
            <div class="bg-codeflix-card rounded-2xl p-6 text-center">
                <p class="text-4xl font-bold text-yellow-400 mb-2">{{ $pendingReferrals ?? 0 }}</p>
                <p class="text-gray-400">Pending</p>
            </div>
        </div>

        <!-- Referral History -->
        <div class="bg-codeflix-card rounded-2xl p-6">
            <h3 class="font-semibold text-white mb-4">Referral History</h3>
            
            @if(($referrals ?? collect())->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                <p>No referrals yet. Start inviting friends!</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($referrals as $referral)
                <div class="flex items-center justify-between p-4 bg-codeflix-dark rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($referral->referred->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $referral->referred->name }}</p>
                            <p class="text-sm text-gray-400">{{ $referral->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $referral->status === 'completed' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                        {{ ucfirst($referral->status) }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- How It Works -->
        <div class="mt-8 p-6 bg-codeflix-card rounded-2xl">
            <h3 class="font-semibold text-white mb-6 text-center">How It Works</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-codeflix-primary/20 rounded-full flex items-center justify-center mx-auto mb-3 text-codeflix-primary font-bold">1</div>
                    <h4 class="text-white font-medium mb-2">Share Your Code</h4>
                    <p class="text-sm text-gray-400">Send your unique referral code to friends</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-codeflix-primary/20 rounded-full flex items-center justify-center mx-auto mb-3 text-codeflix-primary font-bold">2</div>
                    <h4 class="text-white font-medium mb-2">Friends Subscribe</h4>
                    <p class="text-sm text-gray-400">They sign up and subscribe to any plan</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-codeflix-primary/20 rounded-full flex items-center justify-center mx-auto mb-3 text-codeflix-primary font-bold">3</div>
                    <h4 class="text-white font-medium mb-2">Both Get Rewarded</h4>
                    <p class="text-sm text-gray-400">You both get {{ config('app.referral_bonus_days', 7) }} free days!</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyCode() {
    const code = '{{ auth()->user()->referral_code ?? 'CODEFLIX' }}';
    navigator.clipboard.writeText(code).then(() => {
        showToast('Referral code copied!', 'success');
    });
}
</script>
@endpush
@endsection
