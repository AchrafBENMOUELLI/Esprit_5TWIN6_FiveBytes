<?php

namespace Database\Seeders\Quality;

use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use App\Models\Quality\Threshold;
use App\Models\Quality\WaterSample;
use App\Models\User;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        // Créer les seuils seulement s'ils n'existent pas
        if (Threshold::count() === 0) {
            $this->call(ThresholdSeeder::class);
        }

        // Vérifier qu'il y a des zones et utilisateurs
        if (Zone::count() === 0 || User::count() === 0) {
            $this->command->warn('Pas de zones ou d\'utilisateurs. Créez-les d\'abord avant de seeder Quality.');
            return;
        }

        $zones = Zone::all();
        $users = User::all();
        $infrastructures = Infrastructure::all();
        $thresholds = Threshold::all()->take(5); // Prendre 5 seuils aléatoires

        // Créer 20 échantillons d'eau
        foreach (range(1, 20) as $i) {
            $sample = WaterSample::create([
                'zone_id' => $zones->random()->id,
                'infrastructure_id' => $infrastructures->isNotEmpty() && rand(0, 1) ? $infrastructures->random()->id : null,
                'preleve_par' => $users->random()->id,
                'date_prelevement' => now()->subDays(rand(1, 90)),
            ]);

            $hasExceeded = false;

            // Ajouter 3-5 paramètres par échantillon
            $selectedThresholds = $thresholds->random(rand(3, min(5, $thresholds->count())));
            
            foreach ($selectedThresholds as $threshold) {
                $value = $this->generateValue($threshold);
                $exceeded = $this->isExceeded($threshold, $value);

                $sample->parameters()->create([
                    'threshold_id' => $threshold->id,
                    'valeur' => $value,
                    'depasse_seuil' => $exceeded,
                ]);

                if ($exceeded) {
                    $hasExceeded = true;

                    $sample->alerts()->create([
                        'niveau' => $threshold->niveau_alerte,
                        'message' => "{$threshold->parametre->label()} hors seuil : {$value} {$threshold->unite}",
                        'publiee' => rand(0, 1),
                        'date_resolution' => rand(0, 1) ? now()->addDays(rand(1, 30)) : null,
                    ]);
                }
            }

            $sample->update([
                'resultat_global' => $hasExceeded ? 'non_conforme' : 'conforme',
            ]);
        }

        $this->command->info('Quality module seeded successfully!');
    }

    private function generateValue(Threshold $threshold): float
    {
        $min = $threshold->valeur_min ? (float) $threshold->valeur_min : 0;
        $max = $threshold->valeur_max ? (float) $threshold->valeur_max : 100;

        // 70% de chance de valeur conforme
        if (rand(1, 100) <= 70) {
            return round($min + (($max - $min) * rand(10, 90) / 100), 3);
        }

        // 30% de chance de valeur non conforme
        if (rand(0, 1)) {
            return round($max + rand(1, 50), 3); // Au-dessus du max
        }

        return round($min - rand(1, 5), 3); // En-dessous du min
    }

    private function isExceeded(Threshold $threshold, float $value): bool
    {
        return ($threshold->valeur_min !== null && $value < (float) $threshold->valeur_min)
            || ($threshold->valeur_max !== null && $value > (float) $threshold->valeur_max);
    }
}
