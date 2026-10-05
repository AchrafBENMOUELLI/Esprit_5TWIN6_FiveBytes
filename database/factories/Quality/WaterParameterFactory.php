<?php

namespace Database\Factories\Quality;

use App\Models\Quality\Threshold;
use App\Models\Quality\WaterParameter;
use App\Models\Quality\WaterSample;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaterParameterFactory extends Factory
{
    protected $model = WaterParameter::class;

    public function definition(): array
    {
        $threshold = Threshold::inRandomOrder()->first() ?? Threshold::factory()->create();
        $value = fake()->randomFloat(3, 0, 20);
        
        $exceeded = false;
        if ($threshold->valeur_min !== null && $value < (float) $threshold->valeur_min) {
            $exceeded = true;
        }
        if ($threshold->valeur_max !== null && $value > (float) $threshold->valeur_max) {
            $exceeded = true;
        }

        return [
            'water_sample_id' => WaterSample::factory(),
            'threshold_id' => $threshold->id,
            'valeur' => $value,
            'depasse_seuil' => $exceeded,
        ];
    }

    public function withinThreshold(): static
    {
        return $this->state(function (array $attributes) {
            $threshold = Threshold::find($attributes['threshold_id']) 
                ?? Threshold::inRandomOrder()->first() 
                ?? Threshold::factory()->create();
            
            $min = $threshold->valeur_min ? (float) $threshold->valeur_min : 0;
            $max = $threshold->valeur_max ? (float) $threshold->valeur_max : 100;
            
            return [
                'valeur' => fake()->randomFloat(3, $min + 0.1, $max - 0.1),
                'depasse_seuil' => false,
            ];
        });
    }

    public function exceeded(): static
    {
        return $this->state(function (array $attributes) {
            $threshold = Threshold::find($attributes['threshold_id']) 
                ?? Threshold::inRandomOrder()->first() 
                ?? Threshold::factory()->create();
            
            $max = $threshold->valeur_max ? (float) $threshold->valeur_max : 100;
            
            return [
                'valeur' => fake()->randomFloat(3, $max + 0.1, $max + 10),
                'depasse_seuil' => true,
            ];
        });
    }
}
