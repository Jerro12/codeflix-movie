<!-- Movie Card Component with Tailwind -->
<div class="movie-card group relative rounded-xl bg-codeflix-card">
    <a href="{{ route('movies.show', $movie->slug) }}" class="block">
        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
             class="w-full aspect-[2/3] object-cover rounded-xl">
    </a>
    
    <!-- Rating Badge -->
    <div class="absolute top-2 left-2 z-20 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
        <span class="text-white text-sm font-medium">{{ number_format($movie->average_rating ?? 0, 1) }}</span>
    </div>

    <!-- Watchlist Button -->
    @auth
    <button onclick="event.preventDefault(); event.stopPropagation(); toggleWatchlist({{ $movie->id }}, this)" 
            class="absolute top-2 right-2 z-30 w-8 h-8 bg-black/70 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-codeflix-primary hover:scale-110 cursor-pointer {{ Auth::user()->hasInWatchlist($movie->id) ? 'bg-codeflix-primary opacity-100' : '' }}"
            id="watchlist-btn-{{ $movie->id }}">
        <i class="fa-solid {{ Auth::user()->hasInWatchlist($movie->id) ? 'fa-check' : 'fa-plus' }} text-white text-sm"></i>
    </button>
    @endauth

    <!-- Hover Info Overlay -->
    <div class="absolute inset-0 z-10 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-4 rounded-xl pointer-events-none">
        
        <!-- Content wrapper - allow pointer events -->
        <div class="pointer-events-auto">
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
                
                <!-- Dropdown Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="w-9 h-9 bg-gray-700/80 hover:bg-gray-600 rounded-lg flex items-center justify-center transition cursor-pointer">
                        <i class="fa-solid fa-chevron-down text-white text-sm"></i>
                    </button>
                    
                    <!-- Dropdown Content -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute bottom-full right-0 mb-2 w-48 bg-codeflix-card border border-gray-700 rounded-lg shadow-xl z-50 overflow-hidden text-left">
                        
                        @auth
                        <button onclick="toggleWatchlist({{ $movie->id }}, document.getElementById('watchlist-btn-{{ $movie->id }}')); $dispatch('close')"
                                class="w-full px-4 py-2 text-left text-sm text-white hover:bg-codeflix-primary/20 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-{{ Auth::user()->hasInWatchlist($movie->id) ? 'check' : 'plus' }} w-4 text-center"></i>
                            {{ Auth::user()->hasInWatchlist($movie->id) ? 'Remove from List' : 'Add to List' }}
                        </button>
                        @endauth
                        
                        <a href="{{ route('movies.show', $movie->slug) }}" 
                           class="block px-4 py-2 text-sm text-white hover:bg-codeflix-primary/20 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-circle-info w-4 text-center"></i>
                            More Info
                        </a>
                        
                        <button onclick="navigator.clipboard.writeText('{{ route('movies.show', $movie->slug) }}'); showToast('Link copied!', 'success'); $dispatch('close')"
                                class="w-full px-4 py-2 text-left text-sm text-white hover:bg-codeflix-primary/20 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-share-nodes w-4 text-center"></i>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
