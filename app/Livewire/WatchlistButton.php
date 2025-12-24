<?php

namespace App\Livewire;

use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WatchlistButton extends Component
{
    public int $movieId;
    public bool $inWatchlist = false;

    public function mount(int $movieId)
    {
        $this->movieId = $movieId;
        
        if (Auth::check()) {
            $this->inWatchlist = Auth::user()->hasInWatchlist($movieId);
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $user = Auth::user();
        $existing = Watchlist::where('user_id', $user->id)
            ->where('movie_id', $this->movieId)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->inWatchlist = false;
            $this->dispatch('toast', message: 'Removed from My List', type: 'success');
        } else {
            Watchlist::create([
                'user_id' => $user->id,
                'movie_id' => $this->movieId,
            ]);
            $this->inWatchlist = true;
            $this->dispatch('toast', message: 'Added to My List', type: 'success');
        }
    }

    public function render()
    {
        return view('livewire.watchlist-button');
    }
}
