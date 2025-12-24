<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::withCount('memberships')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Display user details.
     */
    public function show(User $user)
    {
        $user->load(['memberships.plan', 'watchlist.movie', 'watchHistory.movie']);

        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Toggle admin status for a user.
     */
    public function toggleAdmin(User $user)
    {
        $user->update([
            'is_admin' => !$user->is_admin,
        ]);

        $status = $user->is_admin ? 'granted' : 'revoked';

        return back()->with('success', "Admin access {$status} for {$user->name}.");
    }
}
