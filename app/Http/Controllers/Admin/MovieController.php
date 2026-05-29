<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index()
    {
        $movies = Movie::with('categories')
            ->latest()
            ->paginate(15);

        return view('admin.movies.index', [
            'movies' => $movies,
        ]);
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.movies.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created movie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title',
            'description' => 'required|string',
            'director' => 'required|string|max:255',
            'writers' => 'nullable|string',
            'stars' => 'nullable|string',
            'poster' => 'required|url',
            'banner' => 'nullable|url',
            'release_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'age_rating' => 'nullable|in:G,PG,PG-13,R,NC-17,SU,Anak,13+,17+',
            'url_720' => 'nullable|url',
            'url_1080' => 'nullable|url',
            'url_4k' => 'nullable|url',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'platforms' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $movie = Movie::create($validated);

        if (!empty($validated['categories'])) {
            $movie->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    /**
     * Show the form for editing a movie.
     */
    public function edit(Movie $movie)
    {
        $categories = Category::all();
        $movie->load('categories');

        return view('admin.movies.edit', [
            'movie' => $movie,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified movie.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title,' . $movie->id,
            'description' => 'required|string',
            'director' => 'required|string|max:255',
            'writers' => 'nullable|string',
            'stars' => 'nullable|string',
            'poster' => 'required|url',
            'banner' => 'nullable|url',
            'release_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:10',
            'age_rating' => 'nullable|in:G,PG,PG-13,R,NC-17,SU,Anak,13+,17+',
            'url_720' => 'nullable|url',
            'url_1080' => 'nullable|url',
            'url_4k' => 'nullable|url',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'platforms' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $movie->update($validated);

        if (isset($validated['categories'])) {
            $movie->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    /**
     * Remove the specified movie.
     */
    public function destroy(Movie $movie)
    {
        $movie->categories()->detach();
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted successfully.');
    }
}
