<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get all profiles for the authenticated user.
     */
    public function index(Request $request)
    {
        $profiles = $request->user()->profiles;

        return response()->json([
            'profiles' => $profiles,
        ]);
    }

    /**
     * Create a new profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|url',
            'is_kids' => 'boolean',
            'pin' => 'nullable|string|size:4',
        ]);

        $validated['user_id'] = $request->user()->id;

        $profile = Profile::create($validated);

        return response()->json([
            'profile' => $profile,
        ], 201);
    }

    /**
     * Switch to a profile.
     */
    public function switch(Request $request, Profile $profile)
    {
        // Validate PIN if set
        if ($profile->pin && $profile->pin !== $request->pin) {
            return response()->json([
                'message' => 'Invalid PIN',
            ], 403);
        }

        $request->user()->update([
            'active_profile_id' => $profile->id,
        ]);

        return response()->json([
            'message' => 'Profile switched successfully',
            'profile' => $profile,
        ]);
    }

    /**
     * Update a profile.
     */
    public function update(Request $request, Profile $profile)
    {
        if ($profile->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'avatar' => 'nullable|url',
            'is_kids' => 'sometimes|boolean',
            'pin' => 'nullable|string|size:4',
        ]);

        $profile->update($validated);

        return response()->json([
            'profile' => $profile,
        ]);
    }

    /**
     * Delete a profile.
     */
    public function destroy(Request $request, Profile $profile)
    {
        if ($profile->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $profile->delete();

        return response()->json([
            'message' => 'Profile deleted successfully',
        ]);
    }
}
