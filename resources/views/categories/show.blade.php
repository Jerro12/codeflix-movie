@extends('layouts.app-new')

@section('title', $category->name . ' Movies')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header with gradient -->
        <div class="relative rounded-2xl overflow-hidden mb-8 bg-gradient-to-r from-codeflix-primary/30 via-codeflix-card to-codeflix-primary/20 p-8">
            <div class="absolute top-0 right-0 text-[200px] opacity-10 font-outfit font-bold leading-none -mt-10 -mr-10">
                {{ substr($category->name, 0, 1) }}
            </div>
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white mb-4 transition">
                    <i class="fa-solid fa-arrow-left"></i> Back to Home
                </a>
                <h1 class="font-outfit text-4xl font-bold text-white mb-2">{{ $category->name }}</h1>
                <p class="text-gray-400">{{ $category->movies()->count() }} movies available</p>
            </div>
        </div>

        <!-- Filter & Sort -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="text-gray-400 text-sm">Sort by:</span>
                <select onchange="window.location = this.value" 
                        class="bg-codeflix-card border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:border-codeflix-primary">
                    <option value="?sort=newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="?sort=rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    <option value="?sort=title" {{ request('sort') === 'title' ? 'selected' : '' }}>A-Z</option>
                </select>
            </div>
            
            <p class="text-gray-500 text-sm">
                Showing {{ $movies->firstItem() }}-{{ $movies->lastItem() }} of {{ $movies->total() }} results
            </p>
        </div>

        <!-- Movies Grid -->
        @if($movies->isEmpty())
        <div class="text-center py-20">
            <i class="fa-solid fa-film text-6xl text-gray-700 mb-4"></i>
            <h2 class="font-outfit text-xl font-semibold text-white mb-2">No movies found</h2>
            <p class="text-gray-400">Check back later for new additions in this category.</p>
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-8">
            @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $movies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
