@extends('admin.layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-white" style="font-family: 'Kanit', sans-serif; font-size: 32px;">Users</h1>
    <p class="text-muted">Manage all registered users</p>
</div>

<div class="card" style="background: var(--codeflix-bg-card); border: none; border-radius: 12px;">
    <div class="card-body p-0">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Memberships</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->memberships_count }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge-admin badge-admin-primary">Admin</span>
                        @else
                            <span class="badge-admin badge-admin-warning">User</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="admin-table-actions">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-admin-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-admin-danger' : 'btn-admin-primary' }}"
                                        title="{{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}">
                                    <i class="fa-solid {{ $user->is_admin ? 'fa-user-minus' : 'fa-user-shield' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>
@endsection
