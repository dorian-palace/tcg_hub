@extends('layouts.app')

@section('title', 'Recherche d\'événements TCG | TCG HUB')
@section('meta_description', 'Trouvez des événements de jeux de cartes à collectionner près de chez vous')

@section('styles')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<style>
    .map-container {
        height: 500px;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .search-results {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-[rgb(17,24,39)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Trouver un événement</h1>
            <p class="mt-2 text-gray-400">Découvrez les événements de jeux de cartes près de chez vous</p>
        </div>

        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="p-6">
                <form action="{{ route('events.find') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="game" class="block text-sm font-medium text-gray-400">Jeu</label>
                            <select name="game" id="game" class="mt-1 block w-full px-3 py-2 bg-[rgb(17,24,39)] border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Tous les jeux</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>
                                        {{ $game->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="event_type" class="block text-sm font-medium text-gray-400">Type d'événement</label>
                            <select name="event_type" id="event_type" class="mt-1 block w-full px-3 py-2 bg-[rgb(17,24,39)] border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Tous les types</option>
                                <option value="tournament" {{ request('event_type') == 'tournament' ? 'selected' : '' }}>Tournoi</option>
                                <option value="casual_play" {{ request('event_type') == 'casual_play' ? 'selected' : '' }}>Jeu libre</option>
                                <option value="trade" {{ request('event_type') == 'trade' ? 'selected' : '' }}>Échange</option>
                                <option value="release" {{ request('event_type') == 'release' ? 'selected' : '' }}>Sortie</option>
                                <option value="other" {{ request('event_type') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-400">Ville</label>
                            <input type="text" name="city" id="city" value="{{ request('city') }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-[rgb(17,24,39)] border border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Entrez une ville">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($events->isEmpty())
            <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden p-6 text-center">
                <p class="text-gray-400">Aucun événement ne correspond à vos critères de recherche.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-white">{{ $event->title }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($event->event_type == 'tournament') bg-purple-900 text-purple-200
                                    @elseif($event->event_type == 'casual_play') bg-green-900 text-green-200
                                    @elseif($event->event_type == 'trade') bg-yellow-900 text-yellow-200
                                    @elseif($event->event_type == 'release') bg-blue-900 text-blue-200
                                    @else bg-gray-700 text-gray-200 @endif">
                                    @switch($event->event_type)
                                        @case('tournament') Tournoi @break
                                        @case('casual_play') Jeu libre @break
                                        @case('trade') Échange @break
                                        @case('release') Sortie @break
                                        @case('other') Autre @break
                                    @endswitch
                                </span>
                            </div>

                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-400">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $event->start_datetime->format('d/m/Y H:i') }}
                                </div>

                                <div class="flex items-center text-sm text-gray-400">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->city }}
                                </div>

                                <div class="flex items-center text-sm text-gray-400">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ $event->user->name }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection