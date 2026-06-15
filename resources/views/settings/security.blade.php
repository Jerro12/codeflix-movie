@extends('layouts.app')

@section('title', 'Pengaturan Keamanan')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="font-outfit text-3xl font-bold text-white mb-8">Pengaturan Akun</h1>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-user w-5"></i> Profil
                    </a>
                    <a href="{{ route('settings.security') }}" class="flex items-center gap-3 px-4 py-3 bg-codeflix-primary/20 text-codeflix-primary rounded-xl font-medium">
                        <i class="fa-solid fa-shield w-5"></i> Keamanan
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Change Password -->
                <form action="{{ route('user-password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-codeflix-card rounded-2xl p-6 space-y-6">
                        <h2 class="font-semibold text-white flex items-center gap-2">
                            <i class="fa-solid fa-key text-codeflix-primary"></i> Ganti Kata Sandi
                        </h2>

                        @if (session('status') === 'password-updated')
                            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                <span>Kata sandi berhasil diperbarui!</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required
                                   class="w-full bg-codeflix-dark border {{ $errors->updatePassword->has('current_password') ? 'border-red-500' : 'border-gray-700' }} rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            @error('current_password', 'updatePassword')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password" required
                                       class="w-full bg-codeflix-dark border {{ $errors->updatePassword->has('password') ? 'border-red-500' : 'border-gray-700' }} rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                                @error('password', 'updatePassword')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                        </div>

                        <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-3 rounded-xl transition">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
