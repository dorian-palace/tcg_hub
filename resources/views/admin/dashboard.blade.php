@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Tableau de bord administrateur</h1>

        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Utilisateurs -->
            <div class="bg-light-secondary rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Utilisateurs</h2>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['users']['total'] }}</p>
                        <p class="text-sm text-gray-600">+{{ $stats['users']['new_this_month'] }} ce mois</p>
                    </div>
                </div>
            </div>

            <!-- Événements -->
            <div class="bg-light-secondary rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Événements</h2>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['events']['total'] }}</p>
                        <p class="text-sm text-gray-600">{{ $stats['events']['upcoming'] }} à venir</p>
                    </div>
                </div>
            </div>

            <!-- Jeux -->
            <div class="bg-light-secondary rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                        <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Jeux</h2>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['games']['total'] }}</p>
                        <p class="text-sm text-gray-600">{{ $stats['games']['active'] }} actifs</p>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-light-secondary rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20">
                        <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-gray-900">Transactions</h2>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['transactions']['total'] }}</p>
                        <p class="text-sm text-gray-600">{{ $stats['transactions']['this_month'] }} ce mois</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Jeux populaires -->
            <div class="bg-light-secondary rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Jeux les plus populaires</h2>
                <div class="space-y-4">
                    @foreach($popularGames as $game)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($game->logo_url)
                                    <img src="{{ $game->logo_url }}" alt="{{ $game->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-lg font-bold text-white">{{ substr($game->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">{{ $game->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $game->events_count }} événements</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top organisateurs -->
            <div class="bg-light-secondary rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Top organisateurs</h2>
                <div class="space-y-4">
                    @foreach($topOrganizers as $organizer)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($organizer->avatar)
                                    <img src="{{ $organizer->avatar }}" alt="{{ $organizer->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-lg font-bold text-white">{{ substr($organizer->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">{{ $organizer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $organizer->organized_events_count }} événements</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dernières transactions -->
            <div class="bg-light-secondary rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Dernières transactions</h2>
                <div class="space-y-4">
                    @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-green-500 bg-opacity-20">
                                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">{{ $transaction->seller->name }} → {{ $transaction->buyer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $transaction->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Événements à venir -->
            <div class="bg-light-secondary rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Événements à venir</h2>
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-full bg-blue-500 bg-opacity-20">
                                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">{{ $event->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $event->start_datetime->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-600">{{ $event->game->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Carte des utilisateurs par pays -->
        <div class="mt-8 bg-light-secondary rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Utilisateurs par pays</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($usersByCountry as $country)
                    <div class="bg-light-primary rounded-lg p-4">
                        <p class="text-gray-900 font-medium">{{ $country->country }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $country->total }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 