@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="font-outfit text-3xl font-bold text-white mb-8">Pengaturan Akun</h1>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 bg-codeflix-primary/20 text-codeflix-primary rounded-xl font-medium">
                        <i class="fa-solid fa-user w-5"></i> Profil
                    </a>
                    <a href="{{ route('settings.security') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-shield w-5"></i> Keamanan
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Profile Picture -->
                <div class="bg-codeflix-card rounded-2xl p-6">
                    <h2 class="font-semibold text-white mb-4">Foto Profil</h2>
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center text-3xl font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <button class="absolute bottom-0 right-0 w-8 h-8 bg-codeflix-primary rounded-full flex items-center justify-center text-white shadow-lg">
                                <i class="fa-solid fa-camera text-sm"></i>
                            </button>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
                            <button class="mt-2 text-sm text-codeflix-primary hover:underline">Ubah avatar</button>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-codeflix-card rounded-2xl p-6 space-y-6">
                        <h2 class="font-semibold text-white">Informasi Pribadi</h2>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Alamat Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" value="{{ auth()->user()->nik }}" maxlength="16"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary"
                                       placeholder="16 digit angka NIK">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Tanggal Lahir</label>
                                <input type="date" name="birth_date" value="{{ auth()->user()->birth_date ? auth()->user()->birth_date->format('Y-m-d') : '' }}"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                        </div>

                        @if(auth()->user()->age_category)
                        <div class="bg-codeflix-primary/10 border border-codeflix-primary/30 rounded-xl p-4 flex items-center justify-between">
                            <div class="flex items-center gap-3 text-gray-300">
                                <i class="fa-solid fa-cake-candles text-codeflix-primary"></i>
                                <span>Kategori Usia Anda: <strong class="text-white uppercase">{{ auth()->user()->age_category }}</strong></span>
                            </div>
                            <span class="text-sm text-gray-500">{{ auth()->user()->age }} Tahun</span>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                   class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-3 rounded-xl transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>


                <!-- Danger Zone -->
                <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6">
                    <h2 class="font-semibold text-red-400 mb-4">Zona Berbahaya</h2>
                    <p class="text-gray-400 text-sm mb-4">Setelah Anda menghapus akun, tidak bisa dikembalikan. Harap pastikan.</p>
                    <button class="bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white font-medium px-6 py-3 rounded-xl transition">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
