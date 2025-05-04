<nav class="bg-dark-secondary shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-dark-text hover:text-blue-400 transition-colors">TCG HUB</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-dark-text hover:text-blue-400 focus:outline-none" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <div class="flex space-x-4">
                    <a href="/" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('/') ? 'text-blue-400' : '' }}">Accueil</a>
                    <a href="{{ route('games.index') }}" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('games*') ? 'text-blue-400' : '' }}">Jeux</a>
                    <a href="{{ route('cards.index') }}" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('cards*') ? 'text-blue-400' : '' }}">Cartes</a>
                    <a href="{{ route('events.find') }}" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('events/find*') ? 'text-blue-400' : '' }}">Événements</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-dark-text hover:text-blue-400 transition-colors">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-dark-secondary rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-dark-text hover:bg-dark-accent">Tableau de bord</a>
                                <a href="{{ route('my-collection') }}" class="block px-4 py-2 text-dark-text hover:bg-dark-accent">Ma collection</a>
                                <a href="{{ route('my-events') }}" class="block px-4 py-2 text-dark-text hover:bg-dark-accent">Mes événements</a>
                                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-dark-text hover:bg-dark-accent">Mes transactions</a>
                                @if(Auth::user()->isAdmin())
                                    <div class="border-t border-dark-accent my-1"></div>
                                    <a href="{{ route('games.create') }}" class="block px-4 py-2 text-dark-text hover:bg-dark-accent">Ajouter un jeu</a>
                                @endif
                                <div class="border-t border-dark-accent my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-dark-text hover:bg-dark-accent">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('login') ? 'text-blue-400' : '' }}">Connexion</a>
                        <a href="/register" class="text-dark-text hover:text-blue-400 transition-colors {{ request()->is('register') ? 'text-blue-400' : '' }}">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-dark-text hover:bg-dark-accent rounded-md {{ request()->is('/') ? 'bg-dark-accent' : '' }}">Accueil</a>
                <a href="{{ route('games.index') }}" class="block px-3 py-2 text-dark-text hover:bg-dark-accent rounded-md {{ request()->is('games*') ? 'bg-dark-accent' : '' }}">Jeux</a>
                <a href="{{ route('cards.index') }}" class="block px-3 py-2 text-dark-text hover:bg-dark-accent rounded-md {{ request()->is('cards*') ? 'bg-dark-accent' : '' }}">Cartes</a>
                <a href="{{ route('events.find') }}" class="block px-3 py-2 text-dark-text hover:bg-dark-accent rounded-md {{ request()->is('events/find*') ? 'bg-dark-accent' : '' }}">Événements</a>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>