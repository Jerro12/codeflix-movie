@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="bg-codeflix-card/80 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-gray-800">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-codeflix-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-lock-open text-2xl text-codeflix-primary"></i>
                </div>
                <h1 class="font-outfit text-2xl font-bold text-white">Reset Password</h1>
                <p class="text-gray-400 mt-2">Create a new secure password for your account</p>
            </div>

            <!-- Form -->
            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required
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
                        New Password
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
                        Confirm New Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                               placeholder="Repeat new password">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
