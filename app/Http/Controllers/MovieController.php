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
        $newAddedMovies = Movie::latest()->limit(8)->get();
        $topRatedMovies = Movie::with('ratings')
            ->get()
            ->sortByDesc('average_rating')
            ->take(8);
    
        return view('movies.index',[
            'newAddedMovies' => $newAddedMovies,
            'topRatedMovies' => $topRatedMovies,
        ]);
    }

    public function all(Request $request)
    {
        $movies = Movie::orderBy('release_date', 'desc')->paginate(8);

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
        $movies = Movie::where('title', 'like', "%$search%")->get();

        return view('movies.search', [
            'keyword' => $search,
            'movies' => $movies,
        ]);
    }
}
