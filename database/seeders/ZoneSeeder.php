<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'nom' => 'Centre-Ville',
                'commune' => 'Tunis',
                'code_postal' => '1000',
                'population' => 180000,
                'latitude' => 36.8065,
                'longitude' => 10.1815,
            ],
            [
                'nom' => 'La Marsa',
                'commune' => 'La Marsa',
                'code_postal' => '2070',
                'population' => 95000,
                'latitude' => 36.8785,
                'longitude' => 10.3250,
            ],
            [
                'nom' => 'Ariana Ville',
                'commune' => 'Ariana',
                'code_postal' => '2080',
                'population' => 115000,
                'latitude' => 36.8625,
                'longitude' => 10.1950,
            ],
            [
                'nom' => 'Sousse Nord',
                'commune' => 'Sousse',
                'code_postal' => '4000',
                'population' => 220000,
                'latitude' => 35.8256,
                'longitude' => 10.6369,
            ],
            [
                'nom' => 'Sfax Ville',
                'commune' => 'Sfax',
                'code_postal' => '3000',
                'population' => 280000,
                'latitude' => 34.7406,
                'longitude' => 10.7603,
            ],
            [
                'nom' => 'Monastir Centre',
                'commune' => 'Monastir',
                'code_postal' => '5000',
                'population' => 93000,
                'latitude' => 35.7774,
                'longitude' => 10.8269,
            ],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }

        $this->command->info('✅ 6 zones géographiques créées');
    }
}
