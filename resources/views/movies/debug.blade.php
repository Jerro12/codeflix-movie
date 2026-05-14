@extends('layouts.app-new')

@section('title', 'Recommendation Engine Debug')

@section('content')
<div class="pt-24 pb-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="font-outfit text-3xl font-bold text-white mb-2">
                <i class="fa-solid fa-flask-vial text-yellow-500 mr-2"></i>
                Recommendation Engine Debug (KNN)
            </h1>
            <p class="text-gray-400">Visualisasi langkah-langkah algoritma K-Nearest Neighbors untuk skripsi.</p>
        </div>

        @if(isset($debugData['error']))
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl mb-8 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <p>{{ $debugData['error'] }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Step 1: Target User Info -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
                        <div class="p-6 border-b border-gray-800 bg-codeflix-primary/5">
                            <h3 class="font-semibold text-white flex items-center gap-2">
                                <span class="w-6 h-6 bg-codeflix-primary rounded flex items-center justify-center text-[10px]">1</span>
                                Profil User (Input)
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Target User</p>
                                <p class="text-white text-lg font-medium">{{ $debugData['target_user']['name'] }}</p>
                            </div>
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Total Rating Diberikan</p>
                                <p class="text-codeflix-primary text-2xl font-bold">{{ $debugData['target_user']['ratings_count'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold mb-2">Riwayat Rating</p>
                                <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                                    @foreach($debugData['target_user']['ratings'] as $r)
                                        <div class="flex items-center justify-between p-2 bg-black/30 rounded text-sm">
                                            <span class="text-gray-300 truncate mr-2">{{ $r['title'] }}</span>
                                            <span class="text-yellow-500 font-bold">{{ $r['rating'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Algorithm Settings -->
                    <div class="bg-codeflix-card rounded-2xl border border-gray-800 p-6">
                        <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-sliders text-gray-500"></i>
                            Parameter Algoritma
                        </h3>
                        <form action="{{ route('movies.debug') }}" method="GET" class="space-y-4">
                            <div>
                                <label class="block text-xs text-gray-500 uppercase font-bold mb-2">Nilai K (Neighbors)</label>
                                <select name="k" onchange="this.form.submit()" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white">
                                    @foreach([3, 5, 10, 20, 50] as $kVal)
                                        <option value="{{ $kVal }}" {{ $k == $kVal ? 'selected' : '' }}>K = {{ $kVal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                                <p class="text-[10px] text-blue-400 italic">
                                    <i class="fa-solid fa-info-circle mr-1"></i>
                                    Metode Similaritas: Cosine Similarity (Sesuai Bab 2 Skripsi).
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Step 2: Neighbors Calculation -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Similarities Table -->
                    <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
                        <div class="p-6 border-b border-gray-800 bg-yellow-500/5">
                            <h3 class="font-semibold text-white flex items-center gap-2">
                                <span class="w-6 h-6 bg-yellow-500 rounded flex items-center justify-center text-[10px]">2</span>
                                Pencarian Tetangga Terdekat (Top K)
                            </h3>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-black/20 text-xs text-gray-500 uppercase">
                                    <tr>
                                        <th class="px-6 py-4">User Lain</th>
                                        <th class="px-6 py-4 text-center">Film Sama</th>
                                        <th class="px-6 py-4">Skor Similaritas</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @php $isNeighbor = true; @endphp
                                    @foreach($debugData['all_similarities'] as $index => $sim)
                                        @if($index == $debugData['k_parameter']) @php $isNeighbor = false; @endphp @endif
                                        <tr class="{{ $isNeighbor ? 'bg-yellow-500/5' : '' }}">
                                            <td class="px-6 py-4">
                                                <p class="text-white font-medium">{{ $sim['user_name'] }}</p>
                                                <p class="text-[10px] text-gray-500">ID: {{ $sim['user_id'] }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-300">
                                                {{ $sim['common_movies_count'] }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex-1 h-1.5 bg-gray-700 rounded-full overflow-hidden">
                                                        <div class="h-full bg-yellow-500" style="width: {{ max(0, $sim['similarity'] * 100) }}%"></div>
                                                    </div>
                                                    <span class="text-xs font-mono text-yellow-500">{{ number_format($sim['similarity'], 4) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($isNeighbor)
                                                    <span class="px-2 py-1 bg-yellow-500 text-black text-[10px] font-bold rounded">NEIGHBOR</span>
                                                @else
                                                    <span class="text-[10px] text-gray-600">NOT K-NEAREST</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Predictions Table -->
                    <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
                        <div class="p-6 border-b border-gray-800 bg-green-500/5">
                            <h3 class="font-semibold text-white flex items-center gap-2">
                                <span class="w-6 h-6 bg-green-500 rounded flex items-center justify-center text-[10px]">3</span>
                                Prediksi Rating (Output)
                            </h3>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-black/20 text-xs text-gray-500 uppercase">
                                    <tr>
                                        <th class="px-6 py-4">Judul Film</th>
                                        <th class="px-6 py-4 text-right">Skor Prediksi</th>
                                        <th class="px-6 py-4">Peringkat Rekomendasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @foreach($debugData['predictions'] as $index => $pred)
                                        <tr>
                                            <td class="px-6 py-4 text-white font-medium">
                                                {{ $pred['movie_title'] }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if($pred['predicted_rating'] > 0)
                                                    <span class="text-lg font-bold text-green-400">{{ number_format($pred['predicted_rating'], 2) }}</span>
                                                    <span class="text-[10px] text-gray-500 ml-1">/ 5</span>
                                                @else
                                                    <span class="text-xs font-medium text-gray-500 italic">Cold Start (Tanpa Rating)</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 bg-gray-800 text-gray-300 text-xs rounded-full">#{{ $index + 1 }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
