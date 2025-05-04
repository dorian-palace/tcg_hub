@extends('layouts.app')

@section('title', 'Mes événements - TCG HUB')
@section('meta_description', 'Gérez vos événements TCG sur TCG HUB')

@section('content')
<div class="min-h-screen bg-[rgb(17,24,39)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Mes événements</h1>
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Créer un événement
                </a>
            </div>

            <div class="border-b border-[rgb(55,65,81)] mb-6">
                <nav class="-mb-px flex space-x-8">
                    <a href="#" class="border-blue-500 text-blue-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Mes participations
                    </a>
                    <a href="#" class="border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Mes organisations
                    </a>
                </nav>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(count(Auth::user()->participatingEvents) > 0)
                    @foreach(Auth::user()->participatingEvents as $event)
                        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden border border-[rgb(55,65,81)]">
                            <div class="p-4 border-b border-[rgb(55,65,81)]">
                                <div class="flex justify-between items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">
                                        {{ ucfirst($event->event_type) }}
                                    </span>
                                    <span class="text-gray-400 text-sm">
                                        {{ date('d/m/Y H:i', strtotime($event->start_datetime)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-medium text-white mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $event->venue_name }} - {{ $event->city }}</p>
                                <p class="text-gray-300">{{ Str::limit($event->description, 100) }}</p>
                            </div>
                            <div class="px-4 py-3 bg-[rgb(31,41,55)] border-t border-[rgb(55,65,81)] flex justify-between">
                                <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Voir détails
                                </a>
                                <form action="{{ route('events.unregister', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        Se désinscrire
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2">
                        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg p-6 border border-[rgb(55,65,81)]">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-white">Aucun événement</h3>
                                <p class="mt-1 text-gray-400">Vous ne participez à aucun événement pour le moment.</p>
                                <div class="mt-6">
                                    <a href="{{ route('events.find') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        Rechercher des événements
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection