@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-codeflix-card/80 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-gray-800">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix" class="h-10 mx-auto mb-4">
                </a>
                <h1 class="font-outfit text-2xl font-bold text-white">Create Account</h1>
                <p class="text-gray-400 mt-2">Start your streaming journey today</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Full Name
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition @error('name') border-red-500 @enderror"
                               placeholder="John Doe">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition @error('email') border-red-500 @enderror"
                               placeholder="your@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition @error('password') border-red-500 @enderror"
                               placeholder="Min. 8 characters">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Confirm Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                               placeholder="Repeat password">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-2">
                    <input type="checkbox" name="terms" required class="mt-1 rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                    <span class="text-sm text-gray-400">
                        I agree to the <a href="#" class="text-codeflix-primary hover:underline">Terms of Service</a> and <a href="#" class="text-codeflix-primary hover:underline">Privacy Policy</a>
                    </span>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-700"></div>
                <span class="text-gray-500 text-sm">or sign up with</span>
                <div class="flex-1 h-px bg-gray-700"></div>
            </div>

            <!-- Social Register -->
            <div class="flex gap-4">
                <button class="flex-1 flex items-center justify-center gap-2 bg-codeflix-dark hover:bg-gray-800 border border-gray-700 rounded-xl py-3 text-white transition">
                    <i class="fa-brands fa-google text-lg"></i>
                    Google
                </button>
                <button class="flex-1 flex items-center justify-center gap-2 bg-codeflix-dark hover:bg-gray-800 border border-gray-700 rounded-xl py-3 text-white transition">
                    <i class="fa-brands fa-github text-lg"></i>
                    GitHub
                </button>
            </div>

            <!-- Login Link -->
            <p class="text-center text-gray-400 mt-8">
                Already have an account?
                <a href="{{ route('login') }}" class="text-codeflix-primary hover:underline font-medium">
                    Sign in
                </a>
            </p>
        </div>

        <!-- Back to home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-white text-sm transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to home
            </a>
        </div>
    </div>
</div>
@endsection
