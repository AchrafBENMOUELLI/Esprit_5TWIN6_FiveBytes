<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InfrastructureSeeder extends Seeder
{
    public function run(): void
    {
        $zones = Zone::all();
        
        if ($zones->isEmpty()) {
            $this->command->warn('Aucune zone trouvée. Veuillez exécuter ZoneSeeder d\'abord.');
            return;
        }

        $infrastructures = [
            // Stations de traitement
            [
                'nom' => 'Station de traitement Chotrana',
                'type' => 'Station de traitement',
                'materiau' => 'Béton armé',
                'date_installation' => '2015-06-15',
                'capacite' => 250000.00,
                'latitude' => 36.8065,
                'longitude' => 10.1815,
                'statut' => 'Opérationnel',
                'score_risque' => 25.50,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Station de traitement La Marsa',
                'type' => 'Station de traitement',
                'materiau' => 'Béton',
                'date_installation' => '2010-03-20',
                'capacite' => 180000.00,
                'latitude' => 36.8783,
                'longitude' => 10.3250,
                'statut' => 'Opérationnel',
                'score_risque' => 30.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Station de traitement Sfax',
                'type' => 'Station de traitement',
                'materiau' => 'Béton armé',
                'date_installation' => '2018-09-10',
                'capacite' => 320000.00,
                'latitude' => 34.7406,
                'longitude' => 10.7603,
                'statut' => 'Opérationnel',
                'score_risque' => 18.75,
                'zone_id' => $zones->random()->id,
            ],

            // Réservoirs
            [
                'nom' => 'Réservoir Belvédère',
                'type' => 'Réservoir',
                'materiau' => 'Acier inoxydable',
                'date_installation' => '2012-11-05',
                'capacite' => 50000.00,
                'latitude' => 36.8125,
                'longitude' => 10.1625,
                'statut' => 'Opérationnel',
                'score_risque' => 22.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Réservoir Carthage',
                'type' => 'Réservoir',
                'materiau' => 'Béton',
                'date_installation' => '2008-07-18',
                'capacite' => 35000.00,
                'latitude' => 36.8531,
                'longitude' => 10.3231,
                'statut' => 'En maintenance',
                'score_risque' => 45.50,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Réservoir Ariana',
                'type' => 'Réservoir',
                'materiau' => 'Acier',
                'date_installation' => '2014-04-22',
                'capacite' => 42000.00,
                'latitude' => 36.8625,
                'longitude' => 10.1956,
                'statut' => 'Opérationnel',
                'score_risque' => 28.30,
                'zone_id' => $zones->random()->id,
            ],

            // Canalisations principales
            [
                'nom' => 'Canalisation Centre-Nord',
                'type' => 'Canalisation principale',
                'materiau' => 'PVC',
                'date_installation' => '2016-02-10',
                'capacite' => 15000.00,
                'latitude' => 36.8200,
                'longitude' => 10.1900,
                'statut' => 'Opérationnel',
                'score_risque' => 35.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Canalisation Tunis-Marsa',
                'type' => 'Canalisation principale',
                'materiau' => 'Acier galvanisé',
                'date_installation' => '2005-12-01',
                'capacite' => 18000.00,
                'latitude' => 36.8400,
                'longitude' => 10.2500,
                'statut' => 'Vétuste',
                'score_risque' => 68.90,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Canalisation Sousse-Est',
                'type' => 'Canalisation principale',
                'materiau' => 'PEHD',
                'date_installation' => '2019-05-15',
                'capacite' => 12000.00,
                'latitude' => 35.8254,
                'longitude' => 10.6364,
                'statut' => 'Opérationnel',
                'score_risque' => 15.20,
                'zone_id' => $zones->random()->id,
            ],

            // Pompes
            [
                'nom' => 'Pompe Ben Arous P1',
                'type' => 'Pompe',
                'materiau' => 'Fonte',
                'date_installation' => '2017-08-30',
                'capacite' => 8000.00,
                'latitude' => 36.7542,
                'longitude' => 10.2189,
                'statut' => 'Opérationnel',
                'score_risque' => 20.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Pompe Manouba P2',
                'type' => 'Pompe',
                'materiau' => 'Acier inoxydable',
                'date_installation' => '2013-03-12',
                'capacite' => 6500.00,
                'latitude' => 36.8083,
                'longitude' => 10.0953,
                'statut' => 'En maintenance',
                'score_risque' => 52.30,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Pompe Bizerte Nord P3',
                'type' => 'Pompe',
                'materiau' => 'Fonte',
                'date_installation' => '2020-01-20',
                'capacite' => 7200.00,
                'latitude' => 37.2746,
                'longitude' => 9.8739,
                'statut' => 'Opérationnel',
                'score_risque' => 12.50,
                'zone_id' => $zones->random()->id,
            ],

            // Stations de pompage
            [
                'nom' => 'Station de pompage Nabeul',
                'type' => 'Station de pompage',
                'materiau' => 'Béton armé',
                'date_installation' => '2011-10-08',
                'capacite' => 25000.00,
                'latitude' => 36.4561,
                'longitude' => 10.7356,
                'statut' => 'Opérationnel',
                'score_risque' => 38.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Station de pompage Ariana-Est',
                'type' => 'Station de pompage',
                'materiau' => 'Béton',
                'date_installation' => '2009-06-25',
                'capacite' => 22000.00,
                'latitude' => 36.8700,
                'longitude' => 10.2100,
                'statut' => 'Vétuste',
                'score_risque' => 72.40,
                'zone_id' => $zones->random()->id,
            ],

            // Forages
            [
                'nom' => 'Forage Mornag',
                'type' => 'Forage',
                'materiau' => 'Acier',
                'date_installation' => '2007-04-15',
                'capacite' => 5000.00,
                'latitude' => 36.6833,
                'longitude' => 10.2667,
                'statut' => 'Opérationnel',
                'score_risque' => 40.00,
                'zone_id' => $zones->random()->id,
            ],
            [
                'nom' => 'Forage Grombalia',
                'type' => 'Forage',
                'materiau' => 'PVC renforcé',
                'date_installation' => '2015-11-30',
                'capacite' => 4500.00,
                'latitude' => 36.6000,
                'longitude' => 10.5000,
                'statut' => 'Opérationnel',
                'score_risque' => 25.60,
                'zone_id' => $zones->random()->id,
            ],
        ];

        foreach ($infrastructures as $infrastructure) {
            Infrastructure::create($infrastructure);
        }

        $this->command->info('✓ ' . count($infrastructures) . ' infrastructures créées avec succès!');
    }
}
