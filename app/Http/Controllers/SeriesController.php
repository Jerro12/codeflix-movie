<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display series listing
     */
    public function index(Request $request)
    {
        $query = Series::with('seasons.episodes');

        // Apply sorting
        switch ($request->get('sort')) {
            case 'rating':
                $query->orderByDesc('release_year'); // TODO: Add rating
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest();
        }

        $series = $query->paginate(18);
        $featuredSeries = Series::with('seasons')->first();

        return view('series.index', compact('series', 'featuredSeries'));
    }

    /**
     * Display single series
     */
    public function show(Series $series)
    {
        $series->load(['seasons.episodes' => function ($query) {
            $query->orderBy('number');
        }]);

        return view('series.show', compact('series'));
    }
}
