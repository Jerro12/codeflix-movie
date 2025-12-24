<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    /**
     * Get all movies with pagination.
     */
    public function index(Request $request)
    {
        $movies = Cache::remember('api.movies.page.' . $request->get('page', 1), 300, function () use ($request) {
            return Movie::with('categories')
                ->when($request->category, function ($q) use ($request) {
                    $q->whereHas('categories', fn($q) => $q->where('slug', $request->category));
                })
                ->when($request->year, function ($q) use ($request) {
                    $q->whereYear('release_date', $request->year);
                })
                ->when($request->sort === 'rating', function ($q) {
                    $q->orderByDesc('average_rating');
                })
                ->when($request->sort === 'newest', function ($q) {
                    $q->orderByDesc('release_date');
                })
                ->latest()
                ->paginate(20);
        });

        return response()->json($movies);
    }

    /**
     * Get a single movie.
     */
    public function show(Movie $movie)
    {
        $movie->load(['categories', 'reviews.user']);

        return response()->json([
            'movie' => $movie,
        ]);
    }

    /**
     * Search movies.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $movies = Movie::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('categories')
            ->limit(20)
            ->get();

        return response()->json([
            'movies' => $movies,
        ]);
    }

    /**
     * Get recommendations for authenticated user.
     */
    public function recommendations(Request $request)
    {
        $user = $request->user();
        
        // Get user's watched movie categories
        $watchedCategories = $user->watchHistory()
            ->with('movie.categories')
            ->get()
            ->pluck('movie.categories')
            ->flatten()
            ->pluck('id')
            ->unique();

        // Get movies from those categories that user hasn't watched
        $watchedMovieIds = $user->watchHistory()->pluck('movie_id');

        $recommendations = Movie::whereHas('categories', function ($q) use ($watchedCategories) {
                $q->whereIn('categories.id', $watchedCategories);
            })
            ->whereNotIn('id', $watchedMovieIds)
            ->orderByDesc('average_rating')
            ->limit(10)
            ->get();

        return response()->json([
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Get all categories.
     */
    public function categories()
    {
        $categories = Cache::remember('api.categories', 3600, function () {
            return Category::withCount('movies')->get();
        });

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
