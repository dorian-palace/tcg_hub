@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('games.index') }}">Games</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Game</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h1 class="h3 mb-0">Add New Trading Card Game</h1>
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

                    <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Game Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publisher" class="form-label">Publisher *</label>
                            <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher') }}" required>
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="release_date" class="form-label">Release Date</label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date') }}">
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Official Website</label>
                            <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="website_url" name="website_url" value="{{ old('website_url') }}">
                            @error('website_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Game Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            <div class="form-text">Upload an image for the game (logo or box art)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('games.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Game</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection