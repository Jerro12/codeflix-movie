@extends('layouts.app-new')

@section('title', 'Cerita Ulasan Saya')

@section('content')
<div class="pt-24 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white font-outfit mb-2">Cerita Ulasan Saya</h1>
            <p class="text-gray-400">Film-film yang telah Anda beri rating dan ulas.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($reviews as $review)
        <div class="bg-codeflix-card rounded-xl border border-gray-800 overflow-hidden flex flex-col group hover:border-gray-600 transition duration-300">
            <div class="flex items-start gap-4 p-4 border-b border-gray-800">
                <a href="{{ route('movies.show', $review->movie->slug) }}" class="flex-shrink-0 w-20 relative">
                    <img src="{{ $review->movie->poster }}" alt="{{ $review->movie->title }}" class="w-full aspect-[2/3] object-cover rounded-lg group-hover:opacity-80 transition">
                    @if($review->spoiler_warning)
                    <div class="absolute -top-2 -right-2 bg-red-500/90 text-white text-[10px] px-1.5 py-0.5 rounded shadow">Spoiler</div>
                    @endif
                </a>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('movies.show', $review->movie->slug) }}" class="text-white font-semibold hover:text-codeflix-primary truncate block mb-1">
                        {{ $review->movie->title }}
                    </a>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="px-2 py-0.5 bg-yellow-500/20 text-yellow-500 text-sm rounded font-bold flex items-center gap-1">
                            {{ $review->rating }}/5 <i class="fa-solid fa-star text-[10px]"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }} &bull; {{ $review->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col">
                @if($review->title)
                    <h3 class="font-bold text-white mb-2 text-sm">{{ $review->title }}</h3>
                @endif
                
                @if($review->content)
                    <p class="text-gray-400 text-sm italic flex-1 line-clamp-4">
                        "{{ $review->content }}"
                    </p>
                @else
                    <p class="text-gray-600 text-sm italic flex-1 flex items-center justify-center">
                        Tidak ada ulasan tertulis yang diberikan.
                    </p>
                @endif
                
                <div class="mt-4 pt-4 border-t border-gray-800 flex justify-between items-center">
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <i class="fa-solid fa-thumbs-up"></i> {{ $review->helpful_count ?? 0 }} terbantu
                    </span>
                    
                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:text-red-400 bg-red-500/10 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-codeflix-card rounded-xl border border-gray-800">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-pen-nib text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Belum Ada Ulasan</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Anda belum memberikan rating atau ulasan pada film apa pun. Bagikan pendapat Anda untuk mulai membangun cerita ulasan Anda!</p>
            <a href="{{ route('movies.index') }}" class="inline-block bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-2 rounded-lg transition">
                Jelajahi Film
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
