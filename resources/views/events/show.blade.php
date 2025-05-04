@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ $event->title }}</h2>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jeu :</div>
                        <div class="col-md-8">{{ $event->game->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Description :</div>
                        <div class="col-md-8">{{ $event->description }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Type d'événement :</div>
                        <div class="col-md-8">
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
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Lieu :</div>
                        <div class="col-md-8">
                            {{ $event->venue_name }}<br>
                            {{ $event->address }}<br>
                            {{ $event->postal_code }} {{ $event->city }}<br>
                            {{ $event->state }}, {{ $event->country }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Date et heure :</div>
                        <div class="col-md-8">
                            Début : {{ $event->start_datetime->format('d/m/Y H:i') }}<br>
                            Fin : {{ $event->end_datetime->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Participants :</div>
                        <div class="col-md-8">
                            Maximum : {{ $event->max_participants }}
                        </div>
                    </div>

                    @if($event->entry_fee > 0)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Frais d'entrée :</div>
                            <div class="col-md-8">{{ number_format($event->entry_fee, 2) }} €</div>
                        </div>
                    @endif

                    @if($event->prizes)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Prix à gagner :</div>
                            <div class="col-md-8">{{ $event->prizes }}</div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Organisateur :</div>
                        <div class="col-md-8">{{ $event->user->name }}</div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <a href="{{ route('events.create') }}" class="btn btn-primary">
                                Créer un autre événement
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('events.find') }}" class="btn btn-secondary">
                                Retour à la liste des événements
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 