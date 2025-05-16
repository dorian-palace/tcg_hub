<nav class="bg-gradient-to-r from-slate-700 to-slate-800 text-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-white hover:text-blue-300 transition-all duration-300">TCGalaxy</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-white hover:text-blue-300 focus:outline-none transition-colors duration-300" id="mobile-menu-button">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <div class="flex space-x-6">
                    <a href="/" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('/') ? 'text-blue-300 font-medium' : '' }}">Accueil</a>
                    <a href="{{ route('games.index') }}" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('games*') ? 'text-blue-300 font-medium' : '' }}">Jeux</a>
                    {{-- <a href="{{ route('cards.index') }}" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('cards*') ? 'text-blue-300 font-medium' : '' }}">Cartes</a> --}}
                    <a href="{{ route('events.find') }}" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('events/find*') ? 'text-blue-300 font-medium' : '' }}">Événements</a>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-sm">
                            Créer un événement
                        </a>
                        <div class="ml-3 relative">
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center text-white hover:text-blue-300 transition-all duration-300">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-lg py-1 z-50 border border-slate-700">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-white hover:bg-slate-700 transition-colors duration-200">Tableau de bord</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-slate-700 transition-colors duration-200">Modifier mon profil</a>
                                    @if(Auth::user()->isAdmin())
                                        <div class="border-t border-slate-700 my-1"></div>
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-white hover:bg-slate-700 transition-colors duration-200">Tableau de bord admin</a>
                                        <a href="{{ route('games.create') }}" class="block px-4 py-2 text-white hover:bg-slate-700 transition-colors duration-200">Ajouter un jeu</a>
                                    @endif
                                    <div class="border-t border-slate-700 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-white hover:bg-slate-700 transition-colors duration-200">Déconnexion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('login') ? 'text-blue-300 font-medium' : '' }}">Connexion</a>
                        <a href="/register" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-sm">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('/') ? 'bg-slate-700' : '' }}">Accueil</a>
                <a href="{{ route('games.index') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('games*') ? 'bg-slate-700' : '' }}">Jeux</a>
                {{-- <a href="{{ route('cards.index') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('cards*') ? 'bg-slate-700' : '' }}">Cartes</a> --}}
                <a href="{{ route('events.find') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('events/find*') ? 'bg-slate-700' : '' }}">Événements</a>
                @auth
                    <a href="{{ route('events.create') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Créer un événement</a>
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