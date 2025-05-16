<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TCGalaxy') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
<body class="min-h-screen bg-light-primary text-light-text">
    @include('components.navbar')

    <main class="container mx-auto px-4 py-8">
        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            @yield('content')
        </div>
    </main>

    <footer class="bg-light-accent text-light-text py-4 mt-5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">TCGalaxy</h5>
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
                <p>&copy; 2025 TCGalaxy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>