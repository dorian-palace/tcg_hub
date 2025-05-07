@extends('layouts.app')

@section('title', 'Jeux de cartes à collectionner')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Jeux de cartes à collectionner</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($games as $game)
            <div class="card bg-light-accent hover:bg-light-secondary transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-center h-48 mb-4 bg-light-primary rounded-lg">
                        @if(str_contains(strtolower($game->name), 'pokemon') || str_contains(strtolower($game->name), 'pokémon'))
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/1200px-International_Pok%C3%A9mon_logo.svg.png" 
                                 alt="Pokémon TCG" 
                                 class="h-32 object-contain">
                        @elseif(str_contains(strtolower($game->name), 'magic'))
                            <img src="https://latartineludique.fr/wp-content/uploads/2024/03/Magic-The-Gathering-Logo.png" 
                                 alt="Magic: The Gathering" 
                                 class="h-32 object-contain">
                        @elseif(str_contains(strtolower($game->name), 'yu-gi-oh'))
                            <img src="https://upload.wikimedia.org/wikipedia/fr/a/a5/Yu-Gi-Oh_Logo.JPG" 
                                 alt="Yu-Gi-Oh!" 
                                 class="h-32 object-contain">
                        @elseif(str_contains(strtolower($game->name), 'one piece'))
                            <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/1/1a/Logo_One_piece.svg/640px-Logo_One_piece.svg.png" 
                                 alt="One Piece Card Game" 
                                 class="h-32 object-contain">
                        @else
                            <i class="fas fa-gamepad text-6xl text-blue-400"></i>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold mb-2">{{ $game->name }}</h2>
                    <p class="text-dark-text-secondary mb-4">{{ $game->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-blue-400">{{ $game->cards_count }} cartes</span>
                        <a href="{{ route('events.find', ['game' => $game->id]) }}" class="btn-primary">
                            Voir les événements
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection