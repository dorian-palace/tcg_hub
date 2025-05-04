@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ajouter des cartes à ma collection') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('collections.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="card_id" class="col-md-4 col-form-label text-md-right">{{ __('Carte') }}</label>

                            <div class="col-md-6">
                                <select id="card_id" class="form-control @error('card_id') is-invalid @enderror" name="card_id" required>
                                    <option value="">{{ __('Sélectionner une carte') }}</option>
                                    @foreach($cards as $card)
                                        <option value="{{ $card->id }}" {{ old('card_id') == $card->id ? 'selected' : '' }}>
                                            {{ $card->name }} ({{ $card->set }}) - {{ $card->game->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('card_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#newCardModal">
                                        {{ __('Carte non listée ?') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantité') }}</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', 1) }}" required>

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="condition" class="col-md-4 col-form-label text-md-right">{{ __('État') }}</label>

                            <div class="col-md-6">
                                <select id="condition" class="form-control @error('condition') is-invalid @enderror" name="condition" required>
                                    <option value="">{{ __('Sélectionner un état') }}</option>
                                    <option value="mint" {{ old('condition') == 'mint' ? 'selected' : '' }}>{{ __('Mint (Neuf)') }}</option>
                                    <option value="near_mint" {{ old('condition') == 'near_mint' ? 'selected' : '' }}>{{ __('Near Mint (Presque Neuf)') }}</option>
                                    <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>{{ __('Excellent') }}</option>
                                    <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>{{ __('Good (Bon)') }}</option>
                                    <option value="played" {{ old('condition') == 'played' ? 'selected' : '' }}>{{ __('Played (Joué)') }}</option>
                                    <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>{{ __('Poor (Mauvais)') }}</option>
                                </select>

                                @error('condition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="for_sale" name="for_sale" {{ old('for_sale') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="for_sale">{{ __('Disponible à la vente') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3 sale-details" style="display: {{ old('for_sale') ? 'flex' : 'none' }}">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Prix (€)') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', '0.00') }}">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="for_trade" name="for_trade" {{ old('for_trade') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="for_trade">{{ __('Disponible à l\''échange') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

                            <div class="col-md-6">
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="2">{{ old('notes') }}</textarea>

                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ajouter à ma collection') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for new card -->
<div class="modal fade" id="newCardModal" tabindex="-1" aria-labelledby="newCardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCardModalLabel">{{ __('Ajouter une nouvelle carte') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('cards.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Nom de la carte') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="game_id" class="form-label">{{ __('Jeu') }}</label>
                        <select class="form-control" id="game_id" name="game_id" required>
                            <option value="">{{ __('Sélectionner un jeu') }}</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="set" class="form-label">{{ __('Set / Édition') }}</label>
                        <input type="text" class="form-control" id="set" name="set" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rarity" class="form-label">{{ __('Rareté') }}</label>
                        <input type="text" class="form-control" id="rarity" name="rarity">
                    </div>
                    
                    <div class="mb-3">
                        <label for="image_url" class="form-label">{{ __('URL de l\'image (optionnel)') }}</label>
                        <input type="url" class="form-control" id="image_url" name="image_url">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('Description (optionnel)') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Annuler') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Créer la carte') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forSaleCheckbox = document.getElementById('for_sale');
        const saleDetailsDiv = document.querySelector('.sale-details');
        
        if (forSaleCheckbox && saleDetailsDiv) {
            forSaleCheckbox.addEventListener('change', function() {
                saleDetailsDiv.style.display = this.checked ? 'flex' : 'none';
            });
        }
    });
</script>
@endpush
@endsection