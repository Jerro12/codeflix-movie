@extends('layouts.app')

@section('title', 'Maintenance Mode')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-lg">
        <!-- Animated Icon -->
        <div class="mb-8">
            <div class="relative inline-block">
                <div class="w-32 h-32 bg-gradient-to-br from-codeflix-primary/20 to-codeflix-primary/5 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-tools text-5xl text-codeflix-primary animate-pulse"></i>
                </div>
                <!-- Spinning ring -->
                <div class="absolute inset-0 border-4 border-codeflix-primary/30 border-t-codeflix-primary rounded-full animate-spin"></div>
            </div>
        </div>
        
        <h2 class="font-outfit text-3xl font-bold text-white mb-4">
            We'll Be Right Back!
        </h2>
        <p class="text-gray-400 mb-8 text-lg">
            Codeflix is currently undergoing scheduled maintenance. We're making improvements to give you an even better streaming experience.
        </p>
        
        <!-- Estimated Time -->
        <div class="bg-codeflix-card rounded-xl p-6 mb-8">
            <div class="flex items-center justify-center gap-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="hours">00</div>
                    <div class="text-sm text-gray-500">Hours</div>
                </div>
                <div class="text-2xl text-gray-600">:</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="minutes">30</div>
                    <div class="text-sm text-gray-500">Minutes</div>
                </div>
                <div class="text-2xl text-gray-600">:</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="seconds">00</div>
                    <div class="text-sm text-gray-500">Seconds</div>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-4">Estimated time remaining</p>
        </div>
        
        <!-- Social Links -->
        <p class="text-gray-400 mb-4">Stay updated on our progress:</p>
        <div class="flex items-center justify-center gap-4">
            <a href="#" class="w-12 h-12 bg-codeflix-card hover:bg-[#1DA1F2] rounded-full flex items-center justify-center transition">
                <i class="fa-brands fa-twitter text-xl"></i>
            </a>
            <a href="#" class="w-12 h-12 bg-codeflix-card hover:bg-[#E4405F] rounded-full flex items-center justify-center transition">
                <i class="fa-brands fa-instagram text-xl"></i>
            </a>
            <a href="#" class="w-12 h-12 bg-codeflix-card hover:bg-[#4267B2] rounded-full flex items-center justify-center transition">
                <i class="fa-brands fa-facebook text-xl"></i>
            </a>
        </div>
    </div>
</div>

<script>
// Simple countdown timer (30 minutes from now)
let totalSeconds = 30 * 60;
const timer = setInterval(() => {
    totalSeconds--;
    if (totalSeconds <= 0) {
        clearInterval(timer);
        location.reload();
    }
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;
    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
}, 1000);
</script>
@endsection
