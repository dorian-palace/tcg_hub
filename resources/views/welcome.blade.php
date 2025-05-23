@extends('layouts.app')

@section('title', 'TCGalaxy - La plateforme des jeux de cartes à collectionner')
@section('meta_description', 'TCGalaxy est la plateforme ultime pour les amateurs de jeux de cartes à collectionner. Organisez des événements, gérez votre collection et trouvez des joueurs près de chez vous. Pokémon, Yu-Gi-Oh!, Magic: The Gathering, One Piece et plus encore.')
@section('og_image', asset('images/og-image.jpg'))

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
    <div class="py-8 sm:py-12 md:py-16 lg:py-20 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 md:gap-12 items-center">
                <div class="text-center md:text-left order-2 md:order-1">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                        Bienvenue sur TCGalaxy
                    </h1>
                    <p class="mt-3 sm:mt-4 text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto md:mx-0">
                        La plateforme ultime pour les amateurs de jeux de cartes à collectionner.<br class="hidden sm:block">
                        Organisez des événements, gérez votre collection et trouvez des joueurs près de chez vous.
                    </p>
                    <div class="mt-6 sm:mt-8 flex flex-wrap justify-center md:justify-start gap-3 sm:gap-4">
                        <a href="{{ route('events.find') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm sm:text-base">Trouver des événements</a>
                        <a href="{{ route('games.index') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-light-accent text-light-text rounded-lg hover:bg-light-secondary transition-colors text-sm sm:text-base">Explorer les jeux</a>
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 border border-blue-400 text-blue-400 rounded-lg hover:bg-blue-400 hover:text-white transition-colors text-sm sm:text-base">Créer un compte</a>
                    </div>
                </div>

                <div class="order-1 md:order-2 mb-6 md:mb-0">
                    <img src="{{ asset('images/5.svg') }}" alt="TCG Illustration" class="w-full h-auto max-w-[200px] sm:max-w-[250px] md:max-w-[300px] lg:max-w-[350px] mx-auto">
                </div>
            </div>
        </div>
    </div>


    <!-- Events Carousel Section -->
    <div class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
                    Prochains grands événements TCG
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-700 sm:mt-4">
                    Découvrez les plus grands tournois et événements TCG en France
                </p>
            </div>
            <div id="app" class="bg-white rounded-xl shadow-lg p-6">
                <event-carousel></event-carousel>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gradient-to-b from-gray-100 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
                    Nos fonctionnalités
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-700 sm:mt-4">
                    Découvrez tout ce que TCGalaxy a à vous offrir
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 border border-gray-200">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Recherche géolocalisée</h3>
                            <p class="text-gray-700 mb-4">Trouvez des événements TCG près de chez vous grâce à notre système de recherche par distance.</p>
                            <a href="/events/find" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Trouver des événements</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 border border-gray-200">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-exchange-alt text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Échange de cartes</h3>
                            <p class="text-gray-700 mb-4">Échangez ou vendez vos cartes avec d'autres collectionneurs passionnés.</p>
                            <a href="/cards" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Explorer les cartes</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 border border-gray-200">
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-trophy text-4xl text-blue-600 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Tournois et événements</h3>
                            <p class="text-gray-700 mb-4">Participez à des tournois ou organisez vos propres événements TCG.</p>
                            <a href="/events" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Voir les tournois</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Section -->
    <div class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
                        Une communauté passionnée
                    </h2>
                    <p class="mt-3 text-xl text-gray-700">
                        Rejoignez des milliers de joueurs et collectionneurs partageant votre passion pour les TCG.
                    </p>
                    <p class="mt-4 text-gray-700">
                        Que vous soyez débutant ou joueur expérimenté, TCGalaxy vous offre un espace pour partager votre passion, améliorer votre collection et rencontrer d'autres amateurs de jeux de cartes.
                    </p>
                    <div class="mt-8">
                        <a href="/register" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Nous rejoindre</a>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-full max-w-md">
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-gray-200">
                            <img src="https://images.unsplash.com/photo-1511882150382-421056c89033?ixlib=rb-4.0.0&auto=format&fit=crop&w=800&q=80" 
                                 alt="Communauté TCG" 
                                 class="w-full h-64 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forum Highlight Section -->
    <div id="vue-forum-highlight" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <forum-highlight
            :forums-count="{{ \App\Models\Forum::count() }}"
            :topics-count="{{ \App\Models\ForumTopic::count() }}"
            forum-url="{{ route('forums.index') }}"
        ></forum-highlight>
    </div>

    <!-- Popular Games Section -->
    <div class="py-16 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Jeux populaires</h2>
                <a href="{{ route('games.index') }}" class="text-blue-600 hover:text-blue-700 transition-colors">Voir tous les jeux</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('games.index') }}?search=pokemon" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full border border-gray-200">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/1200px-International_Pok%C3%A9mon_logo.svg.png" 
                                 alt="Pokémon TCG" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors text-gray-800">Pokémon TCG</h3>
                            <p class="text-gray-700 mb-4">Le jeu de cartes à collectionner Pokémon.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">+1000 cartes</span>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">+50 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=magic" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full border border-gray-200">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://latartineludique.fr/wp-content/uploads/2024/03/Magic-The-Gathering-Logo.png" 
                                 alt="Magic: The Gathering" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors text-gray-800">Magic: The Gathering</h3>
                            <p class="text-gray-700 mb-4">Le premier jeu de cartes à collectionner.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">+5000 cartes</span>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">+100 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=yugioh" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full border border-gray-200">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/fr/a/a5/Yu-Gi-Oh_Logo.JPG" 
                                 alt="Yu-Gi-Oh!" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors text-gray-800">Yu-Gi-Oh!</h3>
                            <p class="text-gray-700 mb-4">Le célèbre jeu de cartes inspiré du manga.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">+3000 cartes</span>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">+80 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('games.index') }}?search=one+piece" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 h-full border border-gray-200">
                        <div class="h-48 w-full overflow-hidden">
                            <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/1/1a/Logo_One_piece.svg/640px-Logo_One_piece.svg.png" 
                                 alt="One Piece Card Game" 
                                 class="w-full h-full object-contain p-4">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-600 transition-colors text-gray-800">One Piece Card Game</h3>
                            <p class="text-gray-700 mb-4">Le jeu de cartes basé sur l'univers de One Piece.</p>
                            <div class="flex gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">+500 cartes</span>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">+30 événements</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg p-8 md:p-12 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
                            Prêt à rejoindre la communauté?
                        </h2>
                        <p class="mt-3 text-xl text-gray-700">
                            Créez un compte gratuit dès aujourd'hui et commencez à explorer le monde des cartes à collectionner.
                        </p>
                    </div>
                    <div class="text-center md:text-right">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-lg">S'inscrire maintenant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection