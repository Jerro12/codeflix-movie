<!-- Movie Card Component with Tailwind -->
<div class="movie-card group relative rounded-xl overflow-hidden bg-codeflix-card">
    <a href="{{ route('movies.show', $movie->slug) }}" class="block">
        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
             class="w-full aspect-[2/3] object-cover">
    </a>
    
    <!-- Rating & Age Badge -->
    <div class="absolute top-2 left-2 z-20 flex flex-col gap-1">
        <div class="bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
            <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
            <span class="text-white text-sm font-medium">{{ number_format($movie->average_rating ?? 0, 1) }}</span>
        </div>
        @if($movie->age_rating)
        <div class="bg-codeflix-primary/80 backdrop-blur-sm px-2 py-0.5 rounded-lg text-center">
            <span class="text-white text-[10px] font-bold uppercase">{{ $movie->age_rating }}</span>
        </div>
        @endif
    </div>

    <!-- Watchlist Button -->
    @auth
    <button onclick="event.preventDefault(); toggleWatchlist({{ $movie->id }}, this)" 
            class="absolute top-2 right-2 w-8 h-8 bg-black/70 backdrop-blur-sm rounded-full flex items-center justify-center opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all hover:bg-codeflix-primary hover:scale-110 {{ Auth::user()->hasInWatchlist($movie->id) ? 'bg-codeflix-primary opacity-100' : '' }}"
            id="watchlist-btn-{{ $movie->id }}">
        <i class="fa-solid {{ Auth::user()->hasInWatchlist($movie->id) ? 'fa-check' : 'fa-plus' }} text-white text-sm"></i>
    </button>
    @endauth

    <!-- Hover Info Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-4">
        <h3 class="font-outfit font-semibold text-white text-sm mb-1 line-clamp-2">{{ $movie->title }}</h3>
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
            <span>{{ $movie->release_date->format('Y') }}</span>
            <span>•</span>
            <span>{{ $movie->formatted_duration }}</span>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center gap-2">
            <a href="{{ route('movies.show', $movie->slug) }}" 
               class="flex-1 bg-white hover:bg-gray-200 text-black font-semibold py-2 rounded-lg text-center text-sm flex items-center justify-center gap-1 transition">
                <i class="fa-solid fa-play text-xs"></i> Play
            </a>
            <a href="{{ route('movies.show', $movie->slug) }}" 
               class="w-9 h-9 bg-gray-700/80 hover:bg-gray-600 rounded-lg flex items-center justify-center transition"
               title="More Info">
                <i class="fa-solid fa-chevron-down text-white text-sm"></i>
            </a>
        </div>
    </div>
</div>
