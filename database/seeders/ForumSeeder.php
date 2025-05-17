<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\Game;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $games = Game::all();

        foreach ($games as $game) {
            // Forum général
            Forum::create([
                'name' => 'Général',
                'slug' => 'general',
                'description' => 'Discussions générales sur ' . $game->name,
                'game_id' => $game->id,
                'order' => 1,
                'is_active' => true,
                'category' => 'general'
            ]);

            // Forum stratégie
            Forum::create([
                'name' => 'Stratégie',
                'slug' => 'strategie',
                'description' => 'Partagez vos stratégies et conseils pour ' . $game->name,
                'game_id' => $game->id,
                'order' => 2,
                'is_active' => true,
                'category' => 'strategie'
            ]);

            // Forum collection
            Forum::create([
                'name' => 'Collection',
                'slug' => 'collection',
                'description' => 'Discussions sur les cartes et la collection de ' . $game->name,
                'game_id' => $game->id,
                'order' => 3,
                'is_active' => true,
                'category' => 'echange'
            ]);

            // Forum événements
            Forum::create([
                'name' => 'Événements',
                'slug' => 'evenements',
                'description' => 'Organisez et discutez des événements de ' . $game->name,
                'game_id' => $game->id,
                'order' => 4,
                'is_active' => true,
                'category' => 'evenements'
            ]);
        }
    }
} 