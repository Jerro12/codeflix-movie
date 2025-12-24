<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for a movie.
     */
    public function store(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:5000',
            'spoiler_warning' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['movie_id'] = $movie->id;
        $validated['spoiler_warning'] = $request->boolean('spoiler_warning');

        // Check if user already reviewed this movie
        $existing = Review::where('user_id', Auth::id())
            ->where('movie_id', $movie->id)
            ->first();

        if ($existing) {
            $existing->update($validated);
            return back()->with('success', 'Review updated successfully!');
        }

        Review::create($validated);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Mark a review as helpful.
     */
    public function helpful(Review $review)
    {
        $review->increment('helpful_count');

        if (request()->ajax()) {
            return response()->json([
                'helpful_count' => $review->helpful_count,
            ]);
        }

        return back();
    }
}
