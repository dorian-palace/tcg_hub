<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'name' => 'Pokémon Trading Card Game',
                'publisher' => 'The Pokémon Company',
                'description' => 'Le jeu de cartes à collectionner Pokémon est un jeu de cartes basé sur la franchise Pokémon. Les joueurs construisent des decks de 60 cartes et s\'affrontent en utilisant des Pokémon, des Dresseurs et des Énergies.',
                'logo_url' => 'https://www.pokemon.com/static-assets/app/static3/img/og-default-image.jpeg',
                'is_active' => true,
            ],
            [
                'name' => 'Yu-Gi-Oh! Trading Card Game',
                'publisher' => 'Konami',
                'description' => 'Le jeu de cartes Yu-Gi-Oh! est un jeu de cartes à collectionner basé sur la franchise Yu-Gi-Oh!. Les joueurs construisent des decks de 40 à 60 cartes et s\'affrontent en utilisant des monstres, des sorts et des pièges.',
                'logo_url' => 'https://www.konami.com/yugioh/duel_links/images/common/ogp.png',
                'is_active' => true,
            ],
            [
                'name' => 'One Piece Card Game',
                'publisher' => 'Bandai',
                'description' => 'Le jeu de cartes One Piece est un jeu de cartes à collectionner basé sur la franchise One Piece. Les joueurs construisent des decks de 50 cartes et s\'affrontent en utilisant des personnages, des événements et des don.',
                'logo_url' => 'https://onepiece-cardgame.com/images/products/products_cat01.png',
                'is_active' => true,
            ],
            [
                'name' => 'Magic: The Gathering',
                'publisher' => 'Wizards of the Coast',
                'description' => 'Magic: The Gathering est le premier jeu de cartes à collectionner moderne. Les joueurs construisent des decks de 60 cartes minimum et s\'affrontent en utilisant des sorts, des créatures et des terrains.',
                'logo_url' => 'https://media.wizards.com/images/magic/daily/features/2014/en_mtgm15_logo_icon_black.png',
                'is_active' => true,
            ],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
