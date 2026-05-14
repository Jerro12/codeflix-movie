@extends('layouts.app-new')

@section('title', $movie->title)
@section('og_title', $movie->title . ' - Codeflix')
@section('og_description', Str::limit($movie->description, 150))
@section('og_image', $movie->poster)

@section('content')
<div class="pt-16">
    <!-- Hero Banner -->
    <section class="relative h-[60vh] min-h-[400px]" style="background-image: url('{{ $movie->banner ?? $movie->poster }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-codeflix-dark via-transparent to-transparent"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 h-full flex items-end pb-8">
            <div class="flex gap-8 items-end">
                <!-- Poster -->
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
                     class="hidden md:block w-48 rounded-xl shadow-2xl -mb-16 z-20">
                
                <!-- Info -->
                <div class="flex-1 pb-4">
                    @if($movie->age_rating ?? null)
                    @php
                        $ratingColor = match($movie->age_rating) {
                            'SU', 'Anak', 'G', 'PG' => 'bg-emerald-600',
                            '13+', 'PG-13' => 'bg-yellow-600',
                            '17+', 'R', 'NC-17', '21+' => 'bg-red-600',
                            default => 'bg-gray-600'
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 px-3 py-1 {{ $ratingColor }} text-white text-xs font-black rounded-full mb-2 uppercase tracking-widest shadow-lg">
                        <i class="fa-solid fa-shield-halved text-[10px]"></i> {{ $movie->age_rating }}
                    </span>
                    @endif
                    
                    <h1 class="font-outfit text-4xl md:text-5xl font-bold text-white mb-3">{{ $movie->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-gray-300 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            {{ number_format($movie->average_rating ?? 0, 1) }}
                        </span>
                        <span>{{ $movie->release_date->format('Y') }}</span>
                        <span>{{ $movie->formatted_duration }}</span>
                        @foreach($movie->categories->take(3) as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="px-2 py-1 bg-gray-700/50 rounded-full text-sm hover:bg-codeflix-primary/50 transition">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                    
                        {{-- Hidden Play Button for Thesis Focus --}}
                        {{-- 
                        <a href="#player" class="inline-flex items-center gap-2 bg-white hover:bg-gray-200 text-black font-semibold px-8 py-3 rounded-lg transition">
                            <i class="fa-solid fa-play"></i> Play
                        </a> 
                        --}}
                        
                        @auth
                            @livewire('watchlist-button', ['movieId' => $movie->id])
                        @endauth
                        
                        <!-- Trailer Button -->
                        @if($movie->trailer_url)
                        <button onclick="openTrailer()" class="inline-flex items-center justify-center w-12 h-12 bg-gray-700/80 hover:bg-gray-600 rounded-lg transition">
                            <i class="fa-brands fa-youtube text-xl text-white"></i>
                        </button>
                        @endif
                        
                        <!-- Share Button -->
                        <!-- <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center justify-center w-12 h-12 bg-gray-700/80 hover:bg-gray-600 rounded-lg transition">
                                <i class="fa-solid fa-share-nodes text-xl text-white"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute top-full mt-2 right-0 bg-codeflix-card border border-gray-800 rounded-xl shadow-xl p-3 flex gap-3">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode('Watch ' . $movie->title . ' on Codeflix!') }}" 
                                   target="_blank" class="w-10 h-10 bg-[#1DA1F2] rounded-full flex items-center justify-center hover:opacity-80">
                                    <i class="fa-brands fa-x-twitter text-white"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="w-10 h-10 bg-[#4267B2] rounded-full flex items-center justify-center hover:opacity-80">
                                    <i class="fa-brands fa-facebook-f text-white"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode('Watch ' . $movie->title . ' on Codeflix! ' . request()->url()) }}" 
                                   target="_blank" class="w-10 h-10 bg-[#25D366] rounded-full flex items-center justify-center hover:opacity-80">
                                    <i class="fa-brands fa-whatsapp text-white"></i>
                                </a>
                                <button onclick="navigator.clipboard.writeText('{{ request()->url() }}'); showToast('Link copied!', 'success')"
                                        class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-600">
                                    <i class="fa-solid fa-link text-white"></i>
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Hidden Video Player for Thesis Focus --}}
    {{-- 
    @if($streamingUrl)
    <section id="player" class="max-w-7xl mx-auto px-4 py-8 md:pl-60">
        @livewire('video-player', ['movie' => $movie, 'resolution' => $resolution ?? '1080'])
    </section>
    @endif 
    --}}

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-8 md:pl-60">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div>
                    <h2 class="font-outfit text-2xl font-semibold text-white mb-4">Sinopsis</h2>
                    <p class="text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                </div>

                <!-- Cast & Crew -->
                <div>
                    <h2 class="font-outfit text-2xl font-semibold text-white mb-4">Pemeran & Kru</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 text-sm">Sutradara</p>
                            <p class="text-white">{{ $movie->director }}</p>
                        </div>
                        @if($movie->writers)
                        <div>
                            <p class="text-gray-500 text-sm">Penulis</p>
                            <p class="text-white">{{ $movie->writers }}</p>
                        </div>
                        @endif
                        @if($movie->stars)
                        <div class="col-span-2">
                            <p class="text-gray-500 text-sm">Bintang</p>
                            <p class="text-white">{{ $movie->stars }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Reviews Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-outfit text-2xl font-semibold text-white">Ulasan</h2>
                        @auth
                        <button onclick="document.getElementById('review-form').classList.toggle('hidden')"
                                class="text-codeflix-primary hover:text-codeflix-primary/80 font-medium">
                            <i class="fa-solid fa-plus mr-1"></i> Tulis Ulasan
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-codeflix-primary text-sm transition flex items-center gap-1">
                            <i class="fa-solid fa-right-to-bracket text-xs"></i> Login untuk memberi ulasan
                        </a>
                        @endauth
                    </div>

                    <!-- Review Form -->
                    @auth
                    <div id="review-form" class="hidden bg-codeflix-card rounded-xl p-4 mb-6">
                        <form action="{{ route('reviews.store', $movie) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-400 text-sm mb-2">Rating Anda</label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer">
                                        <span class="w-8 h-8 flex items-center justify-center rounded border border-gray-700 peer-checked:bg-codeflix-primary peer-checked:border-codeflix-primary text-white">{{ $i }}</span>
                                    </label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="title" placeholder="Judul ulasan (opsional)" 
                                       class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white">
                            </div>
                            <div class="mb-4">
                                <textarea name="content" rows="4" placeholder="Tulis ulasan Anda (opsional)..." 
                                          class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white"></textarea>
                            </div>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-2 text-gray-400">
                                    <input type="checkbox" name="spoiler_warning" class="rounded border-gray-700">
                                    Mengandung bocoran
                                </label>
                                <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-medium px-6 py-2 rounded-lg">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    </div>
                    @endauth

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @forelse($movie->reviews ?? [] as $review)
                        <div class="bg-codeflix-card rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-codeflix-primary to-emerald-600 flex items-center justify-center">
                                    <span class="font-semibold">{{ substr($review->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-medium text-white">{{ $review->user->name }}</span>
                                        <span class="px-2 py-0.5 bg-codeflix-primary/20 text-codeflix-primary text-sm rounded">
                                            {{ $review->rating }}/5
                                        </span>
                                        @if($review->spoiler_warning)
                                        <span class="px-2 py-0.5 bg-red-500/20 text-red-500 text-sm rounded">Bocoran</span>
                                        @endif
                                    </div>
                                    @if($review->title)
                                    <p class="font-medium text-white mb-1">{{ $review->title }}</p>
                                    @endif
                                    <p class="text-gray-400">{{ $review->content }}</p>
                                    <p class="text-gray-600 text-sm mt-2">{{ $review->time_ago }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-regular fa-comment-dots text-4xl mb-2"></i>
                            <p>Belum ada ulasan. Jadilah yang pertama mengulas!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Similar Movies (Category Based) -->
                <div>
                    <h3 class="font-outfit text-xl font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-codeflix-primary text-sm"></i>
                        Anda Mungkin Juga Suka
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(\App\Models\Movie::whereHas('categories', fn($q) => $q->whereIn('categories.id', $movie->categories->pluck('id')))->where('id', '!=', $movie->id)->limit(4)->get() as $similar)
                        <a href="{{ route('movies.show', $similar->slug) }}" class="movie-card rounded-lg overflow-hidden group relative">
                            <img src="{{ $similar->poster }}" alt="{{ $similar->title }}" class="w-full aspect-[2/3] object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <i class="fa-solid fa-circle-info text-white text-xl"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- KNN Recommendations -->
                @auth
                @if(!empty($recommendations) && count($recommendations) > 0)
                <div class="pt-6 border-t border-gray-800">
                    <h3 class="font-outfit text-xl font-semibold text-white mb-1 flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-yellow-500 text-sm"></i>
                        Dipersonalisasi untuk Anda
                    </h3>
                    <p class="text-[10px] text-gray-500 mb-4 uppercase tracking-wider">Berdasarkan Algoritma KNN</p>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($recommendations as $rec)
                        <a href="{{ route('movies.show', $rec->slug) }}" class="movie-card rounded-lg overflow-hidden group relative">
                            <img src="{{ $rec->poster }}" alt="{{ $rec->title }}" class="w-full aspect-[2/3] object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 bg-yellow-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <i class="fa-solid fa-star text-white text-xl"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                @endauth
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Trailer Modal -->
@if($movie->trailer_url)
<div id="trailer-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90">
    <div class="relative w-full max-w-4xl mx-4">
        <button onclick="closeTrailer()" class="absolute -top-10 right-0 text-white text-2xl hover:text-codeflix-primary">
            <i class="fa-solid fa-times"></i>
        </button>
        <div class="aspect-video bg-black rounded-xl overflow-hidden">
            <iframe id="trailer-iframe" class="w-full h-full" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
        </div>
        <p class="text-center text-gray-400 mt-4">
            Can't see the video? 
            <a href="{{ $movie->trailer_url }}" target="_blank" class="text-codeflix-primary hover:underline">
                Open on YouTube <i class="fa-solid fa-external-link ml-1"></i>
            </a>
        </p>
    </div>
</div>

<script>
function getYoutubeEmbedUrl(url) {
    // Convert youtube.com/watch?v=xxx to youtube.com/embed/xxx
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) 
        ? 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1'
        : url;
}

function openTrailer() {
    const url = '{{ $movie->trailer_url }}';
    document.getElementById('trailer-modal').classList.remove('hidden');
    document.getElementById('trailer-modal').classList.add('flex');
    document.getElementById('trailer-iframe').src = getYoutubeEmbedUrl(url);
}

function closeTrailer() {
    document.getElementById('trailer-modal').classList.add('hidden');
    document.getElementById('trailer-modal').classList.remove('flex');
    document.getElementById('trailer-iframe').src = '';
}
</script>
@endif
@endsection
