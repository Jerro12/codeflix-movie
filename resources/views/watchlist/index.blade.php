@extends('layouts.app')

@section('title', 'My List')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-outfit text-3xl font-bold text-white mb-2">My List</h1>
                <p class="text-gray-400">{{ $watchlist->count() }} titles saved</p>
            </div>
            
            @if($watchlist->isNotEmpty())
            <div class="flex items-center gap-4">
                <button class="text-gray-400 hover:text-white transition" onclick="toggleView('grid')">
                    <i class="fa-solid fa-grip text-xl"></i>
                </button>
                <button class="text-gray-400 hover:text-white transition" onclick="toggleView('list')">
                    <i class="fa-solid fa-list text-xl"></i>
                </button>
            </div>
            @endif
        </div>

        @if($watchlist->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-codeflix-card rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-bookmark text-4xl text-gray-600"></i>
            </div>
            <h2 class="font-outfit text-2xl font-semibold text-white mb-3">Your list is empty</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                Start adding movies and TV shows to your list by clicking the + button on any title.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold px-8 py-3 rounded-xl transition">
                <i class="fa-solid fa-compass"></i>
                Browse Content
            </a>
        </div>
        @else
        <!-- Grid View -->
        <div id="grid-view" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($watchlist as $item)
            <div class="movie-card group relative rounded-xl overflow-hidden bg-codeflix-card">
                <a href="{{ route('movies.show', $item->movie->slug) }}">
                    <img src="{{ $item->movie->poster }}" alt="{{ $item->movie->title }}" 
                         class="w-full aspect-[2/3] object-cover">
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                        <h3 class="font-semibold text-white mb-1">{{ $item->movie->title }}</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-star text-yellow-500"></i>
                                {{ number_format($item->movie->average_rating ?? 0, 1) }}
                            </span>
                            <span>{{ $item->movie->release_date->format('Y') }}</span>
                        </div>
                    </div>

                    <!-- Play Button -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-play text-black text-xl ml-1"></i>
                        </div>
                    </div>
                </a>

                <!-- Remove Button -->
                <button onclick="removeFromList({{ $item->movie->id }})" 
                        class="absolute top-2 right-2 w-8 h-8 bg-black/60 hover:bg-red-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                    <i class="fa-solid fa-times text-white text-sm"></i>
                </button>
            </div>
            @endforeach
        </div>

        <!-- List View (hidden by default) -->
        <div id="list-view" class="hidden space-y-3">
            @foreach($watchlist as $item)
            <div class="bg-codeflix-card rounded-xl p-4 flex items-center gap-4 group hover:bg-codeflix-card/80 transition">
                <a href="{{ route('movies.show', $item->movie->slug) }}" class="flex-shrink-0">
                    <img src="{{ $item->movie->poster }}" alt="{{ $item->movie->title }}" 
                         class="w-20 h-28 object-cover rounded-lg">
                </a>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('movies.show', $item->movie->slug) }}">
                        <h3 class="font-semibold text-white text-lg mb-1 hover:text-codeflix-primary transition">
                            {{ $item->movie->title }}
                        </h3>
                    </a>
                    <div class="flex items-center gap-3 text-sm text-gray-400 mb-2">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            {{ number_format($item->movie->average_rating ?? 0, 1) }}
                        </span>
                        <span>{{ $item->movie->release_date->format('Y') }}</span>
                        <span>{{ $item->movie->formatted_duration }}</span>
                    </div>
                    <p class="text-gray-500 text-sm line-clamp-1">{{ $item->movie->description }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('movies.show', $item->movie->slug) }}" 
                       class="w-10 h-10 bg-white hover:bg-gray-200 rounded-full flex items-center justify-center text-black">
                        <i class="fa-solid fa-play ml-0.5"></i>
                    </a>
                    <button onclick="removeFromList({{ $item->movie->id }})" 
                            class="w-10 h-10 bg-gray-700 hover:bg-red-500 rounded-full flex items-center justify-center text-white">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleView(view) {
    document.getElementById('grid-view').classList.toggle('hidden', view !== 'grid');
    document.getElementById('list-view').classList.toggle('hidden', view !== 'list');
}

function removeFromList(movieId) {
    if (!confirm('Remove this title from your list?')) return;
    
    fetch(`/watchlist/${movieId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Removed from My List', 'success');
            location.reload();
        }
    });
}
</script>
@endpush
@endsection
