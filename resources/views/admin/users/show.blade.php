@extends('admin.layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="space-y-8">
    <!-- Header with Back Button -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-900 border border-gray-800 text-gray-400 hover:text-white hover:border-gray-700 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-outfit text-2xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-sm text-gray-400">ID Pengguna: #{{ $user->id }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                @csrf
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 border border-gray-800 hover:border-gray-700 text-white font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid {{ $user->is_admin ? 'fa-user-minus text-red-500' : 'fa-user-plus text-green-500' }}"></i>
                    {{ $user->is_admin ? 'Hapus dari Admin' : 'Jadikan Admin' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: User Profile & Subscription -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profil Card -->
            <div class="bg-codeflix-card rounded-2xl border border-gray-800 p-6 space-y-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-codeflix-primary/20 rounded-full flex items-center justify-center text-3xl font-bold text-codeflix-primary mb-4 border-2 border-codeflix-primary/30">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $user->name }}</h3>
                    <div class="flex gap-2">
                        @if($user->is_admin)
                            <span class="px-2.5 py-0.5 bg-purple-500/20 text-purple-400 text-xs rounded-full font-medium border border-purple-500/30">Admin</span>
                        @else
                            <span class="px-2.5 py-0.5 bg-blue-500/20 text-blue-400 text-xs rounded-full font-medium border border-blue-500/30">Pengguna</span>
                        @endif
                        
                        @if($user->age_category)
                            <span class="px-2.5 py-0.5 bg-codeflix-primary/20 text-codeflix-primary text-xs rounded-full font-medium border border-codeflix-primary/30 uppercase">{{ $user->age_category }}</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-800 my-4"></div>

                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-gray-400 block mb-1">Email</span>
                        <span class="text-white font-medium">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-1">NIK</span>
                        <span class="text-white font-medium">{{ $user->nik ?? 'Belum diisi' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-1">Tanggal Lahir</span>
                        <span class="text-white font-medium">{{ $user->birth_date ? $user->birth_date->format('d M Y') : 'Belum diisi' }}</span>
                    </div>
                    @if($user->birth_date)
                    <div>
                        <span class="text-gray-400 block mb-1">Usia</span>
                        <span class="text-white font-medium">{{ $user->age }} Tahun</span>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-400 block mb-1">Bergabung Sejak</span>
                        <span class="text-white font-medium">{{ $user->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>


        </div>

        <!-- Right Side: Watchlist, Watch History, and Subscriptions History -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Riwayat Rating & Ulasan Card -->
            <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="font-outfit text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-star text-codeflix-primary"></i> Riwayat Rating & Ulasan
                    </h3>
                </div>
                <div class="divide-y divide-gray-800 max-h-[350px] overflow-y-auto">
                    @forelse($user->reviews as $review)
                        @if($review->movie)
                        <div class="p-4 hover:bg-codeflix-darker/30 transition flex gap-4">
                            <img src="{{ $review->movie->poster }}" alt="{{ $review->movie->title }}" class="w-12 h-16 object-cover rounded-lg border border-gray-800 flex-shrink-0">
                            <div class="flex-grow space-y-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <h4 class="font-semibold text-white truncate">{{ $review->movie->title }}</h4>
                                    <div class="flex items-center gap-1 bg-yellow-500/10 text-yellow-400 px-2 py-0.5 rounded text-xs font-bold border border-yellow-500/20 whitespace-nowrap">
                                        {{ $review->rating }}/5 <i class="fa-solid fa-star text-[10px]"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                
                                @if($review->title || $review->content)
                                <div class="mt-2 text-xs text-gray-300 bg-codeflix-dark p-3 rounded-lg border border-gray-800">
                                    @if($review->title)
                                        <p class="font-semibold text-white mb-1">{{ $review->title }}</p>
                                    @endif
                                    @if($review->content)
                                        <p class="italic leading-relaxed">"{{ $review->content }}"</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="p-8 text-center text-gray-500 italic">
                            Belum ada riwayat rating & ulasan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Watchlist Card -->
            <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-800">
                    <h3 class="font-outfit text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-bookmark text-codeflix-primary"></i> Film yang Disimpan (Watchlist)
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-h-[250px] overflow-y-auto pr-2">
                        @forelse($user->watchlist as $watchlist)
                            @if($watchlist->movie)
                            <div class="space-y-2 group">
                                <div class="relative aspect-[2/3] rounded-lg overflow-hidden border border-gray-800">
                                    <img src="{{ $watchlist->movie->poster }}" alt="{{ $watchlist->movie->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <h4 class="font-medium text-xs text-white truncate" title="{{ $watchlist->movie->title }}">{{ $watchlist->movie->title }}</h4>
                            </div>
                            @endif
                        @empty
                            <div class="col-span-full py-8 text-center text-gray-500 italic">
                                Belum ada film di Daftar Saya.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
