@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('games.index') }}">Games</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('games.show', $game) }}">{{ $game->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h1 class="h3 mb-0">Edit Game: {{ $game->name }}</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('games.update', $game) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Game Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $game->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publisher" class="form-label">Publisher *</label>
                            <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $game->publisher) }}" required>
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Release Date</label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date', $game->release_date ? $game->release_date->format('Y-m-d') : '') }}">
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $game->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Official Website</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url', $game->website_url) }}">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            @if($game->image_url)
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="mb-2">
                                    <img src="{{ $game->image_url }}" alt="{{ $game->name }}" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            </div>
                            @endif

                            <label for="image" class="form-label">Replace Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            <div class="form-text">Upload a new image to replace the current one (leave empty to keep the current image)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('games.show', $game) }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Game</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="h5 mb-0 text-danger">Danger Zone</h3>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Permanently delete this game and all associated cards. This action cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('games.destroy', $game) }}" onsubmit="return confirm('Are you sure you want to delete this game? This will also delete all associated cards and cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Game</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection