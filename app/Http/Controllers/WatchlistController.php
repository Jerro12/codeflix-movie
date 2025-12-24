<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Display the user's watchlist.
     */
    public function index()
    {
        $watchlistItems = Auth::user()
            ->watchlist()
            ->with('movie')
            ->latest()
            ->get();

        return view('watchlist.index', [
            'watchlistItems' => $watchlistItems,
        ]);
    }

    /**
     * Toggle a movie in the user's watchlist.
     */
    public function toggle(Movie $movie)
    {
        $user = Auth::user();
        $existing = Watchlist::where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $inWatchlist = false;
            $message = 'Removed from My List';
        } else {
            Watchlist::create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);
            $inWatchlist = true;
            $message = 'Added to My List';
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'in_watchlist' => $inWatchlist,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Check if a movie is in the user's watchlist.
     */
    public function check(Movie $movie)
    {
        $inWatchlist = Auth::user()->hasInWatchlist($movie->id);

        return response()->json([
            'in_watchlist' => $inWatchlist,
        ]);
    }
}
