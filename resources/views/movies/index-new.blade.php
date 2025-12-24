@extends('layouts.app-new')

@section('content')
<!-- Hero Section -->
@if($featuredMovie ?? null)
<section class="relative h-[85vh] min-h-[600px]" style="background-image: url('{{ $featuredMovie->poster }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-codeflix-dark via-transparent to-transparent"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-center">
        <div class="max-w-xl pt-16">
            <span class="inline-flex items-center gap-2 bg-codeflix-primary/20 text-codeflix-primary px-3 py-1 rounded-full text-sm font-medium mb-4">
                <i class="fa-solid fa-star"></i> Featured
            </span>
            <h1 class="font-outfit text-5xl md:text-6xl font-bold text-white mb-4 leading-tight">
                {{ $featuredMovie->title }}
            </h1>
            <div class="flex items-center gap-4 text-gray-300 mb-4">
                <span class="flex items-center gap-1">
                    <i class="fa-solid fa-star text-yellow-500"></i>
                    {{ number_format($featuredMovie->average_rating ?? 0, 1) }}
                </span>
                <span>{{ $featuredMovie->release_date->format('Y') }}</span>
                <span>{{ $featuredMovie->formatted_duration }}</span>
            </div>
            <p class="text-gray-300 text-lg mb-6 line-clamp-3">
                {{ $featuredMovie->description }}
            </p>
            <div class="flex items-center gap-4">
                <a href="{{ route('movies.show', $featuredMovie->slug) }}" 
                   class="inline-flex items-center gap-2 bg-white hover:bg-gray-200 text-black font-semibold px-8 py-3 rounded-lg transition">
                    <i class="fa-solid fa-play"></i> Play
                </a>
                <button onclick="toggleWatchlist({{ $featuredMovie->id }})" 
                        class="inline-flex items-center gap-2 bg-gray-600/80 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    <i class="fa-solid fa-plus"></i> My List
                </button>
                <a href="{{ route('movies.show', $featuredMovie->slug) }}" 
                   class="inline-flex items-center justify-center w-12 h-12 bg-gray-600/50 hover:bg-gray-600 text-white rounded-full transition">
                    <i class="fa-solid fa-info"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@else
<div class="h-24"></div>
@endif

<!-- Continue Watching Section -->
@auth
@if(isset($continueWatching) && $continueWatching->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 -mt-32 relative z-20 mb-12">
    <h2 class="font-outfit text-2xl font-semibold text-white mb-4 flex items-center gap-3">
        <i class="fa-solid fa-play text-codeflix-primary"></i>
        Continue Watching
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($continueWatching as $history)
        <div class="movie-card group relative rounded-xl overflow-hidden bg-codeflix-card cursor-pointer">
            <a href="{{ route('movies.show', $history->movie->slug) }}">
                <img src="{{ $history->movie->poster }}" alt="{{ $history->movie->title }}" 
                     class="w-full aspect-[2/3] object-cover">
                <!-- Progress Bar -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-700">
                    <div class="h-full bg-codeflix-secondary" style="width: {{ $history->progress_percentage }}%"></div>
                </div>
                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                    <div class="w-full">
                        <p class="font-semibold text-white truncate">{{ $history->movie->title }}</p>
                        <p class="text-sm text-gray-400">{{ $history->progress_percentage }}% watched</p>
                    </div>
                </div>
                <!-- Play Button -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-play text-black text-xl ml-1"></i>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif
@endauth

<!-- New Added Section -->
<section class="max-w-7xl mx-auto px-4 mb-12 {{ isset($continueWatching) && $continueWatching->isNotEmpty() ? '' : '-mt-32 relative z-20' }}">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-outfit text-2xl font-semibold text-white flex items-center gap-3">
            <i class="fa-solid fa-sparkles text-codeflix-primary"></i>
            New Releases
        </h2>
        <a href="{{ route('movies.index') }}" class="text-codeflix-primary hover:text-codeflix-primary/80 font-medium flex items-center gap-1">
            See All <i class="fa-solid fa-chevron-right text-sm"></i>
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @foreach($newAddedMovies as $movie)
        @include('components.movie-card-new', ['movie' => $movie])
        @endforeach
    </div>
</section>

<!-- Top Rated Section -->
<section class="max-w-7xl mx-auto px-4 mb-12">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-outfit text-2xl font-semibold text-white flex items-center gap-3">
            <i class="fa-solid fa-fire text-orange-500"></i>
            Top Rated
        </h2>
        <a href="{{ route('movies.index') }}" class="text-codeflix-primary hover:text-codeflix-primary/80 font-medium flex items-center gap-1">
            See All <i class="fa-solid fa-chevron-right text-sm"></i>
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @foreach($topRatedMovies as $movie)
        @include('components.movie-card-new', ['movie' => $movie])
        @endforeach
    </div>
</section>

<!-- Categories Section -->
<section class="max-w-7xl mx-auto px-4 mb-12">
    <h2 class="font-outfit text-2xl font-semibold text-white mb-6 flex items-center gap-3">
        <i class="fa-solid fa-layer-group text-codeflix-primary"></i>
        Browse by Category
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @php
            $categories = \App\Models\Category::withCount('movies')->get();
        @endphp
        @foreach($categories as $category)
        <a href="{{ route('categories.show', $category->slug) }}" 
           class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-codeflix-primary/20 to-codeflix-card p-6 hover:from-codeflix-primary/40 transition-all duration-300">
            <div class="absolute top-2 right-2 text-4xl opacity-20 group-hover:opacity-40 transition-opacity">
                <i class="fa-solid fa-film"></i>
            </div>
            <h3 class="font-outfit font-semibold text-white text-lg mb-1">{{ $category->name }}</h3>
            <p class="text-sm text-gray-400">{{ $category->movies_count }} movies</p>
        </a>
        @endforeach
    </div>
</section>

<!-- Subscription CTA -->
@guest
<section class="max-w-7xl mx-auto px-4 mb-12">
    <div class="bg-gradient-to-r from-codeflix-primary/20 via-codeflix-card to-codeflix-primary/20 rounded-2xl p-8 md:p-12 text-center">
        <h2 class="font-outfit text-3xl md:text-4xl font-bold text-white mb-4">
            Unlimited Movies & TV Shows
        </h2>
        <p class="text-gray-300 text-lg mb-6 max-w-2xl mx-auto">
            Join Codeflix today and get access to thousands of movies and TV shows. Start your free trial now!
        </p>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold px-8 py-4 rounded-xl text-lg transition">
            <i class="fa-solid fa-rocket"></i> Get Started Free
        </a>
    </div>
</section>
@endguest
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
        if (data.success) {
            showToast(data.message, 'success');
        }
    });
}
</script>
@endpush
