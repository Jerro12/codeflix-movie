<?php

namespace App\Livewire;

use App\Models\Movie;
use App\Models\WatchHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VideoPlayer extends Component
{
    public Movie $movie;
    public string $videoUrl = '';
    public string $currentQuality = '1080';
    public int $progress = 0;
    public int $duration = 0;
    public bool $isPlaying = false;
    public bool $isMuted = false;
    public bool $isFullscreen = false;

    protected $listeners = ['updateProgress' => 'saveProgress'];

    public function mount(Movie $movie, string $resolution = '1080')
    {
        $this->movie = $movie;
        $this->currentQuality = $resolution;
        $this->videoUrl = $movie->getStreamingUrl($resolution);
        
        // Load saved progress if exists
        if (Auth::check()) {
            $history = WatchHistory::where('user_id', Auth::id())
                ->where('movie_id', $movie->id)
                ->first();
            
            if ($history) {
                $this->progress = $history->progress_seconds;
            }
        }
    }

    public function changeQuality(string $quality)
    {
        $this->currentQuality = $quality;
        $this->videoUrl = $this->movie->getStreamingUrl($quality);
        $this->dispatch('qualityChanged', quality: $quality);
    }

    public function saveProgress(int $progress, int $duration)
    {
        if (!Auth::check()) {
            return;
        }

        $this->progress = $progress;
        $this->duration = $duration;

        WatchHistory::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $this->movie->id,
            ],
            [
                'progress_seconds' => $progress,
                'duration_seconds' => $duration,
                'completed' => $progress >= ($duration * 0.9),
                'last_watched_at' => now(),
            ]
        );
    }

    public function render()
    {
        return view('livewire.video-player');
    }
}
