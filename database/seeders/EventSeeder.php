<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les jeux et les utilisateurs existants
        $games = Game::all();
        $users = User::all();

        if ($games->isEmpty() || $users->isEmpty()) {
            $this->command->info('Aucun jeu ou utilisateur trouvé. Veuillez d\'abord exécuter les seeders pour les jeux et les utilisateurs.');
            return;
        }

        $events = [
            [
                'title' => 'Tournoi Pokémon Championnat',
                'description' => 'Tournoi officiel Pokémon TCG avec des lots à gagner !',
                'venue_name' => 'Game Store Paris',
                'address' => '123 Rue du Jeu',
                'city' => 'Paris',
                'state' => 'Île-de-France',
                'postal_code' => '75001',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(7)->setTime(10, 0),
                'end_datetime' => Carbon::now()->addDays(7)->setTime(18, 0),
                'event_type' => 'tournament',
                'max_participants' => 32,
                'entry_fee' => 15.00,
                'prizes' => '1er : Booster Box, 2ème : 10 boosters, 3ème : 5 boosters',
            ],
            [
                'title' => 'Soirée Magic Commander',
                'description' => 'Soirée dédiée au format Commander de Magic: The Gathering',
                'venue_name' => 'Magic Corner',
                'address' => '456 Avenue des Cartes',
                'city' => 'Lyon',
                'state' => 'Auvergne-Rhône-Alpes',
                'postal_code' => '69001',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(14)->setTime(19, 0),
                'end_datetime' => Carbon::now()->addDays(14)->setTime(23, 0),
                'event_type' => 'casual_play',
                'max_participants' => 20,
                'entry_fee' => 5.00,
                'prizes' => 'Promo cards pour tous les participants',
            ],
            [
                'title' => 'Échange Yu-Gi-Oh!',
                'description' => 'Session d\'échange de cartes Yu-Gi-Oh!',
                'venue_name' => 'Card Exchange Center',
                'address' => '789 Boulevard des Duelistes',
                'city' => 'Marseille',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '13001',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(21)->setTime(14, 0),
                'end_datetime' => Carbon::now()->addDays(21)->setTime(18, 0),
                'event_type' => 'trade',
                'max_participants' => 30,
                'entry_fee' => 0.00,
                'prizes' => null,
            ],
            [
                'title' => 'Pré-release One Piece',
                'description' => 'Événement de pré-release du nouveau set One Piece TCG',
                'venue_name' => 'Anime Store',
                'address' => '321 Rue des Mangas',
                'city' => 'Bordeaux',
                'state' => 'Nouvelle-Aquitaine',
                'postal_code' => '33000',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(28)->setTime(11, 0),
                'end_datetime' => Carbon::now()->addDays(28)->setTime(17, 0),
                'event_type' => 'release',
                'max_participants' => 40,
                'entry_fee' => 25.00,
                'prizes' => 'Pré-release pack pour tous les participants',
            ],
            [
                'title' => 'Tournoi Flesh and Blood',
                'description' => 'Tournoi Flesh and Blood avec des lots exclusifs',
                'venue_name' => 'TCG Arena',
                'address' => '654 Rue des Héros',
                'city' => 'Lille',
                'state' => 'Hauts-de-France',
                'postal_code' => '59000',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(35)->setTime(13, 0),
                'end_datetime' => Carbon::now()->addDays(35)->setTime(20, 0),
                'event_type' => 'tournament',
                'max_participants' => 24,
                'entry_fee' => 20.00,
                'prizes' => '1er : Cold Foil Legendary, 2ème : Extended Art Fabled, 3ème : Promo Pack',
            ],
            [
                'title' => 'Tournoi Pokémon Marseille',
                'description' => 'Tournoi Pokémon TCG avec des lots exclusifs de la région',
                'venue_name' => 'Marseille Gaming Center',
                'address' => '45 Rue de la Joliette',
                'city' => 'Marseille',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '13002',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(10)->setTime(9, 0),
                'end_datetime' => Carbon::now()->addDays(10)->setTime(17, 0),
                'event_type' => 'tournament',
                'max_participants' => 40,
                'entry_fee' => 10.00,
                'prizes' => '1er : Booster Box + Promo Card, 2ème : 15 boosters, 3ème : 8 boosters',
            ],
            [
                'title' => 'Soirée Magic Modern',
                'description' => 'Soirée dédiée au format Modern de Magic: The Gathering',
                'venue_name' => 'Le Temple des Cartes',
                'address' => '78 Avenue du Prado',
                'city' => 'Marseille',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '13008',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(15)->setTime(18, 0),
                'end_datetime' => Carbon::now()->addDays(15)->setTime(23, 0),
                'event_type' => 'casual_play',
                'max_participants' => 25,
                'entry_fee' => 7.00,
                'prizes' => 'Promo cards Modern Horizons pour les 4 premiers',
            ],
            [
                'title' => 'Pré-release Yu-Gi-Oh!',
                'description' => 'Événement de pré-release du nouveau set Yu-Gi-Oh!',
                'venue_name' => 'Duel Masters',
                'address' => '12 Rue Saint-Ferréol',
                'city' => 'Marseille',
                'state' => 'Provence-Alpes-Côte d\'Azur',
                'postal_code' => '13001',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(20)->setTime(10, 0),
                'end_datetime' => Carbon::now()->addDays(20)->setTime(16, 0),
                'event_type' => 'release',
                'max_participants' => 35,
                'entry_fee' => 30.00,
                'prizes' => 'Pré-release pack + carte promo exclusive',
            ],
            [
                'title' => 'Tournoi Dragon Ball Super',
                'description' => 'Tournoi officiel Dragon Ball Super Card Game',
                'venue_name' => 'Anime World',
                'address' => '89 Rue de la République',
                'city' => 'Lyon',
                'state' => 'Auvergne-Rhône-Alpes',
                'postal_code' => '69002',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(12)->setTime(11, 0),
                'end_datetime' => Carbon::now()->addDays(12)->setTime(19, 0),
                'event_type' => 'tournament',
                'max_participants' => 28,
                'entry_fee' => 12.00,
                'prizes' => '1er : Booster Box, 2ème : 8 boosters, 3ème : 4 boosters',
            ],
            [
                'title' => 'Soirée Flesh and Blood',
                'description' => 'Soirée découverte et jeu libre Flesh and Blood',
                'venue_name' => 'Heroes Arena',
                'address' => '34 Rue de la Paix',
                'city' => 'Bordeaux',
                'state' => 'Nouvelle-Aquitaine',
                'postal_code' => '33000',
                'country' => 'France',
                'start_datetime' => Carbon::now()->addDays(17)->setTime(19, 0),
                'end_datetime' => Carbon::now()->addDays(17)->setTime(23, 0),
                'event_type' => 'casual_play',
                'max_participants' => 20,
                'entry_fee' => 5.00,
                'prizes' => 'Promo cards pour tous les participants',
            ],
        ];

        foreach ($events as $eventData) {
            $event = new Event($eventData);
            $event->user_id = $users->random()->id;
            $event->game_id = $games->random()->id;
            $event->is_approved = true;
            $event->is_cancelled = false;
            $event->save();
        }

        $this->command->info('Events seeded successfully!');
    }
}
