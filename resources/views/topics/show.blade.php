@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-5xl">
    <div class="mb-10">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center space-x-3">
                    @if($topic->is_pinned)
                        <span class="text-blue-500 transform hover:scale-110 transition-transform">
                            <i class="fas fa-thumbtack"></i>
                        </span>
                    @endif
                    @if($topic->is_locked)
                        <span class="text-red-500 transform hover:scale-110 transition-transform">
                            <i class="fas fa-lock"></i>
                        </span>
                    @endif
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight">{{ $topic->title }}</h1>
                </div>
                <div class="mt-3 text-sm text-gray-600 flex items-center space-x-2">
                    <span class="flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ $topic->user->name }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        {{ $topic->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-4">
                @can('update', $topic)
                    <a href="{{ route('topics.edit', [$forum, $topic]) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                @endcan
                @can('delete', $topic)
                    <form action="{{ route('topics.destroy', [$forum, $topic]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sujet ?')">
                            <i class="fas fa-trash mr-2"></i> Supprimer
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-10 transform hover:shadow-xl transition-shadow duration-300">
        <div class="p-8">
            <div class="prose max-w-none prose-lg">
                {!! nl2br(e($topic->content)) !!}
            </div>
        </div>
    </div>

    <div class="mb-10">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-comments mr-3 text-blue-500"></i>
            Réponses
        </h2>
        @forelse($topic->posts as $post)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 transform hover:shadow-xl transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full ring-2 ring-blue-100" src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}">
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $post->user->name }}
                                </div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @if($post->is_solution)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i> Solution
                            </span>
                        @endif
                    </div>
                    <div class="prose max-w-none prose-lg">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-lg p-8 text-center text-gray-500">
                <i class="fas fa-comment-slash text-4xl mb-4 text-gray-400"></i>
                <p class="text-lg">Aucune réponse n'a encore été postée.</p>
            </div>
        @endforelse
    </div>

    @auth
        @unless($topic->is_locked)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:shadow-xl transition-all duration-300">
                <div class="p-8">
                    <h3 class="text-xl font-medium text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-reply mr-3 text-blue-500"></i>
                        Ajouter une réponse
                    </h3>
                    <form action="{{ route('posts.store', [$forum, $topic]) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <textarea name="content" rows="4" class="shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all duration-200" required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Poster
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <i class="fas fa-lock text-4xl mb-4 text-red-400"></i>
                <p class="text-lg text-gray-600">Ce sujet est verrouillé. Vous ne pouvez plus y répondre.</p>
            </div>
        @endunless
    @else
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <i class="fas fa-user-lock text-4xl mb-4 text-gray-400"></i>
            <p class="text-lg text-gray-600 mb-4">Vous devez être connecté pour répondre à ce sujet.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Se connecter
            </a>
        </div>
    @endauth
</div>
@endsection 