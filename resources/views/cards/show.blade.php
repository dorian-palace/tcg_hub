@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ $card->name }}</div>
                        <a href="{{ route('cards.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('Retour au catalogue') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($card->image_url)
                                <img src="{{ $card->image_url }}" class="img-fluid rounded" alt="{{ $card->name }}" style="max-height: 400px;">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center rounded" style="height: 300px;">
                                    <span class="text-muted">{{ __('Pas d\'image disponible') }}</span>
                                </div>
                            @endif
                            
                            @auth
                                <div class="mt-3">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addToCollectionModal">
                                        {{ __('Ajouter à ma collection') }}
                                    </button>
                                </div>
                            @endauth
                        </div>
                        
                        <div class="col-md-8">
                            <h3>{{ $card->name }}</h3>
                            <div class="mb-4">
                                <div><strong>{{ __('Jeu:') }}</strong> {{ $card->game->name }}</div>
                                <div><strong>{{ __('Set / Édition:') }}</strong> {{ $card->set }}</div>
                                @if($card->rarity)
                                    <div><strong>{{ __('Rareté:') }}</strong> {{ $card->rarity }}</div>
                                @endif
                            </div>
                            
                            @if($card->description)
                                <div class="mb-4">
                                    <h5>{{ __('Description') }}</h5>
                                    <p>{{ $card->description }}</p>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <h5>{{ __('Disponibilité') }}</h5>
                                @if(count($availability) > 0)
                                    <p>{{ __('Cette carte est disponible auprès de') }} <strong>{{ count($availability) }}</strong> {{ __('collectionneurs.') }}</p>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Vendeur') }}</th>
                                                    <th>{{ __('État') }}</th>
                                                    <th>{{ __('Quantité') }}</th>
                                                    <th>{{ __('Statut') }}</th>
                                                    <th>{{ __('Prix') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($availability as $item)
                                                    <tr>
                                                        <td>{{ $item->user->name }}</td>
                                                        <td>
                                                            @if($item->condition == 'mint')
                                                                <span class="badge bg-success">{{ __('Mint') }}</span>
                                                            @elseif($item->condition == 'near_mint')
                                                                <span class="badge bg-info">{{ __('Near Mint') }}</span>
                                                            @elseif($item->condition == 'excellent')
                                                                <span class="badge bg-primary">{{ __('Excellent') }}</span>
                                                            @elseif($item->condition == 'good')
                                                                <span class="badge bg-secondary">{{ __('Good') }}</span>
                                                            @elseif($item->condition == 'played')
                                                                <span class="badge bg-warning">{{ __('Played') }}</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ __('Poor') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>
                                                            @if($item->for_sale)
                                                                <span class="badge bg-success">{{ __('À vendre') }}</span>
                                                            @endif

                                                            @if($item->for_trade)
                                                                <span class="badge bg-info">{{ __('À échanger') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($item->for_sale && $item->price)
                                                                {{ number_format($item->price, 2) }} €
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @auth
                                                                @if($item->user_id != Auth::id())
                                                                    <a href="{{ route('transactions.create', ['seller_id' => $item->user_id, 'collection_id' => $item->id]) }}" class="btn btn-sm btn-primary">
                                                                        {{ __('Acheter/Échanger') }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">{{ __('Vous') }}</span>
                                                                @endif
                                                            @else
                                                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                                                    {{ __('Connectez-vous') }}
                                                                </a>
                                                            @endauth
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        {{ __('Cette carte n\'est actuellement disponible auprès d\'aucun vendeur.') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
<!-- Add to Collection Modal -->
<div class="modal fade" id="addToCollectionModal" tabindex="-1" aria-labelledby="addToCollectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCollectionModalLabel">{{ __('Ajouter à ma collection') }} - {{ $card->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('collections.store') }}" method="POST">
                @csrf
                <input type="hidden" name="card_id" value="{{ $card->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">{{ __('Quantité') }}</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="condition" class="form-label">{{ __('État') }}</label>
                        <select class="form-control" id="condition" name="condition" required>
                            <option value="">{{ __('Sélectionner un état') }}</option>
                            <option value="mint">{{ __('Mint (Neuf)') }}</option>
                            <option value="near_mint">{{ __('Near Mint (Presque Neuf)') }}</option>
                            <option value="excellent">{{ __('Excellent') }}</option>
                            <option value="good">{{ __('Good (Bon)') }}</option>
                            <option value="played">{{ __('Played (Joué)') }}</option>
                            <option value="poor">{{ __('Poor (Mauvais)') }}</option>
                        </select>
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="for_sale" name="for_sale">
                        <label class="form-check-label" for="for_sale">{{ __('Disponible à la vente') }}</label>
                    </div>
                    
                    <div class="mb-3 sale-details" style="display: none;">
                        <label for="price" class="form-label">{{ __('Prix (€)') }}</label>
                        <input type="number" class="form-control" id="price" name="price" value="0.00" min="0" step="0.01">
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="for_trade" name="for_trade">
                        <label class="form-check-label" for="for_trade">{{ __('Disponible à l\''échange') }}</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Annuler') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Ajouter') }}</button>
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
                saleDetailsDiv.style.display = this.checked ? 'block' : 'none';
            });
        }
    });
</script>
@endpush
@endauth

@endsection