@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-50 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h2>
            </div>

            @if($event->image)
                <div class="relative w-full h-48 sm:h-64 md:h-80 lg:h-96 bg-gray-100">
                    <img src="{{ $event->image }}" 
                         alt="{{ $event->title }}" 
                         class="w-full h-full object-contain">
                </div>
            @endif

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Jeu</h3>
                            <p class="mt-1 text-gray-900">{{ $event->game->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Description</h3>
                            <p class="mt-1 text-gray-900">{{ $event->description }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Type d'événement</h3>
                            <p class="mt-1 text-gray-900">
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
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Lieu</h3>
                            <p class="mt-1 text-gray-900">
                                {{ $event->venue_name }}<br>
                                {{ $event->address }}<br>
                                {{ $event->postal_code }} {{ $event->city }}<br>
                                @if($event->state)
                                    {{ $event->state }}, 
                                @endif
                                {{ $event->country }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Date et heure</h3>
                            <p class="mt-1 text-gray-900">
                                <span class="text-gray-600">Début :</span> {{ $event->start_datetime->format('d/m/Y H:i') }}<br>
                                <span class="text-gray-600">Fin :</span> {{ $event->end_datetime->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Participants</h3>
                            <p class="mt-1 text-gray-900">
                                Maximum : {{ $event->max_participants }}
                            </p>
                        </div>

                        @if($event->entry_fee > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-600">Frais d'entrée</h3>
                                <p class="mt-1 text-gray-900">{{ number_format($event->entry_fee, 2) }} €</p>
                            </div>
                        @endif

                        @if($event->prizes)
                            <div>
                                <h3 class="text-sm font-medium text-gray-600">Prix à gagner</h3>
                                <p class="mt-1 text-gray-900">{{ $event->prizes }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-medium text-gray-600">Organisateur</h3>
                            <p class="mt-1 text-gray-900">{{ $event->user->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('events.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Créer un autre événement
                    </a>
                    <a href="{{ route('events.find') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Retour à la liste des événements
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Commentaires ({{ $event->getCommentCount() }})</h2>

            @auth
            <div class="mb-6">
                <form action="{{ route('comments.store', $event) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Votre commentaire</label>
                        <textarea name="content" id="content" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Publier
                        </button>
                    </div>
                </form>
            </div>
            @endauth

            <div class="space-y-6">
                @foreach($event->comments as $comment)
                    <div class="bg-white rounded-lg shadow-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($comment->user->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-light-secondary text-blue-400 flex items-center justify-center">
                                            <span class="text-sm font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $comment->getFormattedDate() }}</p>
                                </div>
                            </div>
                            @if(Auth::id() === $comment->user_id || Auth::user()?->isAdmin())
                                <div class="flex space-x-2">
                                    <button onclick="editComment({{ $comment->id }})" class="text-blue-600 hover:text-blue-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-500">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>

                        @auth
                        <div class="mt-4">
                            <button onclick="replyToComment({{ $comment->id }})" class="text-sm text-blue-600 hover:text-blue-500">
                                Répondre
                            </button>
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                                <form action="{{ route('comments.store', $event) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <textarea name="content" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-1 px-3 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Publier la réponse
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth

                        @if($comment->replies->isNotEmpty())
                            <div class="mt-4 ml-6 space-y-4">
                                @foreach($comment->replies as $reply)
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    @if($reply->user->avatar)
                                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-light-secondary text-blue-400 flex items-center justify-center">
                                                            <span class="text-xs font-bold">{{ substr($reply->user->name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $reply->user->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $reply->getFormattedDate() }}</p>
                                                </div>
                                            </div>
                                            @if(Auth::id() === $reply->user_id || Auth::user()?->isAdmin())
                                                <div class="flex space-x-2">
                                                    <button onclick="editComment({{ $reply->id }})" class="text-blue-600 hover:text-blue-500">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-500">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-700">{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function replyToComment(commentId) {
    const form = document.getElementById(`reply-form-${commentId}`);
    form.classList.toggle('hidden');
}

function editComment(commentId) {
    const comment = document.querySelector(`#comment-${commentId}`);
    const content = comment.querySelector('.comment-content');
    const editForm = document.querySelector(`#edit-form-${commentId}`);
    
    content.classList.add('hidden');
    editForm.classList.remove('hidden');
}
</script>
@endpush
@endsection 