@extends('layouts.app')

@section('title', 'Daftar Akun')

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
                <h1 class="font-outfit text-2xl font-bold text-white">Daftar Akun</h1>
                <p class="text-gray-400 mt-2">Mulai perjalanan streaming Anda hari ini</p>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('name') ? 'border-red-500' : 'border-gray-700' }}"
                               placeholder="Nama Lengkap">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }}"
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK & Birth Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-300 mb-2">
                            NIK (16 Digit)
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
                            Tanggal Lahir
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
                        Kata Sandi
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                               class="w-full bg-codeflix-dark border rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition {{ $errors->has('password') ? 'border-red-500' : 'border-gray-700' }}"
                               placeholder="Min. 8 karakter">
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
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                               class="w-full bg-codeflix-dark border border-gray-700 rounded-xl pl-12 pr-12 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                               placeholder="Ulangi kata sandi">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-2">
                    <input type="checkbox" name="terms" required class="mt-1 rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                    <span class="text-sm text-gray-400">
                        Saya setuju dengan <a href="#" class="text-codeflix-primary hover:underline">Ketentuan Layanan</a> dan <a href="#" class="text-codeflix-primary hover:underline">Kebijakan Privasi</a>
                    </span>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    Daftar Akun
                </button>
            </form>



            <!-- Login Link -->
            <p class="text-center text-gray-400 mt-8">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-codeflix-primary hover:underline font-medium">
                    Masuk
                </a>
            </p>
        </div>

        <!-- Back to home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-white text-sm transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke beranda
            </a>
        </div>
    </div>
</div>
@endsection
