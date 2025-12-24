@extends('admin.layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-white" style="font-family: 'Kanit', sans-serif; font-size: 32px;">Dashboard</h1>
    <p class="text-muted">Welcome to Codeflix Admin Panel</p>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="admin-stat-info">
                <h3>{{ number_format($stats['total_users']) }}</h3>
                <p>Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon">
                <i class="fa-solid fa-film"></i>
            </div>
            <div class="admin-stat-info">
                <h3>{{ number_format($stats['total_movies']) }}</h3>
                <p>Total Movies</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="admin-stat-info">
                <h3>{{ number_format($stats['active_subscriptions']) }}</h3>
                <p>Active Subscriptions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stat-card">
            <div class="admin-stat-icon">
                <i class="fa-solid fa-rupiah-sign"></i>
            </div>
            <div class="admin-stat-info">
                <h3>{{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                <p>Total Revenue (IDR)</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-md-7">
        <div class="card" style="background: var(--codeflix-bg-card); border: none; border-radius: 12px;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h5 class="text-white mb-0">Recent Transactions</h5>
            </div>
            <div class="card-body p-0">
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->plan->title ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No transactions yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-md-5">
        <div class="card" style="background: var(--codeflix-bg-card); border: none; border-radius: 12px;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h5 class="text-white mb-0">Recent Users</h5>
            </div>
            <div class="card-body p-0">
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                                @if($user->is_admin)
                                    <span class="badge-admin badge-admin-primary">Admin</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No users yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
