@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 100px 80px;">
    <h1 class="section-title" style="margin-left: 0;">
        <i class="fa-solid fa-bookmark me-2" style="color: var(--codeflix-primary);"></i>
        My List
    </h1>

    @if($watchlistItems->isEmpty())
        <div class="watchlist-empty">
            <i class="fa-regular fa-bookmark watchlist-empty-icon"></i>
            <h3 class="watchlist-empty-title">Your list is empty</h3>
            <p class="watchlist-empty-text">Add movies to your list to watch them later</p>
            <a href="{{ route('movies.index') }}" class="btn-play" style="text-decoration: none; padding: 12px 30px;">
                <i class="fa-solid fa-film me-2"></i>Browse Movies
            </a>
        </div>
    @else
        <div class="watchlist-grid" style="margin-left: 0; padding-left: 0;">
            @foreach($watchlistItems as $item)
                <div class="card">
                    <img src="{{ $item->movie->poster }}" alt="{{ $item->movie->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                    
                    <span class="badge text-bg-dark badge-rating">
                        <img class="star-rating" src="{{ asset('assets/img/star.png') }}" alt="Star">
                        {{ number_format($item->movie->average_rating ?? 0, 1) }}
                    </span>

                    <button class="btn-watchlist active" 
                            onclick="toggleWatchlist({{ $item->movie->id }})" 
                            id="watchlist-btn-{{ $item->movie->id }}">
                        <i class="fa-solid fa-check"></i>
                    </button>

                    <a href="{{ route('movies.show', $item->movie->slug) }}" class="card-overlay">
                        <div class="card-overlay-title">{{ $item->movie->title }}</div>
                        <div class="card-overlay-meta">
                            <span>{{ $item->movie->release_date->format('Y') }}</span>
                            <span>•</span>
                            <span>{{ $item->movie->formatted_duration }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleWatchlist(movieId) {
    fetch(`/watchlist/${movieId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && !data.in_watchlist) {
            // Movie was removed, reload the page
            location.reload();
        }
    });
}
</script>
@endpush
