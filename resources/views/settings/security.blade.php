@extends('layouts.app')

@section('title', 'Security Settings')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="font-outfit text-3xl font-bold text-white mb-8">Account Settings</h1>

        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <nav class="space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-codeflix-card rounded-xl transition">
                        <i class="fa-solid fa-user w-5"></i> Profile
                    </a>
                    <a href="{{ route('settings.security') }}" class="flex items-center gap-3 px-4 py-3 bg-codeflix-primary/20 text-codeflix-primary rounded-xl font-medium">
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
                <!-- Change Password -->
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-codeflix-card rounded-2xl p-6 space-y-6">
                        <h2 class="font-semibold text-white flex items-center gap-2">
                            <i class="fa-solid fa-key text-codeflix-primary"></i> Change Password
                        </h2>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                   class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">New Password</label>
                                <input type="password" name="password" required
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full bg-codeflix-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                            </div>
                        </div>

                        <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-3 rounded-xl transition">
                            Update Password
                        </button>
                    </div>
                </form>

                <!-- Two-Factor Authentication -->
                <div class="bg-codeflix-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="font-semibold text-white flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-codeflix-primary"></i> Two-Factor Authentication
                            </h2>
                            <p class="text-sm text-gray-400 mt-1">Add an extra layer of security to your account</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-medium">
                            Disabled
                        </span>
                    </div>

                    <button class="bg-codeflix-dark hover:bg-gray-800 text-white font-medium px-6 py-3 rounded-xl border border-gray-700 transition">
                        Enable 2FA
                    </button>
                </div>

                <!-- Connected Devices -->
                <div class="bg-codeflix-card rounded-2xl p-6">
                    <h2 class="font-semibold text-white flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-laptop text-codeflix-primary"></i> Connected Devices
                    </h2>

                    <div class="space-y-4">
                        <!-- Current Device -->
                        <div class="flex items-center justify-between p-4 bg-codeflix-dark rounded-xl border border-codeflix-primary/30">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-codeflix-primary/20 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-desktop text-codeflix-primary"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Windows PC - Chrome</p>
                                    <p class="text-sm text-gray-400">Active now · This device</p>
                                </div>
                            </div>
                            <span class="text-green-400 text-sm"><i class="fa-solid fa-circle text-xs mr-1"></i> Active</span>
                        </div>

                        <!-- Other Devices -->
                        <div class="flex items-center justify-between p-4 bg-codeflix-dark rounded-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-mobile text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">iPhone 14 - Safari</p>
                                    <p class="text-sm text-gray-400">Last active 2 hours ago</p>
                                </div>
                            </div>
                            <button class="text-red-400 hover:text-red-300 text-sm">Logout</button>
                        </div>
                    </div>

                    <button class="mt-4 text-red-400 hover:text-red-300 font-medium text-sm">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Sign out all other devices
                    </button>
                </div>

                <!-- Login Activity -->
                <div class="bg-codeflix-card rounded-2xl p-6">
                    <h2 class="font-semibold text-white flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-clock-rotate-left text-codeflix-primary"></i> Recent Login Activity
                    </h2>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-3 border-b border-gray-800">
                            <div>
                                <p class="text-white">Windows PC - Chrome</p>
                                <p class="text-sm text-gray-400">Jakarta, Indonesia</p>
                            </div>
                            <p class="text-sm text-gray-400">Just now</p>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-800">
                            <div>
                                <p class="text-white">iPhone - Safari</p>
                                <p class="text-sm text-gray-400">Jakarta, Indonesia</p>
                            </div>
                            <p class="text-sm text-gray-400">2 hours ago</p>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-white">Android - Chrome</p>
                                <p class="text-sm text-gray-400">Bandung, Indonesia</p>
                            </div>
                            <p class="text-sm text-gray-400">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
