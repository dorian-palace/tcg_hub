@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier l\'événement') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('events.update', $event->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Titre') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $event->title) }}" required autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="game_id" class="col-md-4 col-form-label text-md-right">{{ __('Jeu') }}</label>

                            <div class="col-md-6">
                                <select id="game_id" class="form-control @error('game_id') is-invalid @enderror" name="game_id" required>
                                    <option value="">{{ __('Sélectionner un jeu') }}</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" {{ (old('game_id', $event->game_id) == $game->id) ? 'selected' : '' }}>{{ $game->name }}</option>
                                    @endforeach
                                </select>

                                @error('game_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $event->description) }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="event_type" class="col-md-4 col-form-label text-md-right">{{ __('Type d\'événement') }}</label>

                            <div class="col-md-6">
                                <select id="event_type" class="form-control @error('event_type') is-invalid @enderror" name="event_type" required>
                                    <option value="">{{ __('Sélectionner un type') }}</option>
                                    <option value="tournament" {{ old('event_type', $event->event_type) == 'tournament' ? 'selected' : '' }}>{{ __('Tournoi') }}</option>
                                    <option value="casual_play" {{ old('event_type', $event->event_type) == 'casual_play' ? 'selected' : '' }}>{{ __('Jeu libre') }}</option>
                                    <option value="trade" {{ old('event_type', $event->event_type) == 'trade' ? 'selected' : '' }}>{{ __('Échange') }}</option>
                                    <option value="release" {{ old('event_type', $event->event_type) == 'release' ? 'selected' : '' }}>{{ __('Sortie') }}</option>
                                    <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>{{ __('Autre') }}</option>
                                </select>

                                @error('event_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="venue_name" class="col-md-4 col-form-label text-md-right">{{ __('Lieu') }}</label>

                            <div class="col-md-6">
                                <input id="venue_name" type="text" class="form-control @error('venue_name') is-invalid @enderror" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" required>

                                @error('venue_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $event->address) }}" required>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $event->city) }}" required>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="postal_code" class="col-md-4 col-form-label text-md-right">{{ __('Code postal') }}</label>

                            <div class="col-md-6">
                                <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code', $event->postal_code) }}" required>

                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="start_datetime" class="col-md-4 col-form-label text-md-right">{{ __('Date et heure de début') }}</label>

                            <div class="col-md-6">
                                <input id="start_datetime" type="datetime-local" class="form-control @error('start_datetime') is-invalid @enderror" name="start_datetime" value="{{ old('start_datetime', $event->start_datetime ? $event->start_datetime->format('Y-m-d\TH:i') : '') }}" required>

                                @error('start_datetime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="end_datetime" class="col-md-4 col-form-label text-md-right">{{ __('Date et heure de fin') }}</label>

                            <div class="col-md-6">
                                <input id="end_datetime" type="datetime-local" class="form-control @error('end_datetime') is-invalid @enderror" name="end_datetime" value="{{ old('end_datetime', $event->end_datetime ? $event->end_datetime->format('Y-m-d\TH:i') : '') }}">

                                @error('end_datetime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="max_participants" class="col-md-4 col-form-label text-md-right">{{ __('Nombre max de participants') }}</label>

                            <div class="col-md-6">
                                <input id="max_participants" type="number" min="0" class="form-control @error('max_participants') is-invalid @enderror" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}">

                                @error('max_participants')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="entry_fee" class="col-md-4 col-form-label text-md-right">{{ __('Frais d\'entrée (€)') }}</label>

                            <div class="col-md-6">
                                <input id="entry_fee" type="number" min="0" step="0.01" class="form-control @error('entry_fee') is-invalid @enderror" name="entry_fee" value="{{ old('entry_fee', $event->entry_fee) }}">

                                @error('entry_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="prizes" class="col-md-4 col-form-label text-md-right">{{ __('Prix à gagner') }}</label>

                            <div class="col-md-6">
                                <textarea id="prizes" class="form-control @error('prizes') is-invalid @enderror" name="prizes" rows="2">{{ old('prizes', $event->prizes) }}</textarea>

                                @error('prizes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_cancelled" id="is_cancelled" {{ old('is_cancelled', $event->is_cancelled) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="is_cancelled">
                                        {{ __('Annuler l\'événement') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mettre à jour l\'événement') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection