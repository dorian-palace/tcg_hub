@extends('layouts.app')

@section('title', 'Nouvelle Transaction - TCG HUB')
@section('meta_description', 'Créez une nouvelle transaction de cartes à collectionner sur TCG HUB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2 class="h5 mb-0">Nouvelle Transaction</h2>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de transaction</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Vente</option>
                                <option value="exchange" {{ old('type') == 'exchange' ? 'selected' : '' }}>Échange</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="card_id" class="form-label">Carte</label>
                            <select name="card_id" id="card_id" class="form-select @error('card_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez une carte</option>
                                @foreach($collections as $gameName => $gameCollections)
                                    <optgroup label="{{ $gameName }}">
                                        @foreach($gameCollections as $collection)
                                            <option value="{{ $collection->card->id }}" {{ old('card_id') == $collection->card->id ? 'selected' : '' }}>
                                                {{ $collection->card->name }} ({{ $collection->card->set_name }})
                                                @if($collection->quantity > 1)
                                                    - x{{ $collection->quantity }}
                                                @endif
                                                @if($collection->condition !== 'near_mint')
                                                    - {{ ucfirst($collection->condition) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('card_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantité</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                   value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="condition" class="form-label">État</label>
                            <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror" required>
                                <option value="">Sélectionnez un état</option>
                                <option value="mint" {{ old('condition') == 'mint' ? 'selected' : '' }}>Mint</option>
                                <option value="near_mint" {{ old('condition') == 'near_mint' ? 'selected' : '' }}>Near Mint</option>
                                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="light_played" {{ old('condition') == 'light_played' ? 'selected' : '' }}>Light Played</option>
                                <option value="played" {{ old('condition') == 'played' ? 'selected' : '' }}>Played</option>
                                <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            @error('condition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="amount-field" style="display: none;">
                            <label for="amount" class="form-label">Montant (€)</label>
                            <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount') }}" step="0.01" min="0">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optionnel)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer la transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const amountField = document.getElementById('amount-field');

        function toggleAmountField() {
            amountField.style.display = typeSelect.value === 'sale' ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleAmountField);
        toggleAmountField(); // Initial state
    });
</script>
@endpush
@endsection