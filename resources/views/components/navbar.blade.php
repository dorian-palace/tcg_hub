<nav class="bg-[rgb(31,41,55)] text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-white hover:text-blue-400 transition-colors">TCG HUB</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-white hover:text-blue-400 focus:outline-none" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <div class="flex space-x-4">
                    <a href="/" class="text-white hover:text-blue-400 transition-colors {{ request()->is('/') ? 'text-blue-400' : '' }}">Accueil</a>
                    <a href="{{ route('games.index') }}" class="text-white hover:text-blue-400 transition-colors {{ request()->is('games*') ? 'text-blue-400' : '' }}">Jeux</a>
                    {{-- <a href="{{ route('cards.index') }}" class="text-white hover:text-blue-400 transition-colors {{ request()->is('cards*') ? 'text-blue-400' : '' }}">Cartes</a> --}}
                    <a href="{{ route('events.find') }}" class="text-white hover:text-blue-400 transition-colors {{ request()->is('events/find*') ? 'text-blue-400' : '' }}">Événements</a>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Créer un événement
                        </a>
                        <div class="ml-3 relative">
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center text-white hover:text-blue-400 transition-colors">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-[rgb(31,41,55)] rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Tableau de bord</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Modifier mon profil</a>
                                    <a href="{{ route('my-collection') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Ma collection</a>
                                    <a href="{{ route('my-events') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Mes événements</a>
                                    <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Mes transactions</a>
                                    @if(Auth::user()->isAdmin())
                                        <div class="border-t border-[rgb(55,65,81)] my-1"></div>
                                        <a href="{{ route('games.create') }}" class="block px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Ajouter un jeu</a>
                                    @endif
                                    <div class="border-t border-[rgb(55,65,81)] my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-white hover:bg-[rgb(55,65,81)]">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-white hover:text-blue-400 transition-colors {{ request()->is('login') ? 'text-blue-400' : '' }}">Connexion</a>
                        <a href="/register" class="text-white hover:text-blue-400 transition-colors {{ request()->is('register') ? 'text-blue-400' : '' }}">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-white hover:bg-[rgb(55,65,81)] rounded-md {{ request()->is('/') ? 'bg-[rgb(55,65,81)]' : '' }}">Accueil</a>
                <a href="{{ route('games.index') }}" class="block px-3 py-2 text-white hover:bg-[rgb(55,65,81)] rounded-md {{ request()->is('games*') ? 'bg-[rgb(55,65,81)]' : '' }}">Jeux</a>
                {{-- <a href="{{ route('cards.index') }}" class="block px-3 py-2 text-white hover:bg-[rgb(55,65,81)] rounded-md {{ request()->is('cards*') ? 'bg-[rgb(55,65,81)]' : '' }}">Cartes</a> --}}
                <a href="{{ route('events.find') }}" class="block px-3 py-2 text-white hover:bg-[rgb(55,65,81)] rounded-md {{ request()->is('events/find*') ? 'bg-[rgb(55,65,81)]' : '' }}">Événements</a>
                @auth
                    <a href="{{ route('events.create') }}" class="block px-3 py-2 text-white hover:bg-[rgb(55,65,81)] rounded-md">Créer un événement</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
[x-cloak] { display: none !important; }
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
            this.open = !this.open
        }
    }))
})

document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>