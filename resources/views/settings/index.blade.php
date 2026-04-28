@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="font-outfit text-3xl font-bold text-white mb-8">Account Settings</h1>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 bg-codeflix-primary/20 text-codeflix-primary rounded-xl font-medium">
                        <i class="fa-solid fa-user w-5"></i> Profile
                    </a>
                    <a href="{{ route('settings.security') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-shield w-5"></i> Security
                    </a>
                    <a href="{{ route('profiles.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-users w-5"></i> Profiles
                    </a>
                    <a href="{{ route('referral.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-gift w-5"></i> Referrals
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Profile Picture -->
                <div class="bg-codeflix-card rounded-2xl p-6">
                    <h2 class="font-semibold text-white mb-4">Profile Picture</h2>
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
                            <button class="mt-2 text-sm text-codeflix-primary hover:underline">Change avatar</button>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="bg-codeflix-card rounded-2xl p-6 space-y-6">
                        <h2 class="font-semibold text-white">Personal Information</h2>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                   class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-3 rounded-xl transition">
                            Save Changes
                        </button>
                    </div>
                </form>

                <!-- Preferences -->
                <div class="bg-codeflix-card rounded-2xl p-6 space-y-6">
                    <h2 class="font-semibold text-white">Preferences</h2>

                    <div class="space-y-4">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <p class="text-white font-medium">Email Notifications</p>
                                <p class="text-sm text-gray-400">Receive updates about new releases</p>
                            </div>
                            <input type="checkbox" class="w-5 h-5 rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                        </label>

                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <p class="text-white font-medium">Autoplay Next Episode</p>
                                <p class="text-sm text-gray-400">Automatically play next episode in series</p>
                            </div>
                            <input type="checkbox" checked class="w-5 h-5 rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                        </label>

                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <p class="text-white font-medium">Autoplay Previews</p>
                                <p class="text-sm text-gray-400">Play trailers while browsing</p>
                            </div>
                            <input type="checkbox" checked class="w-5 h-5 rounded border-gray-700 bg-codeflix-dark text-codeflix-primary focus:ring-codeflix-primary">
                        </label>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6">
                    <h2 class="font-semibold text-red-400 mb-4">Danger Zone</h2>
                    <p class="text-gray-400 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    <button class="bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white font-medium px-6 py-3 rounded-xl transition">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
