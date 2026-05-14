@extends('layouts.app-new')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-outfit text-3xl font-bold text-white flex items-center gap-3">
            <i class="fa-solid fa-film text-codeflix-primary"></i>
            Semua Film
        </h1>
        <p class="text-codeflix-muted">{{ $movies->total() }} film tersedia</p>
    </div>

    <!-- Movies Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 mb-8" id="movie-list">
        @foreach($movies as $movie)
        @include('components.movie-card', ['movie' => $movie])
        @endforeach
    </div>

    <!-- Pagination -->
    @if($movies->hasPages())
    <div class="flex justify-center">
        <nav class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($movies->onFirstPage())
                <span class="px-4 py-2 bg-codeflix-card text-gray-500 rounded-lg cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $movies->previousPageUrl() }}" class="px-4 py-2 bg-codeflix-card text-white rounded-lg hover:bg-codeflix-primary transition">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($movies->getUrlRange(max(1, $movies->currentPage() - 2), min($movies->lastPage(), $movies->currentPage() + 2)) as $page => $url)
                @if ($page == $movies->currentPage())
                    <span class="px-4 py-2 bg-codeflix-primary text-white rounded-lg font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 bg-codeflix-card text-white rounded-lg hover:bg-codeflix-primary transition">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($movies->hasMorePages())
                <a href="{{ $movies->nextPageUrl() }}" class="px-4 py-2 bg-codeflix-card text-white rounded-lg hover:bg-codeflix-primary transition">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-4 py-2 bg-codeflix-card text-gray-500 rounded-lg cursor-not-allowed">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
    @endif
</div>
@endsection
