@extends('layouts.app')

@section('title', 'Trouver un événement - TCG HUB')
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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-light-text">Trouver un événement</h1>
        <p class="mt-2 text-light-text-secondary">Découvrez les événements de jeux de cartes près de chez vous</p>
    </div>

    <div class="bg-light-primary rounded-lg shadow-lg p-6 mb-8">
        <form action="{{ route('events.find') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="game" class="block text-sm font-medium text-light-text">Jeu</label>
                    <select name="game" id="game" class="mt-1 block w-full rounded-md bg-light-primary border-light-secondary text-light-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous les jeux</option>
                        @foreach($games as $game)
                            <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>
                                {{ $game->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="event_type" class="block text-sm font-medium text-light-text">Type d'événement</label>
                    <select name="event_type" id="event_type" class="mt-1 block w-full rounded-md bg-light-primary border-light-secondary text-light-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tous les types</option>
                        <option value="tournament" {{ request('event_type') === 'tournament' ? 'selected' : '' }}>Tournoi</option>
                        <option value="casual" {{ request('event_type') === 'casual' ? 'selected' : '' }}>Partie libre</option>
                        <option value="draft" {{ request('event_type') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sealed" {{ request('event_type') === 'sealed' ? 'selected' : '' }}>Sealed</option>
                        <option value="prerelease" {{ request('event_type') === 'prerelease' ? 'selected' : '' }}>Pré-lancement</option>
                        <option value="other" {{ request('event_type') === 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-light-text">Ville</label>
                    <input type="text" name="city" id="city" value="{{ request('city') }}" placeholder="Entrez votre ville"
                        class="mt-1 block w-full rounded-md bg-light-primary border-light-secondary text-light-text shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Rechercher
                </button>
            </div>
        </form>
    </div>

    @if($events->isEmpty())
        <div class="text-center py-12">
            <p class="text-light-text-secondary">Aucun événement ne correspond à vos critères de recherche.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-light-primary rounded-lg shadow-lg overflow-hidden">
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

                        <h3 class="text-lg font-semibold text-light-text">{{ $event->title }}</h3>
                        <p class="text-light-text-secondary text-sm mb-2">{{ $event->game->name }}</p>

                        <div class="flex items-center text-sm text-light-text-secondary mb-4">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $event->city }}
                        </div>

                        <div class="space-y-2 text-sm text-light-text-secondary">
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

                        <div class="mt-6">
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
@endsection