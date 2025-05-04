@extends('layouts.app')

@section('title', 'Mon tableau de bord - TCG HUB')
@section('meta_description', 'Gérez votre profil, vos événements, votre collection et vos transactions sur TCG HUB')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Mon Tableau de Bord</h1>
            <p class="text-muted">Gérez votre profil et vos activités sur TCG HUB</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                            <span class="h3">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        @endif
                        <h2 class="h4 mt-3">{{ Auth::user()->name }}</h2>
                        <p class="text-muted">Membre depuis {{ Auth::user()->created_at->format('M Y') }}</p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ Auth::user()->city ? Auth::user()->city . ', ' : '' }}{{ Auth::user()->country }}
                        </p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('my-collection') }}" class="btn btn-primary">
                            <i class="fas fa-folder"></i> Ma Collection
                        </a>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-exchange-alt"></i> Mes Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 m-0">Mes Événements</h2>
                    <a href="{{ route('my-events') }}" class="btn btn-sm btn-link">Voir tous</a>
                </div>
                <div class="card-body">
                    @if(Auth::user()->organizedEvents && Auth::user()->organizedEvents->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach(Auth::user()->organizedEvents()->orderBy('start_date')->take(3)->get() as $event)
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $event->name }}</h5>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-calendar"></i> {{ $event->start_date->format('d/m/Y') }}
                                        <i class="fas fa-map-marker-alt ms-2"></i> {{ $event->city }}
                                    </p>
                                </div>
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-3">Vous n'avez pas encore organisé d'événements.</p>
                        <a href="{{ route('events.create') }}" class="btn btn-primary">Créer votre premier événement</a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 m-0">Transactions Récentes</h2>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-link">Voir toutes</a>
                </div>
                <div class="card-body">
                    @if(Auth::user()->transactions && Auth::user()->transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Carte</th>
                                    <th>Montant</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->transactions()->orderBy('created_at', 'desc')->take(5)->get() as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ $transaction->card->name }}</td>
                                    <td>{{ $transaction->amount }}€</td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-link">Détails</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-3">Vous n'avez pas encore de transactions.</p>
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Créer une transaction</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection