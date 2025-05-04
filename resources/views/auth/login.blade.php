@extends('layouts.app')

@section('title', 'Connexion - TCG HUB')
@section('meta_description', 'Connectez-vous à votre compte TCG HUB')

@section('content')
<div class="min-h-screen bg-[rgb(17,24,39)] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Bienvenue sur TCG Hub</h1>
            <p class="mt-2 text-gray-400">Connectez-vous pour accéder à votre compte</p>
        </div>

        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Adresse email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm placeholder-gray-500 text-white bg-[rgb(31,41,55)] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-700 rounded-md shadow-sm placeholder-gray-500 text-white bg-[rgb(31,41,55)] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 rounded bg-[rgb(31,41,55)]">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">Se souvenir de moi</label>
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
                <p class="text-sm text-gray-400">
                    Pas encore inscrit ?
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400">
                        Créez un compte
                    </a>
                </p>
            </div>

            @if(config('app.env') === 'local')
                <div class="mt-6 p-4 bg-[rgb(55,65,81)] rounded-md">
                    <h3 class="text-sm font-medium text-white mb-2">Comptes de test</h3>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-400">Admin: admin@example.com / password</p>
                        <p class="text-sm text-gray-400">User: user@example.com / password</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection