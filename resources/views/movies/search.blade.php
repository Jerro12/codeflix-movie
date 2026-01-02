@extends('layouts.app')

@section('title', 'Search: ' . request('q'))

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="font-outfit text-3xl font-bold text-white mb-4">
                @if(request('q'))
                    Search results for "{{ request('q') }}"
                @else
                    Browse All
                @endif
            </h1>
            
            <!-- Search Form -->
            <form action="{{ route('movies.search') }}" method="GET" class="flex gap-3">
                <div class="relative flex-1 max-w-xl">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Search movies, series, actors..."
                           class="w-full bg-codeflix-card border border-gray-700 rounded-xl pl-12 pr-4 py-3 text-white placeholder-gray-500 focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary">
                </div>
                <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 rounded-xl transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-4 mb-8 p-4 bg-codeflix-card rounded-xl">
            <!-- Genre Filter -->
            <div>
                <label class="text-sm text-gray-400 block mb-1">Genre</label>
                <select name="genre" onchange="applyFilter(this)" 
                        class="bg-codeflix-dark border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:border-codeflix-primary">
                    <option value="">All Genres</option>
                    @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->slug }}" {{ request('genre') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label class="text-sm text-gray-400 block mb-1">Year</label>
                <select name="year" onchange="applyFilter(this)"
                        class="bg-codeflix-dark border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:border-codeflix-primary">
                    <option value="">All Years</option>
                    @for($y = date('Y'); $y >= 2000; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <!-- Rating Filter -->
            <div>
                <label class="text-sm text-gray-400 block mb-1">Min Rating</label>
                <select name="rating" onchange="applyFilter(this)"
                        class="bg-codeflix-dark border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:border-codeflix-primary">
                    <option value="">Any Rating</option>
                    <option value="9" {{ request('rating') == 9 ? 'selected' : '' }}>9+ Excellent</option>
                    <option value="8" {{ request('rating') == 8 ? 'selected' : '' }}>8+ Great</option>
                    <option value="7" {{ request('rating') == 7 ? 'selected' : '' }}>7+ Good</option>
                    <option value="6" {{ request('rating') == 6 ? 'selected' : '' }}>6+ Above Average</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="text-sm text-gray-400 block mb-1">Sort By</label>
                <select name="sort" onchange="applyFilter(this)"
                        class="bg-codeflix-dark border border-gray-700 rounded-lg px-4 py-2 text-white text-sm focus:border-codeflix-primary">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title A-Z</option>
                </select>
            </div>

            <!-- Clear Filters -->
            @if(request()->hasAny(['genre', 'year', 'rating', 'sort']))
            <div class="ml-auto">
                <a href="{{ route('movies.search', ['q' => request('q')]) }}" 
                   class="text-sm text-gray-400 hover:text-white transition">
                    <i class="fa-solid fa-times mr-1"></i> Clear Filters
                </a>
            </div>
            @endif
        </div>

        <!-- Results Count -->
        <p class="text-gray-400 mb-6">{{ $movies->total() }} results found</p>

        <!-- Results Grid -->
        @if($movies->isEmpty())
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-codeflix-card rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-search text-4xl text-gray-600"></i>
            </div>
            <h2 class="font-outfit text-2xl font-semibold text-white mb-3">No results found</h2>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">
                Try adjusting your search or filters to find what you're looking for.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-codeflix-primary hover:underline">
                <i class="fa-solid fa-home"></i> Browse all content
            </a>
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-8">
            @foreach($movies as $movie)
            @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $movies->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function applyFilter(select) {
    const url = new URL(window.location.href);
    if (select.value) {
        url.searchParams.set(select.name, select.value);
    } else {
        url.searchParams.delete(select.name);
    }
    window.location = url.toString();
}
</script>
@endpush
@endsection
