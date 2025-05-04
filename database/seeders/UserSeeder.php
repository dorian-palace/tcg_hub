<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@tcghub.com',
            'password' => bcrypt('password'),
            'address' => '1 Rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75001',
            'country' => 'France',
            'latitude' => 48.8699,
            'longitude' => 2.3326,
            'bio' => 'Administrateur du site TCG Hub',
        ]);

        // Créer un utilisateur organisateur
        \App\Models\User::create([
            'name' => 'Organisateur',
            'email' => 'organisateur@tcghub.com',
            'password' => bcrypt('password'),
            'address' => '5 Rue Oberkampf',
            'city' => 'Paris',
            'postal_code' => '75011',
            'country' => 'France',
            'latitude' => 48.8641,
            'longitude' => 2.3694,
            'bio' => 'Organisateur d\'événements TCG',
        ]);

        // Créer un utilisateur joueur
        \App\Models\User::create([
            'name' => 'Joueur',
            'email' => 'joueur@tcghub.com',
            'password' => bcrypt('password'),
            'address' => '8 Rue du Faubourg Saint-Antoine',
            'city' => 'Paris',
            'postal_code' => '75012',
            'country' => 'France',
            'latitude' => 48.8515,
            'longitude' => 2.3725,
            'bio' => 'Joueur passionné de cartes à collectionner',
        ]);
    }
}
