@extends('admin.layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-white" style="font-family: 'Kanit', sans-serif; font-size: 32px;">Edit Movie</h1>
    <p class="text-muted">Update {{ $movie->title }}</p>
</div>

<div class="card" style="background: var(--codeflix-bg-card); border: none; border-radius: 12px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group-admin">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control-admin" 
                               value="{{ old('title', $movie->title) }}" required>
                    </div>

                    <div class="form-group-admin">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control-admin" 
                                  rows="4" required>{{ old('description', $movie->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group-admin">
                                <label for="director">Director</label>
                                <input type="text" name="director" id="director" class="form-control-admin" 
                                       value="{{ old('director', $movie->director) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-admin">
                                <label for="duration">Duration (minutes)</label>
                                <input type="number" name="duration" id="duration" class="form-control-admin" 
                                       value="{{ old('duration', $movie->duration) }}" required min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-admin">
                                <label for="release_date">Release Date</label>
                                <input type="date" name="release_date" id="release_date" class="form-control-admin" 
                                       value="{{ old('release_date', $movie->release_date->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-admin">
                        <label for="writers">Writers</label>
                        <input type="text" name="writers" id="writers" class="form-control-admin" 
                               value="{{ old('writers', $movie->writers) }}">
                    </div>

                    <div class="form-group-admin">
                        <label for="stars">Stars</label>
                        <input type="text" name="stars" id="stars" class="form-control-admin" 
                               value="{{ old('stars', $movie->stars) }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group-admin">
                        <label for="poster">Poster URL</label>
                        <input type="url" name="poster" id="poster" class="form-control-admin" 
                               value="{{ old('poster', $movie->poster) }}" required>
                    </div>

                    @if($movie->poster)
                    <div class="mb-3">
                        <img src="{{ $movie->poster }}" alt="Current poster" 
                             style="width: 100%; max-width: 200px; border-radius: 8px;">
                    </div>
                    @endif

                    <div class="form-group-admin">
                        <label>Categories</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categories as $category)
                                <label class="d-flex align-items-center gap-1" style="color: var(--codeflix-text);">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', $movie->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr style="border-color: rgba(255,255,255,0.1);">
                    <h6 class="text-white mb-3">Streaming URLs</h6>

                    <div class="form-group-admin">
                        <label for="url_720">720p URL</label>
                        <input type="url" name="url_720" id="url_720" class="form-control-admin" 
                               value="{{ old('url_720', $movie->url_720) }}">
                    </div>

                    <div class="form-group-admin">
                        <label for="url_1080">1080p URL</label>
                        <input type="url" name="url_1080" id="url_1080" class="form-control-admin" 
                               value="{{ old('url_1080', $movie->url_1080) }}">
                    </div>

                    <div class="form-group-admin">
                        <label for="url_4k">4K URL</label>
                        <input type="url" name="url_4k" id="url_4k" class="form-control-admin" 
                               value="{{ old('url_4k', $movie->url_4k) }}">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn-admin-primary">
                    <i class="fa-solid fa-save me-2"></i>Update Movie
                </button>
                <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
