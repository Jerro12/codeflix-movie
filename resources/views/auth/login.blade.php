@extends('layouts.app')

@section('title', 'Sign In')

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
                <h1 class="font-outfit text-2xl font-bold text-white">Welcome Back</h1>
                <p class="text-gray-400 mt-2">Sign in to continue watching</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
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
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }}"
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
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('password') ? 'border-red-500' : 'border-gray-700' }}"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-codeflix-primary hover:underline">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Sign In
                </button>
            </form>



            <!-- Register Link -->
            <p class="text-center text-gray-400 mt-8">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-codeflix-primary hover:underline font-medium">
                    Sign up free
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
