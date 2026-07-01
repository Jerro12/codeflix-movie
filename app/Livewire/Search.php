<?php

namespace App\Livewire;

use App\Models\Movie;

use Livewire\Component;

class Search extends Component
{
    public string $query = '';
    public array $results = [];
    public bool $showResults = false;

    protected $listeners = ['searchFocus' => 'handleFocus'];

    public function updatedQuery()
    {
        if (strlen($this->query) >= 2) {
            $movies = Movie::where('title', 'like', "%{$this->query}%")
                ->orWhere('description', 'like', "%{$this->query}%")
                ->limit(5)
                ->get(['id', 'title', 'slug', 'poster', 'release_date'])
                ->map(function ($movie) {
                    return [
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'slug' => $movie->slug,
                        'poster' => $movie->poster,
                        'year' => $movie->release_date->format('Y'),
                        'type' => 'movie',
                        'url' => route('movies.show', $movie->slug),
                    ];
                });

            $this->results = $movies->toArray();
            $this->showResults = true;
        } else {
            $this->results = [];
            $this->showResults = false;
        }
    }

    public function hideResults()
    {
        $this->showResults = false;
    }

    public function handleFocus()
    {
        if (strlen($this->query) >= 2) {
            $this->showResults = true;
        }
    }

    public function render()
    {
        return view('livewire.search');
    }
}
