<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'nom' => 'Centre-Ville',
                'commune' => 'Tunis',
                'code_postal' => '1000',
                'population' => 125000,
                'latitude' => 36.8065,
                'longitude' => 10.1815,
            ],
            [
                'nom' => 'La Marsa',
                'commune' => 'La Marsa',
                'code_postal' => '2070',
                'population' => 92876,
                'latitude' => 36.8783,
                'longitude' => 10.3250,
            ],
            [
                'nom' => 'Carthage',
                'commune' => 'Carthage',
                'code_postal' => '2016',
                'population' => 21276,
                'latitude' => 36.8531,
                'longitude' => 10.3231,
            ],
            [
                'nom' => 'Ariana Ville',
                'commune' => 'Ariana',
                'code_postal' => '2080',
                'population' => 97687,
                'latitude' => 36.8625,
                'longitude' => 10.1956,
            ],
            [
                'nom' => 'Ben Arous',
                'commune' => 'Ben Arous',
                'code_postal' => '2013',
                'population' => 88322,
                'latitude' => 36.7542,
                'longitude' => 10.2189,
            ],
            [
                'nom' => 'Manouba',
                'commune' => 'Manouba',
                'code_postal' => '2010',
                'population' => 51320,
                'latitude' => 36.8083,
                'longitude' => 10.0953,
            ],
            [
                'nom' => 'Sfax Medina',
                'commune' => 'Sfax',
                'code_postal' => '3000',
                'population' => 145000,
                'latitude' => 34.7406,
                'longitude' => 10.7603,
            ],
            [
                'nom' => 'Sousse Ville',
                'commune' => 'Sousse',
                'code_postal' => '4000',
                'population' => 221530,
                'latitude' => 35.8254,
                'longitude' => 10.6364,
            ],
            [
                'nom' => 'Bizerte Nord',
                'commune' => 'Bizerte',
                'code_postal' => '7000',
                'population' => 142966,
                'latitude' => 37.2746,
                'longitude' => 9.8739,
            ],
            [
                'nom' => 'Nabeul Centre',
                'commune' => 'Nabeul',
                'code_postal' => '8000',
                'population' => 73128,
                'latitude' => 36.4561,
                'longitude' => 10.7356,
            ],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
