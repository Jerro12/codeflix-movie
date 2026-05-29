@extends('admin.layouts.admin')

@section('title', 'Edit Movie')

@section('content')
<div class="max-w-4xl">
    <div class="bg-codeflix-card rounded-2xl border border-gray-800 overflow-hidden">
        <div class="p-6 border-b border-gray-800">
            <h3 class="text-xl font-semibold text-white">Update Movie Details</h3>
            <p class="text-sm text-gray-400 mt-1">Editing: {{ $movie->title }}</p>
        </div>

        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Movie Title</label>
                    <input type="text" name="title" id="title" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('title', $movie->title) }}" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description / Synopsis</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                              required>{{ old('description', $movie->description) }}</textarea>
                </div>

                <!-- Director -->
                <div>
                    <label for="director" class="block text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input type="text" name="director" id="director" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('director', $movie->director) }}" required>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-300 mb-2">Duration (minutes)</label>
                    <input type="number" name="duration" id="duration" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('duration', $movie->duration) }}" required min="1">
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-300 mb-2">Rating (0-10)</label>
                    <input type="number" name="rating" id="rating" step="0.1" min="0" max="10"
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('rating', $movie->rating) }}" placeholder="e.g. 8.5">
                </div>

                <!-- Age Rating -->
                <div>
                    <label for="age_rating" class="block text-sm font-medium text-gray-300 mb-2">Age Rating</label>
                    @php
                        $ratingLabels = [
                            'SU' => 'SU - Semua Umur',
                            'Anak' => 'Anak-anak',
                            '13+' => '13+ - Remaja',
                            '17+' => '17+ - Dewasa',
                        ];
                    @endphp
                    <select name="age_rating" id="age_rating" 
                            class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition">
                        <option value="">Select Rating</option>
                        @foreach($ratingLabels as $value => $label)
                            <option value="{{ $value }}" {{ old('age_rating', $movie->age_rating) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Release Date -->
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-300 mb-2">Release Date</label>
                    <input type="date" name="release_date" id="release_date" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}" required>
                </div>

                <!-- Poster URL -->
                <div class="flex gap-4 items-start">
                    <div class="flex-1">
                        <label for="poster" class="block text-sm font-medium text-gray-300 mb-2">Poster Image URL (Vertical)</label>
                        <input type="url" name="poster" id="poster" 
                               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                               value="{{ old('poster', $movie->poster) }}" required>
                    </div>
                    @if($movie->poster)
                        <img src="{{ $movie->poster }}" alt="Current poster" class="w-16 h-24 object-cover rounded-lg border border-gray-700 mt-7">
                    @endif
                </div>

                <!-- Banner URL -->
                <div class="flex gap-4 items-start">
                    <div class="flex-1">
                        <label for="banner" class="block text-sm font-medium text-gray-300 mb-2">Banner Image URL (Horizontal)</label>
                        <input type="url" name="banner" id="banner" 
                               class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                               value="{{ old('banner', $movie->banner) }}">
                    </div>
                    @if($movie->banner)
                        <img src="{{ $movie->banner }}" alt="Current banner" class="w-32 h-20 object-cover rounded-lg border border-gray-700 mt-7">
                    @endif
                </div>

                <!-- Writers -->
                <div class="md:col-span-2">
                    <label for="writers" class="block text-sm font-medium text-gray-300 mb-2">Writers</label>
                    <input type="text" name="writers" id="writers" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('writers', $movie->writers) }}">
                </div>

                <!-- Stars -->
                <div class="md:col-span-2">
                    <label for="stars" class="block text-sm font-medium text-gray-300 mb-2">Stars / Cast</label>
                    <input type="text" name="stars" id="stars" 
                           class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-codeflix-primary focus:ring-1 focus:ring-codeflix-primary transition"
                           value="{{ old('stars', $movie->stars) }}">
                </div>

                <!-- Categories -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-3">Categories</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-gray-900/50 p-4 rounded-xl border border-gray-800">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                       class="rounded border-gray-700 text-codeflix-primary focus:ring-codeflix-primary bg-gray-800"
                                       {{ in_array($category->id, old('categories', $movie->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-400 group-hover:text-white transition">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Platforms -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-3">Platform Streaming</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-gray-900/50 p-4 rounded-xl border border-gray-800">
                        @php
                            $availablePlatforms = ['Netflix', 'Disney+ Hotstar', 'Prime Video', 'HBO Go', 'Apple TV+', 'Viu'];
                            $moviePlatforms = $movie->platforms ?? [];
                        @endphp
                        @foreach($availablePlatforms as $platform)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="platforms[]" value="{{ $platform }}"
                                       class="rounded border-gray-700 text-codeflix-primary focus:ring-codeflix-primary bg-gray-800"
                                       {{ in_array($platform, old('platforms', $moviePlatforms)) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-400 group-hover:text-white transition">{{ $platform }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-800 flex items-center gap-4">
                <button type="submit" class="bg-codeflix-primary hover:bg-codeflix-primary/80 text-white font-semibold px-8 py-3 rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Update Movie
                </button>
                <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-white font-medium transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
