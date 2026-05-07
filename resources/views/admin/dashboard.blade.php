@extends('admin.layouts.admin')

@section('title', 'Dasbor')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-users text-blue-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['total_users'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Pengguna</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-film text-purple-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['total_movies'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Film</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-codeflix-primary/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-list text-codeflix-primary text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['total_categories'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Kategori</p>
    </div>

    <div class="bg-codeflix-card rounded-xl p-6 border border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-star text-yellow-500 text-xl"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-white mb-1">{{ $stats['total_reviews'] ?? 0 }}</h3>
        <p class="text-gray-400 text-sm">Total Ulasan</p>
    </div>
</div>

<!-- Recent Movies Section -->
<div class="bg-codeflix-card rounded-xl border border-gray-800 mb-8 overflow-hidden">
    <div class="p-6 border-b border-gray-800 flex items-center justify-between">
        <h2 class="font-outfit text-lg font-semibold">Film Baru Ditambahkan</h2>
        <a href="{{ route('admin.movies.index') }}" class="text-sm text-codeflix-primary hover:underline">Lihat Semua</a>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            @forelse($recentMovies ?? [] as $movie)
            <div class="space-y-3 group">
                <div class="relative aspect-[2/3] rounded-lg overflow-hidden border border-gray-800">
                    <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-2 right-2 flex flex-col gap-1 items-end">
                        <div class="bg-black/60 backdrop-blur-md px-2 py-1 rounded text-[10px] font-bold text-white flex items-center gap-1 border border-white/10">
                            <i class="fa-solid fa-star text-yellow-500"></i>
                            {{ number_format($movie->rating ?? 0, 1) }}
                        </div>
                        @if($movie->age_rating)
                        <div class="bg-codeflix-primary/80 backdrop-blur-md px-2 py-1 rounded text-[10px] font-bold text-white border border-white/10">
                            {{ $movie->age_rating }}
                        </div>
                        @endif
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-sm text-white truncate">{{ $movie->title }}</h4>
                    <p class="text-xs text-gray-500">{{ $movie->release_date?->format('Y') }} • {{ $movie->formatted_duration }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-8 text-center text-gray-500 italic">
                Belum ada film yang ditambahkan.
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-codeflix-card rounded-xl border border-gray-800">
        <div class="p-6 border-b border-gray-800">
            <h2 class="font-outfit text-lg font-semibold">Pengguna Terbaru</h2>
        </div>
        <div class="p-6">
            @forelse($recentUsers ?? [] as $user)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-800' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-codeflix-primary/20 rounded-full flex items-center justify-center">
                        <span class="text-codeflix-primary font-semibold">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>
                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-4">Tidak ada pengguna terbaru</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Ratings -->
    <div class="bg-codeflix-card rounded-xl border border-gray-800">
        <div class="p-6 border-b border-gray-800">
            <h2 class="font-outfit text-lg font-semibold">Rating Terbaru</h2>
        </div>
        <div class="p-6">
            @forelse($recentReviews ?? [] as $review)
            <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-800' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-star text-yellow-500 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-sm">
                            <span class="text-white">{{ $review->user->name }}</span>
                            <span class="text-gray-400 mx-1">memberi rating</span>
                            <span class="text-white font-bold">{{ $review->rating }}/5 <i class="fa-solid fa-star text-yellow-500 text-[10px]"></i></span>
                        </p>
                        <p class="text-xs text-gray-400 truncate max-w-[180px] md:max-w-[250px]">
                            pada <span class="text-white">{{ optional($review->movie)->title ?? 'Film Tidak Diketahui' }}</span>
                        </p>
                    </div>
                </div>
                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-4">Tidak ada rating terbaru</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
