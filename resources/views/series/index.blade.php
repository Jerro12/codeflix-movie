@extends('layouts.app')

@section('title', 'TV Series')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="font-outfit text-4xl font-bold text-white mb-4">TV Series</h1>
            <p class="text-gray-400 text-lg">Binge-worthy shows from start to finish</p>
        </div>

        <!-- Featured Series -->
        @if($featuredSeries ?? null)
        <section class="relative rounded-2xl overflow-hidden mb-12" style="height: 400px; background-image: url('{{ $featuredSeries->banner ?? $featuredSeries->poster }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-codeflix-dark via-transparent to-transparent"></div>
            
            <div class="relative z-10 h-full flex items-end p-8">
                <div class="max-w-xl">
                    <span class="inline-flex items-center gap-2 bg-codeflix-primary/20 text-codeflix-primary px-3 py-1 rounded-full text-sm font-medium mb-3">
                        <i class="fa-solid fa-tv"></i> Featured Series
                    </span>
                    <h2 class="font-outfit text-3xl font-bold text-white mb-3">{{ $featuredSeries->title }}</h2>
                    <div class="flex items-center gap-4 text-gray-300 mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            {{ number_format($featuredSeries->average_rating ?? 8.5, 1) }}
                        </span>
                        <span>{{ $featuredSeries->release_year }}</span>
                        <span>{{ $featuredSeries->seasons->count() }} Seasons</span>
                    </div>
                    <p class="text-gray-300 line-clamp-2 mb-4">{{ $featuredSeries->description }}</p>
                    <a href="{{ route('series.show', $featuredSeries->slug) }}" 
                       class="inline-flex items-center gap-2 bg-white hover:bg-gray-200 text-black font-semibold px-6 py-3 rounded-lg transition">
                        <i class="fa-solid fa-play"></i> Watch Now
                    </a>
                </div>
            </div>
        </section>
        @endif

        <!-- All Series Grid -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-outfit text-2xl font-semibold text-white">All Series</h2>
                <select onchange="window.location = this.value" 
                        class="bg-codeflix-card border border-gray-700 rounded-lg px-4 py-2 text-white text-sm">
                    <option value="?sort=newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="?sort=rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    <option value="?sort=title" {{ request('sort') === 'title' ? 'selected' : '' }}>A-Z</option>
                </select>
            </div>

            @if(($series ?? collect())->isEmpty())
            <div class="text-center py-20">
                <i class="fa-solid fa-tv text-6xl text-gray-700 mb-4"></i>
                <h2 class="font-outfit text-xl font-semibold text-white mb-2">No series yet</h2>
                <p class="text-gray-400">Check back soon for new TV series!</p>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($series as $show)
                <a href="{{ route('series.show', $show->slug) }}" class="movie-card group relative rounded-xl overflow-hidden bg-codeflix-card">
                    <img src="{{ $show->poster }}" alt="{{ $show->title }}" class="w-full aspect-[2/3] object-cover">
                    
                    <!-- Badge -->
                    <div class="absolute top-2 left-2">
                        <span class="px-2 py-1 bg-codeflix-primary/90 text-white text-xs font-bold rounded">
                            {{ $show->seasons->count() }} {{ Str::plural('Season', $show->seasons->count()) }}
                        </span>
                    </div>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                        <h3 class="font-semibold text-white mb-1">{{ $show->title }}</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-300">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-star text-yellow-500"></i>
                                {{ number_format($show->average_rating ?? 0, 1) }}
                            </span>
                            <span>{{ $show->release_year }}</span>
                        </div>
                    </div>

                    <!-- Play Button -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-play text-black text-xl ml-1"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-8">
                {{ $series->links() }}
            </div>
            @endif
        </section>
    </div>
</div>
@endsection
