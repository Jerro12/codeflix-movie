<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Services\RecommendationService;

class MovieController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new \Illuminate\Routing\Controllers\Middleware('auth', except: ['index', 'all', 'show', 'search']),
            new \Illuminate\Routing\Controllers\Middleware('check.device.limit', except: ['index', 'all', 'show', 'search']),
        ];
    }

    public function index(RecommendationService $recService) 
    {
        $user = Auth::user();
        $newAddedMovies = Movie::forUser($user)->latest()->limit(12)->get();
        $topRatedMovies = Movie::forUser($user)
            ->with('ratings')
            ->get()
            ->sortByDesc('average_rating')
            ->take(12);

        $recommendations = [];
        if ($user) {
            // Get K from request or default to 5 for research purposes
            $k = request('k', 5);
            $recommendations = $recService->setK($k)->getRecommendations($user, 12);
        }
    
        return view('movies.index',[
            'newAddedMovies' => $newAddedMovies,
            'topRatedMovies' => $topRatedMovies,
            'recommendations' => $recommendations,
        ]);
    }

    public function all(Request $request)
    {
        $movies = Movie::forUser(Auth::user())->orderBy('release_date', 'desc')->paginate(18);

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

    public function show(Movie $movie, RecommendationService $recService) 
    {
        $streamingUrl = $movie->getStreamingUrl('1080p'); 

        $recommendations = [];
        if (Auth::check()) {
            $recommendations = $recService->setK(request('k', 5))->getRecommendations(Auth::user(), 4);
        }

        return view('movies.show', [
            'movie' => $movie,
            'streamingUrl' => $streamingUrl,
            'recommendations' => $recommendations,
        ]);
    }

    public function search(Request $request) 
    {
        $search = $request->input('q');
        
        $query = Movie::forUser(Auth::user());
        
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

    public function debugRecommendations(RecommendationService $recService)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $k = request('k', 5);
        $debugData = $recService->setK($k)->getDebugInfo(Auth::user());

        return view('movies.debug', [
            'debugData' => $debugData,
            'k' => $k
        ]);
    }
}
