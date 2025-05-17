@extends('layouts.app')

@section('title', 'Inscription - TCGalaxy')
@section('meta_description', 'Créez un compte sur TCGalaxy pour participer à des événements de jeux de cartes à collectionner')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light-text">Créer un compte</h1>
            <p class="mt-2 text-light-text-secondary">Rejoignez la communauté TCGalaxy</p>
        </div>

        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-light-text">Nom</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                        maxlength="255" pattern="[A-Za-zÀ-ÿ\s-]+" title="Veuillez entrer un nom valide (lettres, espaces et tirets uniquement)">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-light-text">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                        maxlength="255" autocomplete="email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-light-text">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                        minlength="8" autocomplete="new-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-light-text">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm"
                        minlength="8" autocomplete="new-password">
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        S'inscrire
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-light-text-secondary">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection