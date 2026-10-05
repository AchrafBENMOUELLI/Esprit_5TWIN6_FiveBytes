<?php

namespace App\Services\Quality;

use App\Enums\Quality\ResultatGlobal;
use App\Models\Quality\Threshold;
use App\Models\Quality\WaterSample;
use Illuminate\Support\Facades\DB;

class WaterSampleService
{
    public function store(array $data, int $userId): WaterSample
    {
        return DB::transaction(function () use ($data, $userId) {
            $sample = WaterSample::create([
                'zone_id' => $data['zone_id'],
                'infrastructure_id' => $data['infrastructure_id'] ?? null,
                'preleve_par' => $userId,
                'date_prelevement' => $data['date_prelevement'],
            ]);

            $this->processParameters($sample, $data['parameters']);

            return $sample;
        });
    }

    public function update(WaterSample $sample, array $data): WaterSample
    {
        return DB::transaction(function () use ($sample, $data) {
            $sample->update([
                'zone_id' => $data['zone_id'],
                'infrastructure_id' => $data['infrastructure_id'] ?? null,
                'date_prelevement' => $data['date_prelevement'],
            ]);

            // Supprimer les anciens paramètres et alertes
            $sample->parameters()->delete();
            $sample->alerts()->delete();

            $this->processParameters($sample, $data['parameters']);

            return $sample->fresh();
        });
    }

    private function processParameters(WaterSample $sample, array $parameters): void
    {
        $thresholds = Threshold::whereIn('id', array_column($parameters, 'threshold_id'))
            ->get()
            ->keyBy('id');

        $hasExceeded = false;

        foreach ($parameters as $row) {
            $threshold = $thresholds[$row['threshold_id']];
            $value = (float) $row['valeur'];
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
                ]);
            }
        }

        $sample->update([
            'resultat_global' => $hasExceeded
                ? ResultatGlobal::NonConforme
                : ResultatGlobal::Conforme,
        ]);
    }

    private function isExceeded(Threshold $threshold, float $value): bool
    {
        return ($threshold->valeur_min !== null && $value < (float) $threshold->valeur_min)
            || ($threshold->valeur_max !== null && $value > (float) $threshold->valeur_max);
    }
}
