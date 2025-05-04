@extends('layouts.app')

@section('title', 'Mon tableau de bord - TCG HUB')
@section('meta_description', 'Gérez votre profil, vos événements, votre collection et vos transactions sur TCG HUB')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Mon Tableau de Bord</h1>
            <p class="text-gray-400">Gérez votre profil et vos activités sur TCG HUB</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn-primary">
            <i class="fas fa-user-edit mr-2"></i> Modifier mon profil
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profil Card -->
        <div class="col-span-1">
            <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="text-center mb-6">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" 
                                 class="rounded-full w-32 h-32 object-cover mx-auto border-4 border-[rgb(55,65,81)]">
                        @else
                            <div class="rounded-full bg-[rgb(55,65,81)] text-blue-400 w-32 h-32 flex items-center justify-center mx-auto border-4 border-[rgb(55,65,81)]">
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

                    <div class="space-y-3">
                        <a href="{{ route('my-collection') }}" class="btn-primary w-full text-center">
                            <i class="fas fa-folder mr-2"></i> Ma Collection
                        </a>
                        <a href="{{ route('transactions.index') }}" class="btn-secondary w-full text-center">
                            <i class="fas fa-exchange-alt mr-2"></i> Mes Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Événements et Transactions -->
        <div class="col-span-2 space-y-6">
            <!-- Événements -->
            <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-white">Mes Événements</h2>
                        <a href="{{ route('my-events') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                            Voir tous
                        </a>
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
                                <div class="bg-[rgb(17,24,39)] rounded-lg p-4 hover:bg-[rgb(55,65,81)] transition-colors">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-semibold text-white">{{ $event->name }}</h3>
                                            <p class="text-gray-400 text-sm mt-1">
                                                <i class="fas fa-calendar mr-2"></i> {{ $event->start_datetime->format('d/m/Y') }}
                                                <i class="fas fa-map-marker-alt ml-4 mr-2"></i> {{ $event->city }}
                                            </p>
                                        </div>
                                        <a href="{{ route('events.edit', $event) }}" class="btn-primary">
                                            Gérer
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-400 mb-4">Vous n'avez pas encore organisé d'événements.</p>
                            <a href="{{ route('events.create') }}" class="btn-primary">
                                Créer votre premier événement
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-white">Transactions Récentes</h2>
                        <a href="{{ route('transactions.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                            Voir toutes
                        </a>
                    </div>
                    
                    @if(Auth::user()->transactions && Auth::user()->transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-gray-400 border-b border-[rgb(55,65,81)]">
                                        <th class="pb-3">Date</th>
                                        <th class="pb-3">Type</th>
                                        <th class="pb-3">Carte</th>
                                        <th class="pb-3">Montant</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->transactions()->orderBy('created_at', 'desc')->take(5)->get() as $transaction)
                                        <tr class="border-b border-[rgb(55,65,81)] hover:bg-[rgb(17,24,39)] transition-colors">
                                            <td class="py-3 text-gray-300">{{ $transaction->created_at->format('d/m/Y') }}</td>
                                            <td class="py-3 text-gray-300">{{ $transaction->type }}</td>
                                            <td class="py-3 text-gray-300">{{ $transaction->card->name }}</td>
                                            <td class="py-3 text-gray-300">{{ $transaction->amount }}€</td>
                                            <td class="py-3">
                                                <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                                    Détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-400 mb-4">Vous n'avez pas encore de transactions.</p>
                            <a href="{{ route('transactions.create') }}" class="btn-primary">
                                Créer une transaction
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection