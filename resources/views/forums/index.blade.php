@extends('layouts.app')

@php
use App\Models\Forum;
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Forums</h1>
        @auth
            <a href="{{ route('forums.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Créer un sujet
            </a>
        @endauth
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4 mb-8">
        <form action="{{ route('forums.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="game_id" class="block text-sm font-medium text-gray-700 mb-1">Jeu</label>
                <select name="game_id" id="game_id" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tous les jeux</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ request('game_id') == $game->id ? 'selected' : '' }}>
                            {{ $game->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="category" id="category" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Toutes les catégories</option>
                    @foreach(Forum::CATEGORIES as $value => $label)
                        <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    @forelse($forums as $gameName => $gameForums)
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $gameName }}</h2>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @foreach($gameForums as $forum)
                    <div class="border-b last:border-b-0">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                <a href="{{ route('forums.show', $forum) }}" class="hover:text-blue-500 transition-colors duration-200">
                                                    {{ $forum->name }}
                                                </a>
                                            </h3>
                                            @if($forum->category)
                                                <span class="inline-block bg-gray-100 text-gray-800 text-sm px-2 py-1 rounded mt-1">
                                                    {{ Forum::CATEGORIES[$forum->category] ?? $forum->category }}
                                                </span>
                                            @endif
                                        </div>
                                        @auth
                                            <a href="{{ route('topics.create', $forum) }}" class="ml-4 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm transition-colors duration-200">
                                                Nouveau sujet
                                            </a>
                                        @endauth
                                    </div>
                                    <p class="text-gray-600 mb-4">{{ $forum->description }}</p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <div class="flex items-center mr-4">
                                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            {{ $forum->topics->count() }} sujets
                                        </div>
                                        @if($forum->topics->count() > 0)
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Dernier message: {{ $forum->topics->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 mb-4">Aucun forum n'a encore été créé.</p>
            @auth
                <a href="{{ route('forums.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Créer le premier forum
                </a>
            @else
                <div class="space-y-4">
                    <p class="text-gray-500">Connectez-vous pour créer un forum</p>
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            S'inscrire
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    @endforelse
</div>
@endsection 