@extends('admin.layouts.admin')

@section('title', 'Users')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-400">Manage all registered users</p>
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-400">{{ $users->total() }} total users</span>
    </div>
</div>

<!-- Users Table -->
<div class="bg-codeflix-card rounded-xl border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-codeflix-darker">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Subscription</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($users as $user)
                <tr class="hover:bg-codeflix-darker/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-codeflix-primary/20 rounded-full flex items-center justify-center">
                                <span class="text-codeflix-primary font-semibold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ $user->name }}</p>
                                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_admin)
                            <span class="px-2 py-1 bg-purple-500/20 text-purple-400 text-xs rounded font-medium">Admin</span>
                        @else
                            <span class="px-2 py-1 bg-gray-500/20 text-gray-400 text-xs rounded">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->activeMembership)
                            <span class="px-2 py-1 bg-codeflix-primary/20 text-codeflix-primary text-xs rounded">
                                {{ $user->activeMembership->plan->name ?? 'Active' }}
                            </span>
                        @else
                            <span class="text-gray-500 text-sm">No subscription</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-yellow-500 hover:bg-yellow-500/10 rounded-lg transition"
                                        title="{{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}">
                                    <i class="fa-solid {{ $user->is_admin ? 'fa-user-minus' : 'fa-user-plus' }}"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="p-2 text-gray-400 hover:text-codeflix-primary hover:bg-codeflix-primary/10 rounded-lg transition">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-users text-4xl mb-4 text-gray-600"></i>
                        <p>No users found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-800">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
