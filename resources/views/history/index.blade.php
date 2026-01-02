@extends('layouts.app')

@section('title', 'Watch History')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-outfit text-3xl font-bold text-white mb-2">Watch History</h1>
                <p class="text-gray-400">Your viewing activity</p>
            </div>
            
            @if($history->isNotEmpty())
            <button class="text-red-400 hover:text-red-300 text-sm font-medium">
                <i class="fa-solid fa-trash mr-1"></i> Clear All History
            </button>
            @endif
        </div>

        @if($history->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-codeflix-card rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-600"></i>
            </div>
            <h2 class="font-outfit text-2xl font-semibold text-white mb-3">No watch history yet</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                Your watched movies and shows will appear here.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold px-8 py-3 rounded-xl transition">
                <i class="fa-solid fa-play"></i>
                Start Watching
            </a>
        </div>
        @else
        <!-- History List by Date -->
        @php
            $groupedHistory = $history->groupBy(fn($item) => $item->last_watched_at->format('Y-m-d'));
        @endphp

        @foreach($groupedHistory as $date => $items)
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-white mb-4">
                @if($date === now()->format('Y-m-d'))
                    Today
                @elseif($date === now()->subDay()->format('Y-m-d'))
                    Yesterday
                @else
                    {{ \Carbon\Carbon::parse($date)->format('l, M j') }}
                @endif
            </h2>

            <div class="space-y-3">
                @foreach($items as $item)
                <div class="bg-codeflix-card rounded-xl p-4 flex items-center gap-4 group hover:bg-codeflix-card/80 transition">
                    <a href="{{ route('movies.show', $item->movie->slug) }}" class="relative flex-shrink-0">
                        <img src="{{ $item->movie->poster }}" alt="{{ $item->movie->title }}" 
                             class="w-28 h-16 object-cover rounded-lg">
                        <!-- Progress overlay -->
                        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-700 rounded-b-lg">
                            <div class="h-full bg-codeflix-secondary rounded-b-lg" style="width: {{ $item->progress_percentage }}%"></div>
                        </div>
                        <!-- Play icon -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-play text-black text-sm ml-0.5"></i>
                            </div>
                        </div>
                    </a>
                    
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('movies.show', $item->movie->slug) }}">
                            <h3 class="font-semibold text-white hover:text-codeflix-primary transition">
                                {{ $item->movie->title }}
                            </h3>
                        </a>
                        <div class="flex items-center gap-3 text-sm text-gray-400 mt-1">
                            <span>{{ $item->progress_percentage }}% watched</span>
                            <span>•</span>
                            <span>{{ $item->movie->formatted_duration }}</span>
                            <span>•</span>
                            <span>{{ $item->last_watched_at->format('g:i A') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if(!$item->is_completed)
                        <a href="{{ route('movies.show', $item->movie->slug) }}" 
                           class="px-4 py-2 bg-white hover:bg-gray-200 text-black font-medium rounded-lg text-sm transition">
                            Continue
                        </a>
                        @else
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                            <i class="fa-solid fa-check mr-1"></i> Completed
                        </span>
                        @endif
                        
                        <button onclick="removeFromHistory({{ $item->id }})"
                                class="w-8 h-8 text-gray-400 hover:text-red-400 rounded-lg flex items-center justify-center transition">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $history->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function removeFromHistory(historyId) {
    if (!confirm('Remove this from your history?')) return;
    
    fetch(`/history/${historyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Removed from history', 'success');
            location.reload();
        }
    });
}
</script>
@endpush
@endsection
