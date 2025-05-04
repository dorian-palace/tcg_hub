@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[rgb(17,24,39)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Événements à venir</h1>
            @auth
                <a href="{{ route('events.create') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Créer un événement
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Se connecter
                </a>
            @endauth
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
                <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold text-white mb-2">{{ $event->title }}</h2>
                                <p class="text-gray-400 text-sm mb-2">{{ $event->game->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($event->event_type === 'tournament') bg-purple-900 text-purple-200
                                @elseif($event->event_type === 'casual_play') bg-blue-900 text-blue-200
                                @elseif($event->event_type === 'trade') bg-green-900 text-green-200
                                @elseif($event->event_type === 'release') bg-yellow-900 text-yellow-200
                                @else bg-gray-900 text-gray-200 @endif">
                                @switch($event->event_type)
                                    @case('tournament') Tournoi @break
                                    @case('casual_play') Jeu libre @break
                                    @case('trade') Échange @break
                                    @case('release') Sortie @break
                                    @default Autre
                                @endswitch
                            </span>
                        </div>

                        <p class="text-gray-300 mb-4">{{ Str::limit($event->description, 100) }}</p>

                        <div class="space-y-2 text-sm text-gray-400">
                            <p><span class="font-medium">Date :</span> {{ $event->start_datetime->format('d/m/Y H:i') }}</p>
                            <p><span class="font-medium">Lieu :</span> {{ $event->city }}</p>
                            <p><span class="font-medium">Organisateur :</span> {{ $event->user->name }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('events.show', $event->id) }}" 
                               class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400 text-lg">Aucun événement à venir pour le moment.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection 