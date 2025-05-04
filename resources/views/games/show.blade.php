@extends('layouts.app')

@section('title', $game->name)

@section('content')
<div class="container mx-auto px-4">
    <div class="card bg-dark-secondary mb-8">
        <div class="p-6">
            <div class="flex items-center justify-center h-64 mb-6 bg-dark-primary rounded-lg">
                @if(str_contains(strtolower($game->name), 'pokemon') || str_contains(strtolower($game->name), 'pokémon'))
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/1200px-International_Pok%C3%A9mon_logo.svg.png" 
                         alt="Pokémon TCG" 
                         class="h-48 object-contain">
                @elseif(str_contains(strtolower($game->name), 'magic'))
                    <img src="https://latartineludique.fr/wp-content/uploads/2024/03/Magic-The-Gathering-Logo.png" 
                         alt="Magic: The Gathering" 
                         class="h-48 object-contain">
                @elseif(str_contains(strtolower($game->name), 'yu-gi-oh'))
                    <img src="https://upload.wikimedia.org/wikipedia/fr/a/a5/Yu-Gi-Oh_Logo.JPG" 
                         alt="Yu-Gi-Oh!" 
                         class="h-48 object-contain">
                @elseif(str_contains(strtolower($game->name), 'one piece'))
                    <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/1/1a/Logo_One_piece.svg/640px-Logo_One_piece.svg.png" 
                         alt="One Piece Card Game" 
                         class="h-48 object-contain">
                @else
                    <i class="fas fa-gamepad text-8xl text-blue-400"></i>
                @endif
            </div>
            <h1 class="text-3xl font-bold mb-4">{{ $game->name }}</h1>
            <p class="text-dark-text-secondary mb-4">{{ $game->description }}</p>
            <div class="flex items-center space-x-4 text-sm text-dark-text-secondary">
                <span><i class="fas fa-building mr-2"></i> {{ $game->publisher }}</span>
                <span><i class="fas fa-calendar mr-2"></i> {{ $game->release_date }}</span>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6">Cartes disponibles</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($game->cards as $card)
            <div class="card bg-dark-secondary hover:bg-dark-accent transition-all duration-300">
                <div class="p-4">
                    <div class="flex items-center justify-center h-40 mb-4 bg-dark-primary rounded-lg">
                        <i class="fas fa-cards-blank text-6xl text-blue-400"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">{{ $card->name }}</h3>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-dark-text-secondary">{{ $card->set_name }}</span>
                        <span class="text-blue-400">{{ $card->rarity }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection