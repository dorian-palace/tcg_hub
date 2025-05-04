@extends('layouts.app')

@section('title', 'Cartes')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Cartes</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cards as $card)
            <div class="card bg-dark-secondary hover:bg-dark-accent transition-all duration-300">
                <div class="p-4">
                    <div class="flex items-center justify-center h-48 mb-4 bg-dark-primary rounded-lg">
                        <i class="fas fa-cards-blank text-6xl text-blue-400"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">{{ $card->name }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-dark-text-secondary">Jeu</span>
                            <span class="text-blue-400">{{ $card->game->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-text-secondary">Extension</span>
                            <span class="text-blue-400">{{ $card->set_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark-text-secondary">Rareté</span>
                            <span class="text-blue-400">{{ $card->rarity }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('cards.show', $card) }}" class="btn-primary w-full text-center">
                            Voir les détails
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection