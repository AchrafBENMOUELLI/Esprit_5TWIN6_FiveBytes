<?php

namespace Database\Factories\Quality;

use App\Enums\Quality\AlertLevel;
use App\Enums\Quality\QualityParameter;
use App\Models\Quality\Threshold;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThresholdFactory extends Factory
{
    protected $model = Threshold::class;

    public function definition(): array
    {
        return [
            'parametre' => fake()->randomElement(QualityParameter::cases()),
            'unite' => fake()->randomElement(['mg/L', 'µg/L', 'pH', '°C', 'NTU']),
            'valeur_min' => fake()->randomFloat(3, 0, 5),
            'valeur_max' => fake()->randomFloat(3, 6, 15),
            'niveau_alerte' => fake()->randomElement(AlertLevel::cases()),
        ];
    }

    public function ph(): static
    {
        return $this->state(fn (array $attributes) => [
            'parametre' => QualityParameter::pH,
            'unite' => 'pH',
            'valeur_min' => 6.5,
            'valeur_max' => 8.5,
            'niveau_alerte' => AlertLevel::Moyen,
        ]);
    }

    public function chlore(): static
    {
        return $this->state(fn (array $attributes) => [
            'parametre' => QualityParameter::ChlorLibre,
            'unite' => 'mg/L',
            'valeur_min' => 0.2,
            'valeur_max' => 2.0,
            'niveau_alerte' => AlertLevel::Eleve,
        ]);
    }

    public function turbidite(): static
    {
        return $this->state(fn (array $attributes) => [
            'parametre' => QualityParameter::Turbidite,
            'unite' => 'NTU',
            'valeur_min' => null,
            'valeur_max' => 5.0,
            'niveau_alerte' => AlertLevel::Moyen,
        ]);
    }
}
