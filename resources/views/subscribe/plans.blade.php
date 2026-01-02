@extends('layouts.app')

@section('title', 'Choose Your Plan')

@section('content')
<div class="min-h-screen py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-outfit text-4xl md:text-5xl font-bold text-white mb-4">
                Choose Your Plan
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Get unlimited access to thousands of movies and TV shows. Cancel anytime.
            </p>
        </div>

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($plans as $index => $plan)
            <div class="relative group">
                <!-- Popular Badge -->
                @if($index === 1)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                    <span class="bg-codeflix-primary text-white text-sm font-bold px-4 py-1 rounded-full shadow-lg">
                        MOST POPULAR
                    </span>
                </div>
                @endif

                <div class="h-full bg-codeflix-card border-2 {{ $index === 1 ? 'border-codeflix-primary' : 'border-gray-800' }} rounded-2xl p-6 lg:p-8 transition hover:border-codeflix-primary/50 hover:shadow-xl hover:shadow-codeflix-primary/10">
                    <!-- Plan Header -->
                    <div class="text-center mb-6">
                        <h3 class="font-outfit text-2xl font-bold text-white mb-2">{{ $plan->title }}</h3>
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-4xl font-bold text-codeflix-primary">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                            <span class="text-gray-500">/ {{ $plan->duration }} hari</span>
                        </div>
                    </div>

                    <!-- Features -->
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-codeflix-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-check text-codeflix-primary text-sm"></i>
                            </div>
                            <span class="text-gray-300">
                                <span class="font-semibold text-white">{{ $plan->resolution }}</span> streaming quality
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-codeflix-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-check text-codeflix-primary text-sm"></i>
                            </div>
                            <span class="text-gray-300">
                                Watch on <span class="font-semibold text-white">{{ $plan->max_devices }} devices</span> at a time
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-codeflix-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-check text-codeflix-primary text-sm"></i>
                            </div>
                            <span class="text-gray-300">Mobile, Computer, TV supported</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-codeflix-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-check text-codeflix-primary text-sm"></i>
                            </div>
                            <span class="text-gray-300">Cancel anytime</span>
                        </li>
                        @if($plan->resolution === '4K+HDR')
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 bg-yellow-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-crown text-yellow-500 text-sm"></i>
                            </div>
                            <span class="text-gray-300">HDR & Dolby Vision</span>
                        </li>
                        @endif
                    </ul>

                    <!-- CTA Button -->
                    <a href="{{ route('subscribe.checkout', $plan) }}" 
                       class="block w-full py-4 rounded-xl font-semibold text-center transition {{ $index === 1 ? 'bg-codeflix-primary hover:bg-codeflix-primary/80 text-white' : 'bg-white hover:bg-gray-100 text-black' }}">
                        Choose {{ $plan->title }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="font-outfit text-2xl font-bold text-white text-center mb-8">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-codeflix-card rounded-xl overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-medium text-white">Can I change or cancel my plan anytime?</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition" :class="open && 'rotate-180'"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-5 pb-5 text-gray-400">
                        Yes! You can upgrade, downgrade, or cancel your subscription at any time. Changes will take effect at the start of your next billing period.
                    </div>
                </div>
                <div class="bg-codeflix-card rounded-xl overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-medium text-white">What payment methods do you accept?</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition" :class="open && 'rotate-180'"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-5 pb-5 text-gray-400">
                        We accept various payment methods including credit/debit cards, bank transfers, and e-wallets through our secure payment partner Midtrans.
                    </div>
                </div>
                <div class="bg-codeflix-card rounded-xl overflow-hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-medium text-white">How many profiles can I create?</span>
                        <i class="fa-solid fa-chevron-down text-gray-400 transition" :class="open && 'rotate-180'"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-5 pb-5 text-gray-400">
                        You can create up to 5 profiles per account, each with their own personalized recommendations and watch history.
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to browsing
            </a>
        </div>
    </div>
</div>
@endsection
