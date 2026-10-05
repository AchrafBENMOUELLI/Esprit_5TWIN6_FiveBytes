<?php

namespace Database\Seeders;

use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Seeder;

class InfrastructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = Zone::all();

        if ($zones->isEmpty()) {
            $this->command->warn('⚠️  Aucune zone trouvée. Exécutez ZoneSeeder d\'abord.');
            return;
        }

        $infrastructures = [
            // Tunis Centre-Ville
            [
                'nom' => 'Station de pompage Centre-Ville',
                'type' => 'station_pompage',
                'materiau' => 'béton_armé',
                'date_installation' => '2015-03-15',
                'capacite' => 5000.00,
                'latitude' => 36.8115,
                'longitude' => 10.1785,
                'statut' => 'operationnel',
                'score_risque' => 2.5,
                'zone_id' => $zones->where('commune', 'Tunis')->first()->id,
            ],
            [
                'nom' => 'Réservoir El Menzah',
                'type' => 'reservoir',
                'materiau' => 'acier',
                'date_installation' => '2018-06-20',
                'capacite' => 12000.00,
                'latitude' => 36.8345,
                'longitude' => 10.1625,
                'statut' => 'operationnel',
                'score_risque' => 1.8,
                'zone_id' => $zones->where('commune', 'Tunis')->first()->id,
            ],
            
            // La Marsa
            [
                'nom' => 'Canalisation principale Marsa Nord',
                'type' => 'canalisation',
                'materiau' => 'pvc',
                'date_installation' => '2012-09-10',
                'capacite' => 800.00,
                'latitude' => 36.8855,
                'longitude' => 10.3310,
                'statut' => 'maintenance_requise',
                'score_risque' => 6.5,
                'zone_id' => $zones->where('commune', 'La Marsa')->first()->id,
            ],
            [
                'nom' => 'Station de traitement Gammarth',
                'type' => 'station_traitement',
                'materiau' => 'béton_armé',
                'date_installation' => '2019-11-05',
                'capacite' => 8000.00,
                'latitude' => 36.9025,
                'longitude' => 10.3445,
                'statut' => 'operationnel',
                'score_risque' => 1.2,
                'zone_id' => $zones->where('commune', 'La Marsa')->first()->id,
            ],

            // Ariana
            [
                'nom' => 'Réservoir Ariana Supérieur',
                'type' => 'reservoir',
                'materiau' => 'béton_armé',
                'date_installation' => '2010-04-12',
                'capacite' => 15000.00,
                'latitude' => 36.8715,
                'longitude' => 10.2015,
                'statut' => 'operationnel',
                'score_risque' => 3.2,
                'zone_id' => $zones->where('commune', 'Ariana')->first()->id,
            ],
            [
                'nom' => 'Canalisation Ennasr',
                'type' => 'canalisation',
                'materiau' => 'fonte',
                'date_installation' => '2008-02-28',
                'capacite' => 1200.00,
                'latitude' => 36.8555,
                'longitude' => 10.1825,
                'statut' => 'hors_service',
                'score_risque' => 8.9,
                'zone_id' => $zones->where('commune', 'Ariana')->first()->id,
            ],

            // Sousse
            [
                'nom' => 'Station de dessalement Sousse',
                'type' => 'station_traitement',
                'materiau' => 'béton_armé',
                'date_installation' => '2020-08-15',
                'capacite' => 20000.00,
                'latitude' => 35.8335,
                'longitude' => 10.6125,
                'statut' => 'operationnel',
                'score_risque' => 0.8,
                'zone_id' => $zones->where('commune', 'Sousse')->first()->id,
            ],
            [
                'nom' => 'Pompage Sousse Port',
                'type' => 'station_pompage',
                'materiau' => 'acier',
                'date_installation' => '2017-05-22',
                'capacite' => 6000.00,
                'latitude' => 35.8185,
                'longitude' => 10.6445,
                'statut' => 'operationnel',
                'score_risque' => 2.1,
                'zone_id' => $zones->where('commune', 'Sousse')->first()->id,
            ],

            // Sfax
            [
                'nom' => 'Réservoir Sfax Centre',
                'type' => 'reservoir',
                'materiau' => 'béton_armé',
                'date_installation' => '2013-01-10',
                'capacite' => 18000.00,
                'latitude' => 34.7465,
                'longitude' => 10.7525,
                'statut' => 'operationnel',
                'score_risque' => 3.8,
                'zone_id' => $zones->where('commune', 'Sfax')->first()->id,
            ],
            [
                'nom' => 'Canalisation Avenue Habib Bourguiba',
                'type' => 'canalisation',
                'materiau' => 'pvc',
                'date_installation' => '2011-07-18',
                'capacite' => 950.00,
                'latitude' => 34.7385,
                'longitude' => 10.7655,
                'statut' => 'maintenance_requise',
                'score_risque' => 5.6,
                'zone_id' => $zones->where('commune', 'Sfax')->first()->id,
            ],

            // Monastir
            [
                'nom' => 'Station de traitement Monastir',
                'type' => 'station_traitement',
                'materiau' => 'béton_armé',
                'date_installation' => '2016-10-08',
                'capacite' => 7500.00,
                'latitude' => 35.7825,
                'longitude' => 10.8195,
                'statut' => 'operationnel',
                'score_risque' => 1.5,
                'zone_id' => $zones->where('commune', 'Monastir')->first()->id,
            ],
            [
                'nom' => 'Pompage Zone Touristique',
                'type' => 'station_pompage',
                'materiau' => 'acier',
                'date_installation' => '2019-03-25',
                'capacite' => 4500.00,
                'latitude' => 35.7685,
                'longitude' => 10.8385,
                'statut' => 'operationnel',
                'score_risque' => 1.9,
                'zone_id' => $zones->where('commune', 'Monastir')->first()->id,
            ],
        ];

        foreach ($infrastructures as $infrastructure) {
            Infrastructure::create($infrastructure);
        }

        $this->command->info('✅ 12 infrastructures créées (réservoirs, canalisations, stations)');
    }
}
