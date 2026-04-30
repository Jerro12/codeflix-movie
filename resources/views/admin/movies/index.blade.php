@extends('admin.layouts.admin')

@section('title', 'Film')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-400">Kelola semua film dalam sistem</p>
    <a href="{{ route('admin.movies.create') }}" 
       class="inline-flex items-center gap-2 bg-codeflix-primary hover:bg-codeflix-primary/80 text-white px-4 py-2 rounded-lg transition">
        <i class="fa-solid fa-plus"></i>
        Tambah Film
    </a>
</div>

<!-- Movies Table -->
<div class="bg-codeflix-card rounded-xl border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-codeflix-darker">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Film</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Durasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Ditambahkan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($movies as $movie)
                <tr class="hover:bg-codeflix-darker/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover rounded">
                            <div>
                                <p class="font-medium text-white">{{ $movie->title }}</p>
                                <p class="text-sm text-gray-400">{{ $movie->release_date?->format('Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-codeflix-primary/20 text-codeflix-primary text-xs rounded">
                            {{ $movie->category?->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500 text-sm"></i>
                            <span>{{ number_format($movie->average_rating, 1) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $movie->formatted_duration }}</td>
                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $movie->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.movies.edit', $movie) }}" 
                               class="p-2 text-gray-400 hover:text-codeflix-primary hover:bg-codeflix-primary/10 rounded-lg transition">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus film ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-500/10 rounded-lg transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-film text-4xl mb-4 text-gray-600"></i>
                        <p>Tidak ada film ditemukan. Tambahkan film pertama Anda!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($movies->hasPages())
    <div class="px-6 py-4 border-t border-gray-800">
        {{ $movies->links() }}
    </div>
    @endif
</div>
@endsection
