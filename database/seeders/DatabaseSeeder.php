<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appel des seeders dans l'ordre
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
            EventSeeder::class,
            CommentSeeder::class,
            ForumSeeder::class,
        ]);
    }
}
