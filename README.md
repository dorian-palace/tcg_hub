# TCG HUB

TCG HUB est une plateforme pour les amateurs de jeux de cartes à collectionner (Trading Card Games). La plateforme permet de trouver des événements TCG à proximité, d'échanger/vendre des cartes et de participer à des tournois.

## Fonctionnalités principales

- **Recherche géolocalisée d'événements** avec filtres et carte interactive
- **Système d'authentification sécurisé** avec profils utilisateurs
- **Gestion des cartes** avec système d'échange et de vente
- **Système de création et gestion d'événements/tournois**

## Prérequis techniques

- PHP 8.2 ou supérieur
- Composer
- Node.js et NPM
- MySQL/MariaDB
- Clé API Mapbox (pour les fonctionnalités de géolocalisation)

## Installation

1. Cloner le dépôt
```bash
git clone https://github.com/votre-nom/tcg-hub.git
cd tcg-hub
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Installer les dépendances JavaScript
```bash
npm install
```

4. Copier le fichier d'environnement et le configurer
```bash
cp .env.example .env
```

5. Générer une clé d'application
```bash
php artisan key:generate
```

6. Configurer la base de données dans le fichier `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tcg_hub
DB_USERNAME=root
DB_PASSWORD=
```

7. Configurer la clé API Mapbox dans le fichier `.env`
```
VITE_MAPBOX_TOKEN=your_mapbox_api_key
```

8. Exécuter les migrations
```bash
php artisan migrate
```

9. Compiler les assets
```bash
npm run dev
```

10. Démarrer le serveur de développement
```bash
php artisan serve
```

L'application sera accessible à l'adresse http://localhost:8000

## Structure du projet

- `app/Models/` - Modèles de données (User, Game, Card, Event, etc.)
- `app/Http/Controllers/Api/` - Contrôleurs API REST
- `database/migrations/` - Migrations de base de données
- `resources/js/components/` - Composants Vue.js
- `resources/views/` - Vues Blade
- `routes/web.php` - Routes web et API

## Modèles de données principaux

1. **Utilisateurs** - Gestion des comptes, profils et préférences
2. **Jeux** - Liste des jeux de cartes disponibles
3. **Cartes** - Base de données des cartes par jeu
4. **Collections** - Relation entre utilisateurs et cartes
5. **Événements** - Gestion des tournois et rencontres
6. **Participations** - Inscriptions aux événements
7. **Transactions** - Historique des échanges et ventes

## Fonctionnalité de recherche géolocalisée

La recherche géolocalisée d'événements utilise:
- L'API Mapbox pour l'affichage de la carte et le géocodage
- La formule haversine pour calculer les distances
- Des filtres pour affiner les résultats par jeu, type d'événement, date, etc.
- La possibilité de trier par distance, date ou popularité

## Développement

Pour contribuer au projet:

1. Créer une branche pour votre fonctionnalité
```bash
git checkout -b feature/ma-nouvelle-fonctionnalite
```

2. Lancer le serveur de développement et le compilateur d'assets
```bash
php artisan serve
npm run dev
```

3. Soumettre une pull request avec vos modifications

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.