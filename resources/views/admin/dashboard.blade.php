@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-users text-blue-500 text-xl"></i>
            </div>
            <span class="text-green-400 text-sm flex items-center gap-1">
                <i class="fa-solid fa-arrow-up text-xs"></i> 12%
            </span>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['users'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Users</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-film text-purple-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['movies'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Movies</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-codeflix-primary/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-credit-card text-codeflix-primary text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['subscriptions'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Active Subscriptions</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-dollar-sign text-yellow-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">Rp {{ number_format($stats['revenue'] ?? 0) }}</h3>
        <p class="text-gray-400 text-sm">Total Revenue</p>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-codeflix-card rounded-xl border border-gray-800">
        <div class="p-6 border-b border-gray-800">
            <h2 class="font-outfit text-lg font-semibold">Recent Users</h2>
        </div>
        <div class="p-6">
            @forelse($recentUsers ?? [] as $user)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-800' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-codeflix-primary/20 rounded-full flex items-center justify-center">
                        <span class="text-codeflix-primary font-semibold">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>
                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-4">No recent users</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-codeflix-card rounded-xl border border-gray-800">
        <div class="p-6 border-b border-gray-800">
            <h2 class="font-outfit text-lg font-semibold">Recent Transactions</h2>
        </div>
        <div class="p-6">
            @forelse($recentTransactions ?? [] as $transaction)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-800' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-check text-green-500"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $transaction->user->name ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-400">{{ $transaction->plan->name ?? 'Unknown Plan' }}</p>
                    </div>
                </div>
                <span class="text-codeflix-primary font-semibold">Rp {{ number_format($transaction->amount ?? 0) }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-4">No recent transactions</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
