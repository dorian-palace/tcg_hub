@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-black mb-6">Créer un nouvel événement</h1>

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

            <form method="POST" action="{{ route('events.store') }}" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-black">Titre de l'événement</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="game_id" class="block text-sm font-medium text-black">Jeu</label>
                        <select id="game_id" name="game_id" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                                    {{ $game->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('game_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-black">Description</label>
                        <textarea id="description" name="description" rows="4" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="event_type" class="block text-sm font-medium text-black">Type d'événement</label>
                        <select id="event_type" name="event_type" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <option value="tournament" {{ old('event_type') == 'tournament' ? 'selected' : '' }}>Tournoi</option>
                            <option value="casual_play" {{ old('event_type') == 'casual_play' ? 'selected' : '' }}>Partie amicale</option>
                            <option value="trade" {{ old('event_type') == 'trade' ? 'selected' : '' }}>Échange</option>
                            <option value="release" {{ old('event_type') == 'release' ? 'selected' : '' }}>Sortie</option>
                            <option value="other" {{ old('event_type') == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('event_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="venue_name" class="block text-sm font-medium text-black">Nom du lieu</label>
                        <input type="text" id="venue_name" name="venue_name" value="{{ old('venue_name') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('venue_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-black">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-black">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-black">Région/Département</label>
                        <input type="text" id="state" name="state" value="{{ old('state') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('state')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-black">Code postal</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-black">Pays</label>
                        <select id="country" name="country" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Belgique" {{ old('country') == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                            <option value="Suisse" {{ old('country') == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Luxembourg" {{ old('country') == 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_datetime" class="block text-sm font-medium text-black">Date et heure de début</label>
                        <input type="datetime-local" id="start_datetime" name="start_datetime" value="{{ old('start_datetime') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('start_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_datetime" class="block text-sm font-medium text-black">Date et heure de fin</label>
                        <input type="datetime-local" id="end_datetime" name="end_datetime" value="{{ old('end_datetime') }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('end_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-black">Nombre maximum de participants</label>
                        <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants') }}" min="2" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="entry_fee" class="block text-sm font-medium text-black">Frais d'inscription (€)</label>
                        <input type="number" id="entry_fee" name="entry_fee" value="{{ old('entry_fee') }}" min="0" step="0.01"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('entry_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prizes" class="block text-sm font-medium text-black">Prix</label>
                        <textarea id="prizes" name="prizes" rows="3"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">{{ old('prizes') }}</textarea>
                        @error('prizes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Créer l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection