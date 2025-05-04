@extends('layouts.app')

@section('title', 'Connexion - TCG HUB')
@section('meta_description', 'Connectez-vous à votre compte TCG HUB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Connexion</div>

                <div class="card-body">
                    <form method="POST" action="/login">
                        @csrf

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Adresse e-mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Mot de passe</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Connexion
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p>Vous n'avez pas de compte ? <a href="/register">Créez un compte</a></p>
                    </div>

                    <!-- Section de test pour les développeurs -->
                    <div class="mt-5 pt-4 border-top">
                        <h5>Comptes de test</h5>
                        <div class="alert alert-info">
                            <p class="mb-1"><strong>Admin:</strong> admin@tcghub.com / password</p>
                            <p class="mb-1"><strong>Organisateur:</strong> organisateur@tcghub.com / password</p>
                            <p class="mb-0"><strong>Joueur:</strong> joueur@tcghub.com / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection