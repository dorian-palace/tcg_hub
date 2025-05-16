@extends('layouts.app')

@section('title', 'Mes Transactions - TCGalaxy')
@section('meta_description', 'Gérez vos transactions de cartes à collectionner sur TCGalaxy')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Mes Transactions</h1>
            <p class="text-muted">Gérez vos ventes et échanges de cartes</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Transaction
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($transactions) && $transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Carte</th>
                                <th>Quantité</th>
                                <th>État</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($transaction->type === 'sale')
                                            <span class="badge bg-success">Vente</span>
                                        @else
                                            <span class="badge bg-primary">Échange</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->card->name }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ ucfirst($transaction->condition) }}</td>
                                    <td>
                                        @if($transaction->type === 'sale')
                                            {{ number_format($transaction->amount, 2) }}€
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-3">Vous n'avez pas encore de transactions.</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer une transaction
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection