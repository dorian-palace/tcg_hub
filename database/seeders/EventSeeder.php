<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organisateur = \App\Models\User::where('email', 'organisateur@tcghub.com')->first();
        $admin = \App\Models\User::where('email', 'admin@tcghub.com')->first();
        
        // Tournoi Pokémon à Paris
        \App\Models\Event::create([
            'user_id' => $organisateur->id,
            'game_id' => 1, // Pokémon TCG
            'title' => 'Tournoi Pokémon TCG Standard',
            'description' => 'Tournoi Pokémon TCG format Standard avec lots pour les 4 premiers.',
            'venue_name' => 'L\'Arène des Cartes',
            'address' => '15 rue de la République',
            'city' => 'Paris',
            'postal_code' => '75003',
            'country' => 'France',
            'latitude' => 48.8638,
            'longitude' => 2.3586,
            'start_datetime' => now()->addDays(5)->setHour(14)->setMinute(0),
            'end_datetime' => now()->addDays(5)->setHour(19)->setMinute(0),
            'event_type' => 'tournament',
            'max_participants' => 32,
            'entry_fee' => 5.00,
            'prizes' => 'Boosters pour les 8 premiers, carte promo exclusive pour les 4 premiers',
            'is_approved' => true,
            'is_cancelled' => false,
        ]);
        
        // Session casual Magic à Lyon
        \App\Models\Event::create([
            'user_id' => $admin->id,
            'game_id' => 2, // Magic: The Gathering
            'title' => 'Soirée Commander MTG',
            'description' => 'Soirée jeu libre format Commander. Tous niveaux bienvenus!',
            'venue_name' => 'Le Donjon des Cartes',
            'address' => '42 rue Mercière',
            'city' => 'Lyon',
            'postal_code' => '69002',
            'country' => 'France',
            'latitude' => 45.7578,
            'longitude' => 4.8320,
            'start_datetime' => now()->addDays(3)->setHour(18)->setMinute(30),
            'end_datetime' => now()->addDays(3)->setHour(23)->setMinute(0),
            'event_type' => 'casual_play',
            'max_participants' => 20,
            'entry_fee' => 0.00,
            'prizes' => null,
            'is_approved' => true,
            'is_cancelled' => false,
        ]);
        
        // Journée d'échange à Marseille
        \App\Models\Event::create([
            'user_id' => $organisateur->id,
            'game_id' => 3, // Yu-Gi-Oh!
            'title' => 'Bourse d\'échange Yu-Gi-Oh!',
            'description' => 'Journée dédiée à l\'échange de cartes Yu-Gi-Oh!. Apportez vos classeurs!',
            'venue_name' => 'Centre Culturel du Panier',
            'address' => '10 Place des Moulins',
            'city' => 'Marseille',
            'postal_code' => '13002',
            'country' => 'France',
            'latitude' => 43.2984,
            'longitude' => 5.3636,
            'start_datetime' => now()->addDays(10)->setHour(10)->setMinute(0),
            'end_datetime' => now()->addDays(10)->setHour(18)->setMinute(0),
            'event_type' => 'trade',
            'max_participants' => 50,
            'entry_fee' => 2.00,
            'prizes' => null,
            'is_approved' => true,
            'is_cancelled' => false,
        ]);
        
        // Tournoi One Piece à Nice
        \App\Models\Event::create([
            'user_id' => $admin->id,
            'game_id' => 4, // One Piece Card Game
            'title' => 'Championnat régional One Piece Card Game',
            'description' => 'Tournoi qualificatif pour le championnat national de One Piece Card Game.',
            'venue_name' => 'Boutique Au Grand Large',
            'address' => '28 Boulevard Victor Hugo',
            'city' => 'Nice',
            'postal_code' => '06000',
            'country' => 'France',
            'latitude' => 43.7032,
            'longitude' => 7.2661,
            'start_datetime' => now()->addDays(15)->setHour(9)->setMinute(0),
            'end_datetime' => now()->addDays(15)->setHour(19)->setMinute(0),
            'event_type' => 'tournament',
            'max_participants' => 64,
            'entry_fee' => 15.00,
            'prizes' => 'Cartes promos exclusives, qualification pour le championnat national, lots de boosters',
            'is_approved' => true,
            'is_cancelled' => false,
        ]);
        
        // Événement à proximité de Paris (pour tester la recherche géolocalisée)
        \App\Models\Event::create([
            'user_id' => $organisateur->id,
            'game_id' => 5, // Dragon Ball Super Card Game
            'title' => 'Tournoi amical Dragon Ball Super',
            'description' => 'Tournoi amical de Dragon Ball Super Card Game ouvert à tous les niveaux.',
            'venue_name' => 'Café des Joueurs',
            'address' => '1 Avenue de Saint-Ouen',
            'city' => 'Paris',
            'postal_code' => '75017',
            'country' => 'France',
            'latitude' => 48.8875,
            'longitude' => 2.3243,
            'start_datetime' => now()->addDays(2)->setHour(14)->setMinute(0),
            'end_datetime' => now()->addDays(2)->setHour(18)->setMinute(0),
            'event_type' => 'tournament',
            'max_participants' => 16,
            'entry_fee' => 3.00,
            'prizes' => 'Boosters pour tous les participants, cartes promos pour le top 4',
            'is_approved' => true,
            'is_cancelled' => false,
        ]);
    }
}
