@extends('layouts.app')

@section('title', $series->title)

@section('content')
<div class="pt-16">
    <!-- Hero Banner -->
    <section class="relative h-[60vh] min-h-[400px]" style="background-image: url('{{ $series->banner ?? $series->poster }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-codeflix-dark via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-end pb-8">
            <div class="flex gap-8 items-end">
                <!-- Poster -->
                <img src="{{ $series->poster }}" alt="{{ $series->title }}" 
                     class="hidden md:block w-48 rounded-xl shadow-2xl -mb-16 z-20">
                
                <!-- Info -->
                <div class="flex-1 pb-4">
                    @if($series->age_rating)
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-600/80 text-white text-xs font-bold rounded mb-2">
                        {{ $series->age_rating }}
                    </span>
                    @endif
                    
                    <h1 class="font-outfit text-4xl md:text-5xl font-bold text-white mb-3">{{ $series->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-gray-300 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            {{ number_format($series->average_rating ?? 8.5, 1) }}
                        </span>
                        <span>{{ $series->release_year }}</span>
                        <span>{{ $series->seasons->count() }} {{ Str::plural('Season', $series->seasons->count()) }}</span>
                        <span class="px-2 py-1 bg-gray-700/50 rounded text-sm">{{ $series->status }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if($firstEpisode = $series->seasons->first()?->episodes->first())
                        <a href="#episodes" class="inline-flex items-center gap-2 bg-white hover:bg-gray-200 text-black font-semibold px-8 py-3 rounded-lg transition">
                            <i class="fa-solid fa-play"></i> Watch S1:E1
                        </a>
                        @endif
                        
                        @auth
                        <button onclick="toggleWatchlist('series', {{ $series->id }})" 
                                class="inline-flex items-center gap-2 bg-gray-600/80 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                            <i class="fa-solid fa-plus"></i> My List
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8 md:pl-60">
        <!-- Synopsis -->
        <section class="mb-8">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">Synopsis</h2>
            <p class="text-gray-300 leading-relaxed max-w-3xl">{{ $series->description }}</p>
        </section>

        <!-- Cast & Crew -->
        @if($series->director || $series->cast)
        <section class="mb-8">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">Cast & Crew</h2>
            <div class="grid sm:grid-cols-2 gap-4 max-w-2xl">
                @if($series->director)
                <div>
                    <p class="text-gray-500 text-sm">Creator/Director</p>
                    <p class="text-white">{{ $series->director }}</p>
                </div>
                @endif
                @if($series->cast)
                <div>
                    <p class="text-gray-500 text-sm">Cast</p>
                    <p class="text-white">{{ $series->cast }}</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Episodes -->
        <section id="episodes" class="mb-8">
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">Episodes</h2>
            
            <!-- Season Tabs -->
            <div class="flex gap-2 mb-6 overflow-x-auto pb-2" x-data="{ activeSeason: 1 }">
                @foreach($series->seasons as $index => $season)
                <button @click="activeSeason = {{ $season->number }}"
                        :class="activeSeason === {{ $season->number }} ? 'bg-codeflix-primary text-white' : 'bg-codeflix-card text-gray-400 hover:text-white'"
                        class="px-4 py-2 rounded-lg font-medium whitespace-nowrap transition">
                    Season {{ $season->number }}
                </button>
                @endforeach
            </div>

            <!-- Episodes List -->
            @foreach($series->seasons as $season)
            <div x-show="activeSeason === {{ $season->number }}" class="space-y-3">
                @foreach($season->episodes as $episode)
                <div class="bg-codeflix-card rounded-xl p-4 flex gap-4 group hover:bg-codeflix-card/80 transition cursor-pointer">
                    <!-- Thumbnail -->
                    <div class="relative flex-shrink-0">
                        <img src="{{ $episode->thumbnail ?? $series->poster }}" alt="Episode {{ $episode->number }}"
                             class="w-40 h-24 object-cover rounded-lg">
                        <!-- Duration -->
                        <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/80 text-white text-xs rounded">
                            {{ $episode->formatted_duration }}
                        </span>
                        <!-- Play overlay -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-play text-black ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-semibold text-white">
                                {{ $episode->number }}. {{ $episode->title }}
                            </h3>
                        </div>
                        <p class="text-gray-400 text-sm line-clamp-2">{{ $episode->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </section>

        <!-- Similar Series -->
        <section>
            <h2 class="font-outfit text-2xl font-semibold text-white mb-4">More Like This</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach(\App\Models\Series::where('id', '!=', $series->id)->limit(6)->get() as $similar)
                <a href="{{ route('series.show', $similar->slug) }}" class="movie-card rounded-xl overflow-hidden">
                    <img src="{{ $similar->poster }}" alt="{{ $similar->title }}" class="w-full aspect-[2/3] object-cover">
                </a>
                @endforeach
            </div>
        </section>
    </div>
</div>

@push('scripts')
<script>
function toggleWatchlist(type, id) {
    // TODO: Implement series watchlist
    showToast('Added to My List', 'success');
}
</script>
@endpush
@endsection
