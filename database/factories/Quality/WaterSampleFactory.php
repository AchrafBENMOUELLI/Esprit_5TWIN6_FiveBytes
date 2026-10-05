<?php

namespace Database\Factories\Quality;

use App\Enums\Quality\ResultatGlobal;
use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use App\Models\Quality\WaterSample;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaterSampleFactory extends Factory
{
    protected $model = WaterSample::class;

    public function definition(): array
    {
        return [
            'zone_id' => Zone::factory(),
            'infrastructure_id' => fake()->boolean(70) ? Infrastructure::factory() : null,
            'preleve_par' => User::factory(),
            'date_prelevement' => fake()->dateTimeBetween('-3 months', 'now'),
            'resultat_global' => fake()->randomElement(ResultatGlobal::cases()),
            'resume_ia' => fake()->optional()->paragraph(),
        ];
    }

    public function conforme(): static
    {
        return $this->state(fn (array $attributes) => [
            'resultat_global' => ResultatGlobal::Conforme,
        ]);
    }

    public function nonConforme(): static
    {
        return $this->state(fn (array $attributes) => [
            'resultat_global' => ResultatGlobal::NonConforme,
        ]);
    }

    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_prelevement' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
