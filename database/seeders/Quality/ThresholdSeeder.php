<?php

namespace Database\Seeders\Quality;

use App\Enums\Quality\AlertLevel;
use App\Enums\Quality\QualityParameter;
use App\Models\Quality\Threshold;
use Illuminate\Database\Seeder;

class ThresholdSeeder extends Seeder
{
    public function run(): void
    {
        $thresholds = [
            [
                'parametre' => QualityParameter::pH,
                'unite' => 'pH',
                'valeur_min' => 6.5,
                'valeur_max' => 8.5,
                'niveau_alerte' => AlertLevel::Moyen,
            ],
            [
                'parametre' => QualityParameter::ChlorLibre,
                'unite' => 'mg/L',
                'valeur_min' => 0.2,
                'valeur_max' => 2.0,
                'niveau_alerte' => AlertLevel::Eleve,
            ],
            [
                'parametre' => QualityParameter::Turbidite,
                'unite' => 'NTU',
                'valeur_min' => null,
                'valeur_max' => 5.0,
                'niveau_alerte' => AlertLevel::Moyen,
            ],
            [
                'parametre' => QualityParameter::Temperature,
                'unite' => '°C',
                'valeur_min' => 5.0,
                'valeur_max' => 25.0,
                'niveau_alerte' => AlertLevel::Faible,
            ],
            [
                'parametre' => QualityParameter::Nitrates,
                'unite' => 'mg/L',
                'valeur_min' => null,
                'valeur_max' => 50.0,
                'niveau_alerte' => AlertLevel::Eleve,
            ],
            [
                'parametre' => QualityParameter::Nitrites,
                'unite' => 'mg/L',
                'valeur_min' => null,
                'valeur_max' => 0.5,
                'niveau_alerte' => AlertLevel::Critique,
            ],
            [
                'parametre' => QualityParameter::Ammonium,
                'unite' => 'mg/L',
                'valeur_min' => null,
                'valeur_max' => 0.5,
                'niveau_alerte' => AlertLevel::Moyen,
            ],
            [
                'parametre' => QualityParameter::Conductivite,
                'unite' => 'µS/cm',
                'valeur_min' => 50.0,
                'valeur_max' => 2500.0,
                'niveau_alerte' => AlertLevel::Moyen,
            ],
            [
                'parametre' => QualityParameter::ColiformesTotaux,
                'unite' => 'UFC/100mL',
                'valeur_min' => null,
                'valeur_max' => 0.0,
                'niveau_alerte' => AlertLevel::Critique,
            ],
            [
                'parametre' => QualityParameter::EscherichiaColi,
                'unite' => 'UFC/100mL',
                'valeur_min' => null,
                'valeur_max' => 0.0,
                'niveau_alerte' => AlertLevel::Critique,
            ],
        ];

        foreach ($thresholds as $threshold) {
            Threshold::create($threshold);
        }
    }
}
