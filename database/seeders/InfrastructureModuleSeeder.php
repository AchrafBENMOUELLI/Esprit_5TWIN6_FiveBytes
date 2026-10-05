<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;

class InfrastructureModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🗺️  Seeding Zones and Infrastructures...');
        
        // Créer 10 zones
        $zones = [
            ['nom' => 'Zone Nord', 'commune' => 'Lille', 'code_postal' => '59000', 'population' => 50000, 'latitude' => 50.6292, 'longitude' => 3.0573],
            ['nom' => 'Zone Sud', 'commune' => 'Marseille', 'code_postal' => '13000', 'population' => 80000, 'latitude' => 43.2965, 'longitude' => 5.3698],
            ['nom' => 'Zone Est', 'commune' => 'Strasbourg', 'code_postal' => '67000', 'population' => 45000, 'latitude' => 48.5734, 'longitude' => 7.7521],
            ['nom' => 'Zone Ouest', 'commune' => 'Nantes', 'code_postal' => '44000', 'population' => 55000, 'latitude' => 47.2184, 'longitude' => -1.5536],
            ['nom' => 'Zone Centre', 'commune' => 'Lyon', 'code_postal' => '69000', 'population' => 70000, 'latitude' => 45.7640, 'longitude' => 4.8357],
            ['nom' => 'Zone Industrielle', 'commune' => 'Toulouse', 'code_postal' => '31000', 'population' => 35000, 'latitude' => 43.6047, 'longitude' => 1.4442],
            ['nom' => 'Zone Résidentielle', 'commune' => 'Nice', 'code_postal' => '06000', 'population' => 60000, 'latitude' => 43.7102, 'longitude' => 7.2620],
            ['nom' => 'Zone Rurale', 'commune' => 'Bordeaux', 'code_postal' => '33000', 'population' => 20000, 'latitude' => 44.8378, 'longitude' => -0.5792],
            ['nom' => 'Zone Périurbaine', 'commune' => 'Montpellier', 'code_postal' => '34000', 'population' => 40000, 'latitude' => 43.6108, 'longitude' => 3.8767],
            ['nom' => 'Zone Côtière', 'commune' => 'Rennes', 'code_postal' => '35000', 'population' => 30000, 'latitude' => 48.1173, 'longitude' => -1.6778],
        ];
        
        foreach ($zones as $zoneData) {
            Zone::create($zoneData);
        }
        
        $this->command->info('✅ Created 10 zones');
        
        // Créer 30 infrastructures réparties dans les zones
        $allZones = Zone::all();
        $infrastructureTypes = ['canalisation', 'réservoir', 'station_pompage', 'compteur', 'captage'];
        $materiaux = ['PVC', 'Fonte', 'Acier', 'Béton', 'PEHD'];
        $statuts = ['actif', 'maintenance', 'hors_service', 'en_construction'];
        
        foreach ($allZones as $zone) {
            // 3 infrastructures par zone
            for ($i = 0; $i < 3; $i++) {
                Infrastructure::create([
                    'nom' => ucfirst(fake()->randomElement($infrastructureTypes)) . ' ' . $zone->nom . ' ' . ($i + 1),
                    'type' => fake()->randomElement($infrastructureTypes),
                    'materiau' => fake()->randomElement($materiaux),
                    'date_installation' => fake()->dateTimeBetween('-20 years', '-1 year'),
                    'capacite' => fake()->randomFloat(2, 100, 10000),
                    'latitude' => $zone->latitude + (fake()->randomFloat(4, -0.05, 0.05)),
                    'longitude' => $zone->longitude + (fake()->randomFloat(4, -0.05, 0.05)),
                    'statut' => fake()->randomElement($statuts),
                    'score_risque' => fake()->randomFloat(2, 0, 10),
                    'zone_id' => $zone->id,
                ]);
            }
        }
        
        $this->command->info('✅ Created 30 infrastructures');
    }
}
