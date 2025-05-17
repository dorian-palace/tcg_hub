@extends('layouts.app')

@section('title', 'Événements TCG - Tournois et rencontres de jeux de cartes à collectionner')
@section('meta_description', 'Découvrez tous les événements TCG en France : tournois Pokémon, Magic: The Gathering, Yu-Gi-Oh!, One Piece et plus encore. Organisez ou participez à des événements de jeux de cartes à collectionner près de chez vous.')
@section('meta_keywords', 'événement tcg, tournoi tcg, événements jeux de cartes, tournois pokemon, tournois magic, tournois yugioh, événements one piece, rencontres tcg')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête optimisé pour le SEO -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
            Événements TCG en France
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Découvrez et participez aux meilleurs événements de jeux de cartes à collectionner en France. 
            Tournois officiels, rencontres amicales, pré-releases et plus encore.
        </p>
    </div>

    <!-- Contenu riche pour le SEO -->
    <div class="prose max-w-none mb-12">
        <h2 class="text-2xl font-bold mb-4">Les événements TCG en France</h2>
        <p>
            TCGalaxy est la plateforme de référence pour les événements de jeux de cartes à collectionner en France. 
            Que vous soyez passionné de Pokémon TCG, Magic: The Gathering, Yu-Gi-Oh! ou One Piece Card Game, 
            vous trouverez ici tous les événements près de chez vous.
        </p>

        <h3 class="text-xl font-bold mt-8 mb-4">Types d'événements TCG disponibles</h3>
        <ul class="list-disc pl-6 mb-6">
            <li>Tournois officiels et compétitifs</li>
            <li>Rencontres amicales et casual play</li>
            <li>Pré-releases et lancements de nouvelles extensions</li>
            <li>Événements d'échange et de collection</li>
            <li>Formations et initiations aux jeux de cartes</li>
        </ul>

        <h3 class="text-xl font-bold mt-8 mb-4">Jeux de cartes populaires</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="font-bold mb-2">Pokémon TCG</h4>
                <p>Tournois officiels, pré-releases et championnats régionaux</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="font-bold mb-2">Magic: The Gathering</h4>
                <p>FNM, Grand Prix, PTQ et événements spéciaux</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="font-bold mb-2">Yu-Gi-Oh!</h4>
                <p>Tournois locaux, régionaux et championnats nationaux</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="font-bold mb-2">One Piece Card Game</h4>
                <p>Événements de lancement et tournois officiels</p>
            </div>
        </div>
    </div>

    <!-- Interface de recherche d'événements -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Événements à venir</h2>
        <div class="flex space-x-4">
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Créer un événement
            </a>
            <a href="{{ route('events.find') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Rechercher
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-900 text-green-200 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-900 text-red-200 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <!-- Liste des événements -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($event->event_type === 'tournament')
                                bg-blue-100 text-blue-800
                            @elseif($event->event_type === 'casual')
                                bg-green-100 text-green-800
                            @elseif($event->event_type === 'draft')
                                bg-purple-100 text-purple-800
                            @elseif($event->event_type === 'sealed')
                                bg-yellow-100 text-yellow-800
                            @elseif($event->event_type === 'prerelease')
                                bg-pink-100 text-pink-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif
                        ">
                            @switch($event->event_type)
                                @case('tournament')
                                    Tournoi
                                    @break
                                @case('casual')
                                    Partie libre
                                    @break
                                @case('draft')
                                    Draft
                                    @break
                                @case('sealed')
                                    Sealed
                                    @break
                                @case('prerelease')
                                    Pré-lancement
                                    @break
                                @case('other')
                                    Autre
                                    @break
                            @endswitch
                        </span>
                        @if($event->is_cancelled)
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                Annulé
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $event->city }}
                    </div>
                    <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 100) }}</p>
                    <div class="space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $event->start_datetime->format('d/m/Y H:i') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ $event->participants_count }} / {{ $event->max_participants ?? '∞' }} participants
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('events.show', $event) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Voir les détails
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 text-lg">Aucun événement à venir pour le moment.</p>
            </div>
        @endforelse
    </div>

    <!-- FAQ pour le SEO -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Questions fréquentes sur les événements TCG</h2>
        <div class="space-y-6">
            <div>
                <h3 class="text-xl font-bold mb-2">Comment participer à un événement TCG ?</h3>
                <p class="text-gray-600">Pour participer à un événement, il suffit de créer un compte sur TCGalaxy, de trouver l'événement qui vous intéresse et de cliquer sur "S'inscrire". Certains événements peuvent nécessiter une inscription préalable ou des frais de participation.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-2">Comment organiser un événement TCG ?</h3>
                <p class="text-gray-600">Vous pouvez organiser votre propre événement en cliquant sur "Créer un événement". Vous pourrez définir le type d'événement, la date, le lieu, le nombre de participants et les règles spécifiques.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-2">Quels types d'événements TCG sont disponibles ?</h3>
                <p class="text-gray-600">Nous proposons une large gamme d'événements : tournois officiels, rencontres amicales, pré-releases, événements d'échange et formations. Chaque jeu (Pokémon, Magic, Yu-Gi-Oh!, One Piece) a ses propres types d'événements spécifiques.</p>
            </div>
        </div>
    </div>
</div>
@endsection 