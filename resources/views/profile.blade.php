@extends('layouts.app')

@section('title', 'Mon tableau de bord - TCGalaxy')
@section('meta_description', 'Gérez votre profil, vos événements, votre collection et vos transactions sur TCGalaxy')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Mon Tableau de Bord</h1>
            <p class="text-gray-400">Gérez votre profil et vos activités sur TCGalaxy</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-user-edit mr-2"></i> Modifier mon profil
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Card -->
        <div class="col-span-1">
            <div class="bg-light-primary rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="text-center mb-6">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" 
                                 class="rounded-full w-32 h-32 object-cover mx-auto border-4 border-light-secondary">
                        @else
                            <div class="rounded-full bg-light-secondary text-blue-400 w-32 h-32 flex items-center justify-center mx-auto border-4 border-light-secondary">
                                <span class="text-4xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h2 class="text-xl font-bold text-white mt-4">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-400">Membre depuis {{ Auth::user()->created_at->format('M Y') }}</p>
                        <p class="text-gray-400 mt-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ Auth::user()->city ? Auth::user()->city . ', ' : '' }}{{ Auth::user()->country }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Événements -->
        <div class="col-span-2">
            <div class="bg-light-primary rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-white">Mes Événements</h2>
                    </div>
                    
                    @if(Auth::user()->organizedEvents && Auth::user()->organizedEvents->count() > 0)
                        <div class="space-y-4">
                            @php
                                $upcomingEvents = \App\Models\Event::where('user_id', auth()->id())
                                    ->whereNotNull('user_id')
                                    ->orderBy('start_datetime', 'asc')
                                    ->take(3)
                                    ->get();
                            @endphp
                            
                            @foreach($upcomingEvents as $event)
                                <div class="bg-light-primary rounded-lg p-4 hover:bg-light-secondary transition-colors">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">{{ $event->name }}</h3>
                                            <p class="text-gray-400 text-sm mt-1">
                                                <i class="fas fa-calendar mr-2"></i> {{ $event->start_datetime->format('d/m/Y') }}
                                                <i class="fas fa-map-marker-alt ml-4 mr-2"></i> {{ $event->city }}
                                            </p>
                                        </div>
                                        <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Gérer
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-400 mb-4">Vous n'avez pas encore organisé d'événements.</p>
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Créer votre premier événement
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection