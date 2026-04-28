<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Membership;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_movies' => Movie::count(),
            'total_categories' => \App\Models\Category::count(),
            'total_reviews' => \App\Models\Review::count(),
        ];

        $recentTransactions = Transaction::with('user', 'plan')
            ->where('payment_status', 'success')
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'recentUsers' => $recentUsers,
        ]);
    }
}
