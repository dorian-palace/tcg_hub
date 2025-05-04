<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Game::create([
            'name' => 'Pokémon TCG',
            'publisher' => 'The Pokémon Company',
            'description' => 'Le jeu de cartes à collectionner Pokémon est un jeu de cartes à jouer et à collectionner basé sur la franchise Pokémon.',
            'logo_url' => 'https://www.pokemon.com/static-assets/app/static3/img/og-default-image.jpeg',
            'is_active' => true,
        ]);

        \App\Models\Game::create([
            'name' => 'Magic: The Gathering',
            'publisher' => 'Wizards of the Coast',
            'description' => 'Magic: The Gathering est un jeu de cartes à collectionner créé par Richard Garfield en 1993.',
            'logo_url' => 'https://media.wizards.com/images/magic/daily/features/2014/en_mtgm15_logo_icon_black.png',
            'is_active' => true,
        ]);

        \App\Models\Game::create([
            'name' => 'Yu-Gi-Oh!',
            'publisher' => 'Konami',
            'description' => 'Yu-Gi-Oh! est un jeu de cartes à collectionner basé sur le manga Yu-Gi-Oh!',
            'logo_url' => 'https://www.konami.com/yugioh/duel_links/images/common/ogp.png',
            'is_active' => true,
        ]);

        \App\Models\Game::create([
            'name' => 'One Piece Card Game',
            'publisher' => 'Bandai',
            'description' => 'Le jeu de cartes One Piece est un jeu de cartes à collectionner basé sur le manga One Piece.',
            'logo_url' => 'https://onepiece-cardgame.com/images/products/products_cat01.png',
            'is_active' => true,
        ]);

        \App\Models\Game::create([
            'name' => 'Dragon Ball Super Card Game',
            'publisher' => 'Bandai',
            'description' => 'Dragon Ball Super Card Game est un jeu de cartes à collectionner basé sur la série Dragon Ball Super.',
            'logo_url' => 'https://www.bandai.com/wp-content/uploads/2022/09/DBS-Shenron-Artwork.jpg',
            'is_active' => true,
        ]);
    }
}
