<nav x-data="{ isOpen: false }" class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center space-x-2">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent hover:from-blue-500 hover:to-blue-700 transition-all duration-300">TCGalaxy</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <div class="flex space-x-6">
                    <a href="/" class="relative px-3 py-2 text-sm font-medium text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('/') ? 'text-blue-300' : '' }}">
                        Accueil
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 transition-transform duration-300 origin-left {{ request()->is('/') ? 'scale-x-100' : '' }}"></span>
                    </a>
                    <a href="{{ route('games.index') }}" class="relative px-3 py-2 text-sm font-medium text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('games*') ? 'text-blue-300' : '' }}">
                        Jeux
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 transition-transform duration-300 origin-left {{ request()->is('games*') ? 'scale-x-100' : '' }}"></span>
                    </a>
                    <a href="{{ route('events.find') }}" class="relative px-3 py-2 text-sm font-medium text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('events/find*') ? 'text-blue-300' : '' }}">
                        Événements
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 transition-transform duration-300 origin-left {{ request()->is('events/find*') ? 'scale-x-100' : '' }}"></span>
                    </a>
                    <a href="{{ route('forums.index') }}" class="relative px-3 py-2 text-sm font-medium text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('forums*') ? 'text-blue-300' : '' }}">
                        Forum
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 transition-transform duration-300 origin-left {{ request()->is('forums*') ? 'scale-x-100' : '' }}"></span>
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer un événement
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-blue-300 transition-all duration-300">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'transform rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl py-1 z-50 border border-slate-700">
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-sm text-white hover:bg-slate-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Tableau de bord
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-white hover:bg-slate-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Modifier mon profil
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <div class="border-t border-slate-700 my-1"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-white hover:bg-slate-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Tableau de bord admin
                                    </a>
                                    <a href="{{ route('games.create') }}" class="flex items-center px-4 py-2 text-sm text-white hover:bg-slate-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Ajouter un jeu
                                    </a>
                                @endif
                                <div class="border-t border-slate-700 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-white hover:bg-slate-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-white hover:text-blue-300 transition-all duration-300 {{ request()->is('login') ? 'text-blue-300' : '' }}">Connexion</a>
                        <a href="/register" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-sm">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="isOpen = !isOpen" class="text-white hover:text-blue-300 focus:outline-none transition-colors duration-300">
                    <svg class="h-6 w-6" :class="{ 'hidden': isOpen, 'block': !isOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'block': isOpen, 'hidden': !isOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('/') ? 'bg-slate-700' : '' }}">Accueil</a>
            <a href="{{ route('games.index') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('games*') ? 'bg-slate-700' : '' }}">Jeux</a>
            <a href="{{ route('events.find') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('events/find*') ? 'bg-slate-700' : '' }}">Événements</a>
            <a href="{{ route('forums.index') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200 {{ request()->is('forums*') ? 'bg-slate-700' : '' }}">Forum</a>
            @auth
                <a href="{{ route('events.create') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Créer un événement</a>
                <a href="{{ route('profile') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Tableau de bord</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Modifier mon profil</a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Tableau de bord admin</a>
                    <a href="{{ route('games.create') }}" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Ajouter un jeu</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Déconnexion</button>
                </form>
            @else
                <a href="/login" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Connexion</a>
                <a href="/register" class="block px-3 py-2 text-white hover:bg-slate-700 rounded-lg transition-colors duration-200">Inscription</a>
            @endauth
        </div>
    </div>
</nav>

<style>
[x-cloak] { display: none !important; }
</style>