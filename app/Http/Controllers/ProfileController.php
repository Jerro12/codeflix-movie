<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display profile selection page.
     */
    public function index()
    {
        $profiles = Auth::user()->profiles;

        return view('profiles.index', [
            'profiles' => $profiles,
        ]);
    }

    /**
     * Show form to create a new profile.
     */
    public function create()
    {
        // Check max profiles (max 5)
        if (Auth::user()->profiles()->count() >= 5) {
            return back()->with('error', 'Maximum 5 profiles allowed.');
        }

        return view('profiles.create');
    }

    /**
     * Store a new profile.
     */
    public function store(Request $request)
    {
        if (Auth::user()->profiles()->count() >= 5) {
            return back()->with('error', 'Maximum 5 profiles allowed.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_kids' => 'boolean',
            'pin' => 'nullable|string|size:4',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_kids'] = $request->boolean('is_kids');

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully!');
    }

    /**
     * Switch to a specific profile.
     */
    public function switch(Request $request, Profile $profile)
    {
        if ($profile->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate PIN if set
        if ($profile->pin) {
            $request->validate(['pin' => 'required|string|size:4']);
            
            if ($profile->pin !== $request->pin) {
                return back()->with('error', 'Invalid PIN.');
            }
        }

        Auth::user()->update(['active_profile_id' => $profile->id]);

        return redirect()->route('home')->with('success', "Switched to {$profile->name}'s profile.");
    }

    /**
     * Delete a profile.
     */
    public function destroy(Profile $profile)
    {
        if ($profile->user_id !== Auth::id()) {
            abort(403);
        }

        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully!');
    }
}
