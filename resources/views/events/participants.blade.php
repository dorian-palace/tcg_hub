@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Participants') }} - {{ $event->title }}</div>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">{{ __('Modifier l\'événement') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <div><strong>{{ __('Jeu:') }}</strong> {{ $event->game->name }}</div>
                        <div><strong>{{ __('Date:') }}</strong> {{ $event->start_datetime->format('d/m/Y H:i') }}</div>
                        <div><strong>{{ __('Lieu:') }}</strong> {{ $event->venue_name }}, {{ $event->city }}</div>
                        <div><strong>{{ __('Participants:') }}</strong> {{ $event->participations->count() }} / {{ $event->max_participants ?: __('Illimité') }}</div>
                    </div>

                    @if($event->participations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Participant') }}</th>
                                        <th>{{ __('Date d\'inscription') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Paiement') }}</th>
                                        <th>{{ __('Classement') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participations as $participation)
                                        <tr>
                                            <td>{{ $participation->user->name }}</td>
                                            <td>{{ $participation->registration_date->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge {{ $participation->status == 'registered' ? 'bg-primary' : ($participation->status == 'confirmed' ? 'bg-success' : ($participation->status == 'cancelled' ? 'bg-danger' : 'bg-info')) }}">
                                                    {{ $participation->status == 'registered' ? __('Inscrit') : ($participation->status == 'confirmed' ? __('Confirmé') : ($participation->status == 'cancelled' ? __('Annulé') : __('Présent'))) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $participation->payment_received ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $participation->payment_received ? __('Reçu') : __('En attente') }}
                                                </span>
                                            </td>
                                            <td>{{ $participation->final_ranking ?: '-' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{ __('Actions') }}
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('participations.update', $participation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item">{{ __('Confirmer') }}</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('participations.update', $participation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="attended">
                                                                <button type="submit" class="dropdown-item">{{ __('Marquer présent') }}</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('participations.update', $participation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="payment_received" value="1">
                                                                <button type="submit" class="dropdown-item">{{ __('Marquer payé') }}</button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#rankingModal{{ $participation->id }}">
                                                                {{ __('Définir classement') }}
                                                            </button>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('participations.update', $participation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item text-danger">{{ __('Annuler participation') }}</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="modal fade" id="rankingModal{{ $participation->id }}" tabindex="-1" aria-labelledby="rankingModalLabel{{ $participation->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rankingModalLabel{{ $participation->id }}">{{ __('Définir le classement de') }} {{ $participation->user->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('participations.update', $participation->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="final_ranking" class="form-label">{{ __('Position finale') }}</label>
                                                                        <input type="number" class="form-control" id="final_ranking" name="final_ranking" min="1" value="{{ $participation->final_ranking ?: '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Annuler') }}</button>
                                                                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('Aucun participant inscrit à cet événement pour le moment.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection