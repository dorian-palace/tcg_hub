@extends('layouts.app')

@section('title', 'Ma collection - TCG HUB')
@section('meta_description', 'Gérez votre collection de cartes TCG sur TCG HUB')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ma collection</h1>
        <div>
            <a href="#" class="btn btn-outline-primary me-2">Importer</a>
            <a href="#" class="btn btn-primary">Ajouter une carte</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-group">
                <label for="game">Jeu</label>
                <select id="game" class="form-select">
                    <option value="">Tous les jeux</option>
                    @foreach(\App\Models\Game::all() as $game)
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="set">Set</label>
                <select id="set" class="form-select">
                    <option value="">Tous les sets</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="search">Recherche</label>
                <input type="text" id="search" class="form-control" placeholder="Nom de la carte...">
            </div>
        </div>
    </div>

    <div class="row">
        @if(count(Auth::user()->collections) > 0)
            @foreach(Auth::user()->collections as $collection)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ $collection->card->image_url ?? 'https://via.placeholder.com/300x420' }}" class="card-img-top" alt="{{ $collection->card->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $collection->card->name }}</h5>
                            <p class="card-text text-muted">{{ $collection->card->set_name }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-secondary">{{ ucfirst($collection->condition) }}</span>
                                <span class="badge bg-info">x{{ $collection->quantity }}</span>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                @if($collection->for_trade)
                                    <span class="badge bg-success">Échange</span>
                                @endif
                                @if($collection->for_sale)
                                    <span class="badge bg-warning text-dark">Vente {{ $collection->price }}€</span>
                                @endif
                            </div>
                            <div>
                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <p class="mb-0">Votre collection est vide pour le moment.</p>
                </div>
                <p class="mt-3">Commencez par ajouter des cartes à votre collection.</p>
            </div>
        @endif
    </div>
</div>
@endsection