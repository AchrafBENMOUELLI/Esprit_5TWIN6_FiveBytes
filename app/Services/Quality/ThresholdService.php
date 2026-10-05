<?php

namespace App\Services\Quality;

use App\Models\Quality\Threshold;

class ThresholdService
{
    public function store(array $data): Threshold
    {
        return Threshold::create([
            'parametre' => $data['parametre'],
            'unite' => $data['unite'],
            'valeur_min' => $data['valeur_min'] ?? null,
            'valeur_max' => $data['valeur_max'] ?? null,
            'niveau_alerte' => $data['niveau_alerte'],
        ]);
    }

    public function update(Threshold $threshold, array $data): Threshold
    {
        $threshold->update([
            'parametre' => $data['parametre'],
            'unite' => $data['unite'],
            'valeur_min' => $data['valeur_min'] ?? null,
            'valeur_max' => $data['valeur_max'] ?? null,
            'niveau_alerte' => $data['niveau_alerte'],
        ]);

        return $threshold->fresh();
    }
}
