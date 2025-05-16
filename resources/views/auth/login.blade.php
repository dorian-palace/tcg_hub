@extends('layouts.app')

@section('title', 'Connexion - TCGalaxy')
@section('meta_description', 'Connectez-vous à votre compte TCGalaxy')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-light-text">Bienvenue sur TCGalaxy</h1>
            <p class="mt-2 text-light-text-secondary">Connectez-vous pour accéder à votre compte</p>
        </div>

        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-light-text">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-light-text">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text bg-light-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-light-secondary rounded bg-light-primary">
                        <label for="remember" class="ml-2 block text-sm text-light-text">Se souvenir de moi</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:text-blue-400">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Se connecter
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-light-text-secondary">
                    Pas encore inscrit ?
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400">
                        Créez un compte
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection