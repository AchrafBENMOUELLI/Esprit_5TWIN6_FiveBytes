<?php

namespace Database\Factories\Quality;

use App\Enums\Quality\AlertLevel;
use App\Models\Quality\QualityAlert;
use App\Models\Quality\WaterSample;
use Illuminate\Database\Eloquent\Factories\Factory;

class QualityAlertFactory extends Factory
{
    protected $model = QualityAlert::class;

    public function definition(): array
    {
        return [
            'water_sample_id' => WaterSample::factory(),
            'niveau' => fake()->randomElement(AlertLevel::cases()),
            'message' => fake()->sentence(),
            'publiee' => fake()->boolean(50),
            'date_resolution' => fake()->optional(30)->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_resolution' => null,
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_resolution' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'publiee' => true,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'publiee' => false,
        ]);
    }

    public function critical(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau' => AlertLevel::Critique,
            'publiee' => true,
            'date_resolution' => null,
        ]);
    }
}
