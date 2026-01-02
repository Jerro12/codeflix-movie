@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-lg">
        <!-- Animated 500 -->
        <div class="relative mb-8">
            <h1 class="font-outfit text-[150px] md:text-[200px] font-bold text-gray-800 leading-none select-none">
                500
            </h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fa-solid fa-server text-6xl md:text-8xl text-red-500 animate-pulse"></i>
            </div>
        </div>
        
        <h2 class="font-outfit text-3xl font-bold text-white mb-4">
            Internal Server Error
        </h2>
        <p class="text-gray-400 mb-8 text-lg">
            Something went wrong on our end. Don't worry, our team has been notified and we're working on it!
        </p>
        
        <!-- Status Info -->
        <div class="bg-codeflix-card rounded-xl p-6 mb-8 text-left">
            <div class="flex items-center gap-3 text-red-400 mb-4">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <span class="font-medium">Error Details</span>
            </div>
            <div class="space-y-2 text-sm text-gray-400">
                <p><span class="text-gray-500">Time:</span> {{ now()->format('Y-m-d H:i:s') }}</p>
                <p><span class="text-gray-500">Request ID:</span> {{ Str::uuid()->toString() }}</p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-black font-semibold px-8 py-3 rounded-lg transition">
                <i class="fa-solid fa-home"></i> Back to Home
            </a>
            <button onclick="location.reload()" 
                    class="inline-flex items-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold px-8 py-3 rounded-lg transition">
                <i class="fa-solid fa-refresh"></i> Try Again
            </button>
        </div>
    </div>
</div>
@endsection
