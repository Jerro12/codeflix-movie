<?php

namespace App\Http\Controllers;

use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    /**
     * Display watch history page
     */
    public function index()
    {
        $history = Auth::user()
            ->watchHistory()
            ->with('movie')
            ->orderBy('last_watched_at', 'desc')
            ->paginate(20);

        return view('history.index', compact('history'));
    }

    /**
     * Update watch progress for a movie.
     */
    public function updateProgress(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'progress_seconds' => 'required|integer|min:0',
            'duration_seconds' => 'required|integer|min:0',
        ]);

        $user = Auth::user();

        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => $user->id,
                'movie_id' => $request->movie_id,
            ],
            [
                'progress_seconds' => $request->progress_seconds,
                'duration_seconds' => $request->duration_seconds,
                'completed' => $request->progress_seconds >= ($request->duration_seconds * 0.9),
                'last_watched_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'progress_percentage' => $history->progress_percentage,
        ]);
    }

    /**
     * Get continue watching movies for the homepage.
     */
    public function getContinueWatching()
    {
        $continueWatching = Auth::user()
            ->watchHistory()
            ->with('movie')
            ->where('completed', false)
            ->where('progress_seconds', '>', 0)
            ->orderBy('last_watched_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'items' => $continueWatching,
        ]);
    }

    /**
     * Remove item from history
     */
    public function destroy(WatchHistory $history)
    {
        if ($history->user_id !== Auth::id()) {
            abort(403);
        }

        $history->delete();

        return response()->json(['success' => true]);
    }
}
