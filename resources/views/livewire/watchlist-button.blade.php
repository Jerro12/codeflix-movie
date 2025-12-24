<button wire:click="toggle" 
        class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all
               {{ $inWatchlist 
                  ? 'bg-codeflix-primary text-white' 
                  : 'bg-gray-700/80 hover:bg-gray-600 text-white' }}">
    @if($inWatchlist)
        <i class="fa-solid fa-check"></i>
        <span>In My List</span>
    @else
        <i class="fa-solid fa-plus"></i>
        <span>My List</span>
    @endif
</button>
