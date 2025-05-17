@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $forum->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $forum->description }}</p>
        </div>
        @auth
            <a href="{{ route('topics.create', $forum) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                Créer un sujet
            </a>
        @endauth
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @forelse($topics as $topic)
            <div class="border-b last:border-b-0">
                <a href="{{ route('topics.show', [$forum, $topic]) }}" class="block p-6 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                @if($topic->is_pinned)
                                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                @endif
                                @if($topic->is_locked)
                                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                @endif
                                <h3 class="text-xl font-semibold text-gray-900">{{ $topic->title }}</h3>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <span>Par {{ $topic->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="ml-6 flex items-center space-x-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                {{ $topic->posts->count() }} réponses
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $topic->views_count }} vues
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                Aucun sujet n'a encore été créé dans ce forum.
                @auth
                    <a href="{{ route('topics.create', $forum) }}" class="text-blue-500 hover:text-blue-600 ml-1">
                        Créer le premier sujet
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $topics->links() }}
    </div>
</div>
@endsection 