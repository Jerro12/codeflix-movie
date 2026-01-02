<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;

class SettingsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['auth'];
    }

    /**
     * Show settings index page
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show security settings page
     */
    public function security()
    {
        return view('settings.security');
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->update($request->only(['name', 'email', 'phone']));

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Show user viewing stats
     */
    public function stats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_watched' => $user->watchHistory()->count(),
            'completed' => $user->watchHistory()->where('is_completed', true)->count(),
            'total_hours' => $user->watchHistory()->with('movie')
                ->get()
                ->sum(fn($h) => ($h->movie->duration ?? 0) * ($h->progress / 100)) / 60,
            'favorite_genre' => 'Action', // TODO: Calculate from watch history
        ];

        return view('stats.index', compact('stats'));
    }
}
