@extends('layouts.app')

@section('title', 'Événements - TCG HUB')
@section('meta_description', 'Découvrez les événements de jeux de cartes à collectionner près de chez vous')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-light-text">Événements à venir</h1>
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
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

                    <h2 class="text-xl font-semibold text-light-text mb-2">{{ $event->title }}</h2>
                    <p class="text-light-text-secondary text-sm mb-2">{{ $event->game->name }}</p>

                    <div class="flex items-center text-sm text-light-text-secondary mb-4">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $event->city }}
                    </div>

                    <p class="text-light-text mb-4">{{ Str::limit($event->description, 100) }}</p>

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
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Voir les détails
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-light-text-secondary text-lg">Aucun événement à venir pour le moment.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $events->links() }}
    </div>
</div>
@endsection 