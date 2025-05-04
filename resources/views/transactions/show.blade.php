@extends('layouts.app')

@section('title', 'Détails de la Transaction - TCG HUB')
@section('meta_description', 'Détails de votre transaction de cartes à collectionner sur TCG HUB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">Détails de la Transaction</h2>
                        <span class="badge {{ $transaction->type === 'sale' ? 'bg-success' : 'bg-primary' }}">
                            {{ $transaction->type === 'sale' ? 'Vente' : 'Échange' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3 class="h6 text-muted">Date de création</h3>
                            <p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h6 text-muted">Statut</h3>
                            <p>
                                <span class="badge {{ $transaction->status === 'completed' ? 'bg-success' : ($transaction->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h6 mb-0">Détails de la carte</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($transaction->card->image_url)
                                        <img src="{{ $transaction->card->image_url }}" alt="{{ $transaction->card->name }}" class="img-fluid rounded">
                                    @else
                                        <div class="bg-light rounded p-4 text-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="mt-2 text-muted">Image non disponible</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h4 class="h5">{{ $transaction->card->name }}</h4>
                                    <p class="text-muted">{{ $transaction->card->set_name }}</p>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h5 class="h6 text-muted">Quantité</h5>
                                            <p>{{ $transaction->quantity }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="h6 text-muted">État</h5>
                                            <p>{{ ucfirst($transaction->condition) }}</p>
                                        </div>
                                    </div>

                                    @if($transaction->type === 'sale')
                                        <div class="mt-3">
                                            <h5 class="h6 text-muted">Montant</h5>
                                            <p class="h4">{{ number_format($transaction->amount, 2) }}€</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($transaction->description)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="h6 mb-0">Description</h3>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $transaction->description }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        
                        @if($transaction->status === 'pending')
                            <div>
                                <form action="{{ route('transactions.complete', $transaction) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Marquer comme terminée
                                    </button>
                                </form>
                                
                                <form action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection