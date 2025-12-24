<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use App\Models\WatchHistory;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    /**
     * Get user's watchlist.
     */
    public function index(Request $request)
    {
        $watchlist = $request->user()
            ->watchlist()
            ->with('movie')
            ->latest()
            ->get();

        return response()->json([
            'watchlist' => $watchlist,
        ]);
    }

    /**
     * Add movie to watchlist.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
        ]);

        $watchlist = Watchlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'movie_id' => $request->movie_id,
        ]);

        return response()->json([
            'message' => 'Added to watchlist',
            'watchlist' => $watchlist->load('movie'),
        ], 201);
    }

    /**
     * Remove movie from watchlist.
     */
    public function destroy(Request $request, $movieId)
    {
        Watchlist::where('user_id', $request->user()->id)
            ->where('movie_id', $movieId)
            ->delete();

        return response()->json([
            'message' => 'Removed from watchlist',
        ]);
    }

    /**
     * Get continue watching list.
     */
    public function continueWatching(Request $request)
    {
        $history = $request->user()
            ->watchHistory()
            ->with('movie')
            ->where('completed', false)
            ->where('progress_seconds', '>', 0)
            ->orderByDesc('last_watched_at')
            ->limit(10)
            ->get();

        return response()->json([
            'continue_watching' => $history,
        ]);
    }

    /**
     * Update watch progress.
     */
    public function updateProgress(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'progress_seconds' => 'required|integer|min:0',
            'duration_seconds' => 'required|integer|min:0',
        ]);

        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
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
            'history' => $history,
        ]);
    }
}
