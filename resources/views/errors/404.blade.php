@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="text-center max-w-lg">
        <!-- Animated 404 -->
        <div class="relative mb-8">
            <h1 class="font-outfit text-[150px] md:text-[200px] font-bold text-gray-800 leading-none select-none">
                404
            </h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fa-solid fa-face-sad-tear text-6xl md:text-8xl text-codeflix-primary animate-bounce"></i>
            </div>
        </div>
        
        <h2 class="font-outfit text-3xl font-bold text-white mb-4">
            Oops! Page Not Found
        </h2>
        <p class="text-gray-400 mb-8 text-lg">
            The page you're looking for doesn't exist or has been moved. 
            Maybe try searching for what you need?
        </p>
        
        <!-- Search Box -->
        <div class="mb-8">
            <form action="{{ route('movies.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" placeholder="Search movies, series..." 
                       class="flex-1 bg-codeflix-card border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-black font-semibold px-8 py-3 rounded-lg transition">
                <i class="fa-solid fa-home"></i> Back to Home
            </a>
            <button onclick="history.back()" 
                    class="inline-flex items-center gap-2 bg-codeflix-card hover:bg-gray-700 text-white font-semibold px-8 py-3 rounded-lg border border-gray-700 transition">
                <i class="fa-solid fa-arrow-left"></i> Go Back
            </button>
        </div>
        
        <!-- Quick Links -->
        <div class="mt-12 pt-8 border-t border-gray-800">
            <p class="text-gray-500 mb-4">Popular destinations:</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('movies.index') }}" class="px-4 py-2 bg-codeflix-card rounded-full text-sm text-gray-300 hover:bg-codeflix-primary hover:text-white transition">
                    Browse Movies
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
