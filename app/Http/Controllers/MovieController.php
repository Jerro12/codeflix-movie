<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;

class MovieController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'auth',
            'check.device.limit',
        ];
    }

    public function index() 
    {
        $newAddedMovies = Movie::latest()->limit(12)->get();
        $topRatedMovies = Movie::with('ratings')
            ->get()
            ->sortByDesc('average_rating')
            ->take(12);
    
        return view('movies.index',[
            'newAddedMovies' => $newAddedMovies,
            'topRatedMovies' => $topRatedMovies,
        ]);
    }

    public function all(Request $request)
    {
        $movies = Movie::orderBy('release_date', 'desc')->paginate(18);

        // Handle pagination for AJAX requests
        if ($request->ajax()) {
            // Render the movie list component and store it as a string
            $html = view('components.movie-list', compact('movies'))->render();
            // Return the rendered HTML and the URL of the next page
            return response()->json([
                'html' => $html,
                'next_page' => $movies->nextPageUrl(),
            ]);
        }

        return view('movies.all', compact('movies'));
    }

    public function show(Movie $movie) 
    {
        $userPlan = Auth::user()->getCurrentPlan();
        
        // Redirect to subscribe page if user has no active plan
        if (!$userPlan) {
            return redirect()->route('subscribe.plans')
                ->with('warning', 'You need an active subscription to watch movies.');
        }

        $streamingUrl = $movie->getStreamingUrl($userPlan->resolution ?? null);

        return view('movies.show', [
            'movie' => $movie,
            'streamingUrl' => $streamingUrl,
        ]);
    }

    public function search(Request $request) 
    {
        $search = $request->input('q');
        
        $query = Movie::query();
        
        // Search by title
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }
        
        // Filter by genre/category
        if ($request->genre) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->genre));
        }
        
        // Filter by year
        if ($request->year) {
            $query->whereYear('release_date', $request->year);
        }
        
        // Filter by rating
        if ($request->rating) {
            $query->where('average_rating', '>=', $request->rating);
        }
        
        // Apply sorting
        switch ($request->sort) {
            case 'oldest':
                $query->oldest('release_date');
                break;
            case 'rating':
                $query->orderByDesc('average_rating');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest('release_date');
        }

        $movies = $query->paginate(18);

        return view('movies.search', [
            'keyword' => $search,
            'movies' => $movies,
        ]);
    }
}
