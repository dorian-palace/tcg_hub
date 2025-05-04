<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TCG HUB - Plateforme pour les jeux de cartes à collectionner')</title>
    <meta name="description" content="@yield('meta_description', 'Trouvez des événements de jeux de cartes à collectionner, échangez des cartes et participez à des tournois')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            primary: '#1a1a1a',
                            secondary: '#2d2d2d',
                            accent: '#3d3d3d',
                            text: '#e0e0e0',
                            'text-secondary': '#a0a0a0',
                        },
                        light: {
                            primary: '#ffffff',
                            secondary: '#f5f5f5',
                            accent: '#e0e0e0',
                            text: '#1a1a1a',
                            'text-secondary': '#4a4a4a',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body class="min-h-screen bg-[rgb(17,24,39)] text-white">
    @include('components.navbar')

    <main class="container mx-auto px-4 py-8">
        <div class="bg-[rgb(31,41,55)] rounded-lg shadow-lg p-6">
            @yield('content')
        </div>
    </main>

    <footer class="bg-[rgb(31,41,55)] text-white py-4 mt-5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">TCG HUB</h5>
                    <p>La plateforme pour tous les amateurs de jeux de cartes à collectionner.</p>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Liens utiles</h5>
                    <ul class="space-y-2">
                        <li><a href="/" class="hover:text-blue-400 transition-colors">Accueil</a></li>
                        <li><a href="/about" class="hover:text-blue-400 transition-colors">À propos</a></li>
                        <li><a href="/contact" class="hover:text-blue-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Suivez-nous</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Twitter</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Facebook</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-8 border-[rgb(55,65,81)]">
            <div class="text-center">
                <p>&copy; 2025 TCG HUB. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>