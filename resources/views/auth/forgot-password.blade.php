@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-codeflix-card/80 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-gray-800">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-codeflix-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-key text-2xl text-codeflix-primary"></i>
                </div>
                <h1 class="font-outfit text-2xl font-bold text-white">Forgot Password?</h1>
                <p class="text-gray-400 mt-2">No worries! Enter your email and we'll send you reset instructions.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl mb-6">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition @error('email') border-red-500 @enderror"
                               placeholder="your@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Reset Link
                </button>
            </form>

            <!-- Back to login -->
            <div class="text-center mt-8">
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-white text-sm transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Sign In
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
