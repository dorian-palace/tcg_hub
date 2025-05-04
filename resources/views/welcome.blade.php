@extends('layouts.app')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/images/hero-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        margin-bottom: 40px;
    }
    
    .feature-card {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
    }
    
    .feature-icon {
        font-size: 40px;
        margin-bottom: 20px;
        color: #0d6efd;
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="py-16 bg-[rgb(17,24,39)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl">
                    Bienvenue sur TCG HUB
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-300 sm:mt-4">
                    La plateforme ultime pour les amateurs de jeux de cartes à collectionner.<br>
                    Organisez des événements, gérez votre collection et trouvez des joueurs près de chez vous.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('events.find') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Trouver des événements</a>
                    <a href="{{ route('games.index') }}" class="px-6 py-3 bg-[rgb(31,41,55)] text-white rounded-lg hover:bg-[rgb(55,65,81)] transition-colors">Explorer les jeux</a>
                    <a href="{{ route('register') }}" class="px-6 py-3 border border-blue-400 text-blue-400 rounded-lg hover:bg-blue-400 hover:text-white transition-colors">Créer un compte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-[rgb(17,24,39)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Nos fonctionnalités
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-300 sm:mt-4">
                    Découvrez tout ce que TCG HUB a à vous offrir
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-4xl text-blue-400 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-4">Recherche géolocalisée</h3>
                            <p class="text-gray-300 mb-4">Trouvez des événements TCG près de chez vous grâce à notre système de recherche par distance.</p>
                            <a href="/events/find" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Trouver des événements</a>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-exchange-alt text-4xl text-blue-400 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-4">Échange de cartes</h3>
                            <p class="text-gray-300 mb-4">Échangez ou vendez vos cartes avec d'autres collectionneurs passionnés.</p>
                            <a href="/cards" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Explorer les cartes</a>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-trophy text-4xl text-blue-400 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-4">Tournois et événements</h3>
                            <p class="text-gray-300 mb-4">Participez à des tournois ou organisez vos propres événements TCG.</p>
                            <a href="/events" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Voir les tournois</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Section -->
    <div class="py-16 bg-[rgb(17,24,39)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        Une communauté passionnée
                    </h2>
                    <p class="mt-3 text-xl text-gray-300">
                        Rejoignez des milliers de joueurs et collectionneurs partageant votre passion pour les TCG.
                    </p>
                    <p class="mt-4 text-gray-300">
                        Que vous soyez débutant ou joueur expérimenté, TCG HUB vous offre un espace pour partager votre passion, améliorer votre collection et rencontrer d'autres amateurs de jeux de cartes.
                    </p>
                    <div class="mt-8">
                        <a href="/register" class="inline-block px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Nous rejoindre</a>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-full max-w-md">
                        <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg">
                            <img src="https://images.unsplash.com/photo-1511882150382-421056c89033?ixlib=rb-4.0.0&auto=format&fit=crop&w=800&q=80" 
                                 alt="Communauté TCG" 
                                 class="w-full h-64 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Games Section -->
    <div class="py-16 bg-[rgb(17,24,39)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-white">Jeux populaires</h2>
                <a href="{{ route('games.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors">Voir tous les jeux</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('games.index') }}?search=pokemon" class="group">
                    <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/1200px-International_Pok%C3%A9mon_logo.svg.png" 
                                 alt="Pokémon TCG" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-400 transition-colors text-white">Pokémon TCG</h3>
                            <p class="text-gray-300 mb-4">Le jeu de cartes à collectionner Pokémon.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-sm">+1000 cartes</span>
                                <span class="bg-gray-700 text-white px-3 py-1 rounded-full text-sm">+50 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=magic" class="group">
                    <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://latartineludique.fr/wp-content/uploads/2024/03/Magic-The-Gathering-Logo.png" 
                                 alt="Magic: The Gathering" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-400 transition-colors text-white">Magic: The Gathering</h3>
                            <p class="text-gray-300 mb-4">Le premier jeu de cartes à collectionner.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-sm">+5000 cartes</span>
                                <span class="bg-gray-700 text-white px-3 py-1 rounded-full text-sm">+100 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=yugioh" class="group">
                    <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/fr/a/a5/Yu-Gi-Oh_Logo.JPG" 
                                 alt="Yu-Gi-Oh!" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-400 transition-colors text-white">Yu-Gi-Oh!</h3>
                            <p class="text-gray-300 mb-4">Le célèbre jeu de cartes inspiré du manga.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-sm">+3000 cartes</span>
                                <span class="bg-gray-700 text-white px-3 py-1 rounded-full text-sm">+80 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=one+piece" class="group">
                    <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/1/1a/Logo_One_piece.svg/640px-Logo_One_piece.svg.png" 
                                 alt="One Piece Card Game" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-400 transition-colors text-white">One Piece Card Game</h3>
                            <p class="text-gray-300 mb-4">Le jeu de cartes basé sur l'univers de One Piece.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-sm">+500 cartes</span>
                                <span class="bg-gray-700 text-white px-3 py-1 rounded-full text-sm">+30 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-[rgb(17,24,39)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[rgb(31,41,55)] rounded-lg overflow-hidden shadow-lg p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                            Prêt à rejoindre la communauté?
                        </h2>
                        <p class="mt-3 text-xl text-gray-300">
                            Créez un compte gratuit dès aujourd'hui et commencez à explorer le monde des cartes à collectionner.
                        </p>
                    </div>
                    <div class="text-center md:text-right">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-lg">S'inscrire maintenant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection