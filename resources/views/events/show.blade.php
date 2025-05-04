@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[rgb(17,24,39)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 text-green-200 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-2xl font-bold text-white">{{ $event->title }}</h2>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Jeu</h3>
                            <p class="mt-1 text-white">{{ $event->game->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Description</h3>
                            <p class="mt-1 text-white">{{ $event->description }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Type d'événement</h3>
                            <p class="mt-1 text-white">
                                @switch($event->event_type)
                                    @case('tournament')
                                        Tournoi
                                        @break
                                    @case('casual_play')
                                        Jeu libre
                                        @break
                                    @case('trade')
                                        Échange
                                        @break
                                    @case('release')
                                        Sortie
                                        @break
                                    @case('other')
                                        Autre
                                        @break
                                @endswitch
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Lieu</h3>
                            <p class="mt-1 text-white">
                                {{ $event->venue_name }}<br>
                                {{ $event->address }}<br>
                                {{ $event->postal_code }} {{ $event->city }}<br>
                                @if($event->state)
                                    {{ $event->state }}, 
                                @endif
                                {{ $event->country }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Date et heure</h3>
                            <p class="mt-1 text-white">
                                <span class="text-gray-400">Début :</span> {{ $event->start_datetime->format('d/m/Y H:i') }}<br>
                                <span class="text-gray-400">Fin :</span> {{ $event->end_datetime->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Participants</h3>
                            <p class="mt-1 text-white">
                                Maximum : {{ $event->max_participants }}
                            </p>
                        </div>

                        @if($event->entry_fee > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-400">Frais d'entrée</h3>
                                <p class="mt-1 text-white">{{ number_format($event->entry_fee, 2) }} €</p>
                            </div>
                        @endif

                        @if($event->prizes)
                            <div>
                                <h3 class="text-sm font-medium text-gray-400">Prix à gagner</h3>
                                <p class="mt-1 text-white">{{ $event->prizes }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-medium text-gray-400">Organisateur</h3>
                            <p class="mt-1 text-white">{{ $event->user->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-700">
                    <a href="{{ route('events.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Créer un autre événement
                    </a>
                    <a href="{{ route('events.find') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-700 rounded-md shadow-sm text-sm font-medium text-white bg-[rgb(31,41,55)] hover:bg-[rgb(41,51,65)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Retour à la liste des événements
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 