@extends('layouts.app')

@section('title', 'Payment Successful!')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="max-w-lg w-full text-center">
        <!-- Success Animation -->
        <div class="mb-8">
            <div class="relative inline-block">
                <div class="w-24 h-24 bg-green-500/20 rounded-full flex items-center justify-center animate-pulse">
                    <i class="fa-solid fa-check text-4xl text-green-500"></i>
                </div>
                <!-- Confetti effect circles -->
                <div class="absolute -top-2 -left-2 w-4 h-4 bg-yellow-400 rounded-full animate-bounce"></div>
                <div class="absolute -top-1 right-0 w-3 h-3 bg-pink-400 rounded-full animate-bounce delay-100"></div>
                <div class="absolute -bottom-1 -right-2 w-4 h-4 bg-blue-400 rounded-full animate-bounce delay-200"></div>
            </div>
        </div>

        <h1 class="font-outfit text-3xl md:text-4xl font-bold text-white mb-4">
            Payment Successful! 🎉
        </h1>
        <p class="text-gray-400 text-lg mb-8">
            Thank you for subscribing to Codeflix. Your account has been upgraded and you now have access to all premium content.
        </p>

        <!-- Plan Details Card -->
        <div class="bg-codeflix-card rounded-2xl p-6 mb-8 text-left">
            <div class="flex items-center gap-4 pb-4 border-b border-gray-800">
                <div class="w-12 h-12 bg-gradient-to-br from-codeflix-primary to-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-crown text-white text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-white">Premium Member</p>
                    <p class="text-sm text-gray-400">Your subscription is now active</p>
                </div>
            </div>
            
            <div class="pt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Status</span>
                    <span class="text-green-400 font-medium"><i class="fa-solid fa-circle text-xs mr-1"></i> Active</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Valid Until</span>
                    <span class="text-white">{{ now()->addDays(30)->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- What's Next -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-codeflix-card rounded-xl p-4 text-center">
                <i class="fa-solid fa-users text-2xl text-codeflix-primary mb-2"></i>
                <p class="text-sm text-gray-300">Create Profiles</p>
            </div>
            <div class="bg-codeflix-card rounded-xl p-4 text-center">
                <i class="fa-solid fa-heart text-2xl text-red-500 mb-2"></i>
                <p class="text-sm text-gray-300">Build Watchlist</p>
            </div>
            <div class="bg-codeflix-card rounded-xl p-4 text-center">
                <i class="fa-solid fa-play text-2xl text-green-500 mb-2"></i>
                <p class="text-sm text-gray-300">Start Watching</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-4 rounded-xl transition">
                <i class="fa-solid fa-play"></i>
                Start Watching
            </a>
            <a href="{{ route('profiles.index') }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 bg-codeflix-card hover:bg-gray-700 text-white font-semibold py-4 rounded-xl border border-gray-700 transition">
                <i class="fa-solid fa-user-plus"></i>
                Set Up Profiles
            </a>
        </div>

        <!-- Email Note -->
        <p class="text-gray-500 text-sm mt-8">
            <i class="fa-solid fa-envelope mr-1"></i>
            A confirmation email has been sent to {{ auth()->user()->email }}
        </p>
    </div>
</div>
@endsection
