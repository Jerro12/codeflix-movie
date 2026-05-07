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
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('name') ? 'border-red-500' : 'border-gray-700' }}"
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
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }}"
                               placeholder="your@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK & Birth Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-300 mb-2">
                            NIK (16 Digits)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fa-solid fa-id-card"></i>
                            </span>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16"
                                   class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('nik') ? 'border-red-500' : 'border-gray-700' }}"
                                   placeholder="NIK">
                        </div>
                        @error('nik')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-300 mb-2">
                            Birth Date
                        </label>
                        <div class="relative">
                            <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required
                                   class="w-full bg-codeflix-dark border rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('birth_date') ? 'border-red-500' : 'border-gray-700' }}">
                        </div>
                        @error('birth_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
