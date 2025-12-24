<div class="relative" x-data="{ open: @entangle('showResults') }">
    <div class="relative">
        <input type="text" 
               wire:model.live.debounce.300ms="query"
               @focus="$wire.dispatch('searchFocus')"
               @click.away="open = false"
               placeholder="Search movies, series..."
               class="w-full bg-gray-900/50 border border-gray-700 rounded-full px-4 py-2 pl-10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition-all">
        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        
        @if(strlen($query) > 0)
        <button wire:click="$set('query', '')" 
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
            <i class="fa-solid fa-times"></i>
        </button>
        @endif
    </div>

    <!-- Results Dropdown -->
    <div x-show="open && @js(count($results)) > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute top-full mt-2 w-full bg-codeflix-card border border-gray-800 rounded-xl shadow-2xl overflow-hidden z-50">
        
        @foreach($results as $result)
        <a href="{{ $result['url'] }}" 
           class="flex items-center gap-3 p-3 hover:bg-gray-800 transition">
            <img src="{{ $result['poster'] }}" alt="{{ $result['title'] }}" 
                 class="w-12 h-16 object-cover rounded">
            <div class="flex-1 min-w-0">
                <h4 class="font-medium text-white truncate">{{ $result['title'] }}</h4>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <span>{{ $result['year'] }}</span>
                    <span class="px-2 py-0.5 bg-gray-700 rounded-full text-xs capitalize">{{ $result['type'] }}</span>
                </div>
            </div>
        </a>
        @endforeach

        @if(strlen($query) >= 2)
        <a href="{{ route('movies.search', ['q' => $query]) }}" 
           class="block p-3 bg-gray-900 text-center text-codeflix-primary hover:text-white transition">
            <i class="fa-solid fa-search mr-2"></i>
            View all results for "{{ $query }}"
        </a>
        @endif
    </div>

    <!-- No Results -->
    <div x-show="open && @js(count($results)) === 0 && @js(strlen($query)) >= 2"
         class="absolute top-full mt-2 w-full bg-codeflix-card border border-gray-800 rounded-xl shadow-2xl p-6 text-center z-50">
        <i class="fa-solid fa-film text-3xl text-gray-600 mb-2"></i>
        <p class="text-gray-400">No results found for "{{ $query }}"</p>
    </div>
</div>
