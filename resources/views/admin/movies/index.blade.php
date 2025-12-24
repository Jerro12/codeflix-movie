@extends('admin.layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-white" style="font-family: 'Kanit', sans-serif; font-size: 32px;">Movies</h1>
        <p class="text-muted">Manage all movies in the catalog</p>
    </div>
    <a href="{{ route('admin.movies.create') }}" class="btn-admin-primary">
        <i class="fa-solid fa-plus me-2"></i>Add Movie
    </a>
</div>

<div class="card" style="background: var(--codeflix-bg-card); border: none; border-radius: 12px;">
    <div class="card-body p-0">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Categories</th>
                    <th>Duration</th>
                    <th>Release Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movies as $movie)
                <tr>
                    <td>
                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
                             style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px;">
                    </td>
                    <td>{{ $movie->title }}</td>
                    <td>
                        @foreach($movie->categories as $category)
                            <span class="badge-admin badge-admin-primary">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $movie->formatted_duration }}</td>
                    <td>{{ $movie->release_date->format('d M Y') }}</td>
                    <td>
                        <div class="admin-table-actions">
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-admin-primary">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-admin-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No movies found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $movies->links() }}
</div>
@endsection
