@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Modifier l'événement</h1>

            <form method="POST" action="{{ route('events.update', $event) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-300">Titre de l'événement</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="255" pattern="[A-Za-zÀ-ÿ0-9\s\-_]+" title="Veuillez entrer un titre valide (lettres, chiffres, espaces, tirets et underscores uniquement)">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="game_id" class="block text-sm font-medium text-gray-300">Jeu</label>
                        <select id="game_id" name="game_id" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ old('game_id', $event->game_id) == $game->id ? 'selected' : '' }}>
                                    {{ $game->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('game_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                        <textarea id="description" name="description" rows="4" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="1000">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="event_type" class="block text-sm font-medium text-gray-300">Type d'événement</label>
                        <select id="event_type" name="event_type" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <option value="tournament" {{ old('event_type', $event->event_type) == 'tournament' ? 'selected' : '' }}>Tournoi</option>
                            <option value="casual_play" {{ old('event_type', $event->event_type) == 'casual_play' ? 'selected' : '' }}>Partie amicale</option>
                            <option value="trade" {{ old('event_type', $event->event_type) == 'trade' ? 'selected' : '' }}>Échange</option>
                            <option value="release" {{ old('event_type', $event->event_type) == 'release' ? 'selected' : '' }}>Sortie</option>
                            <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('event_type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="venue_name" class="block text-sm font-medium text-gray-300">Nom du lieu</label>
                        <input type="text" id="venue_name" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="255" pattern="[A-Za-zÀ-ÿ0-9\s\-_]+" title="Veuillez entrer un nom de lieu valide">
                        @error('venue_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-300">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $event->address) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="255">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-300">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $event->city) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="100" pattern="[A-Za-zÀ-ÿ\s\-]+" title="Veuillez entrer un nom de ville valide">
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-300">Code postal</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $event->postal_code) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            pattern="[0-9]{5}" title="Veuillez entrer un code postal valide (5 chiffres)">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_datetime" class="block text-sm font-medium text-gray-300">Date et heure de début</label>
                        <input type="datetime-local" id="start_datetime" name="start_datetime" value="{{ old('start_datetime', $event->start_datetime->format('Y-m-d\TH:i')) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            min="{{ date('Y-m-d\TH:i') }}">
                        @error('start_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_datetime" class="block text-sm font-medium text-gray-300">Date et heure de fin</label>
                        <input type="datetime-local" id="end_datetime" name="end_datetime" value="{{ old('end_datetime', $event->end_datetime->format('Y-m-d\TH:i')) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            min="{{ date('Y-m-d\TH:i') }}">
                        @error('end_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-300">Nombre maximum de participants</label>
                        <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="2" max="1000" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="entry_fee" class="block text-sm font-medium text-gray-300">Frais d'inscription (€)</label>
                        <input type="number" id="entry_fee" name="entry_fee" value="{{ old('entry_fee', $event->entry_fee) }}" min="0" max="1000" step="0.01"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('entry_fee')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prizes" class="block text-sm font-medium text-gray-300">Prix</label>
                        <textarea id="prizes" name="prizes" rows="3"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                            maxlength="500">{{ old('prizes', $event->prizes) }}</textarea>
                        @error('prizes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_cancelled" name="is_cancelled" value="1" {{ old('is_cancelled', $event->is_cancelled) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 rounded bg-[rgb(31,41,55)]">
                        <label for="is_cancelled" class="ml-2 block text-sm text-gray-300">Événement annulé</label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Mettre à jour l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection