<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Infrastructure\Zone;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer l'utilisateur test seulement s'il n'existe pas
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Infrastructure & Zones (vérifie avant de seeder)
        if (Zone::count() === 0) {
            $this->call([
                ZoneSeeder::class,
                InfrastructureSeeder::class,
            ]);
        }

        // Quality (échantillons)
        $this->call([
            \Database\Seeders\Quality\QualitySeeder::class,
        ]);
    }
}
