@extends('layouts.app')

@section('title', 'Mes événements - TCG HUB')
@section('meta_description', 'Gérez vos événements TCG sur TCG HUB')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mes événements</h1>
        <a href="#" class="btn btn-primary">Créer un événement</a>
    </div>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="#">Mes participations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Mes organisations</a>
        </li>
    </ul>

    <div class="row">
        @if(count(Auth::user()->participatingEvents) > 0)
            @foreach(Auth::user()->participatingEvents as $event)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between">
                            <span class="badge bg-primary">{{ ucfirst($event->event_type) }}</span>
                            <span class="text-muted">{{ date('d/m/Y H:i', strtotime($event->start_datetime)) }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $event->venue_name }} - {{ $event->city }}</h6>
                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir détails</a>
                            <form action="#" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Se désinscrire</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <p class="mb-0">Vous ne participez à aucun événement pour le moment.</p>
                </div>
                <p class="mt-3">Vous pouvez <a href="/events/find">rechercher des événements</a> pour vous y inscrire.</p>
            </div>
        @endif
    </div>
</div>
@endsection