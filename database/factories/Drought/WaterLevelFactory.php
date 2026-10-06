<?php

namespace Database\Factories\Drought;

use App\Models\Drought\WaterLevel;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaterLevelFactory extends Factory
{
    protected $model = WaterLevel::class;

    public function definition(): array
    {
        return [
            'zone_id' => Zone::factory(),
            'source' => $this->faker->randomElement(['reservoir', 'nappe', 'barrage']),
            'niveau_pourcentage' => $this->faker->numberBetween(30, 95),
            'volume_m3' => $this->faker->numberBetween(10000, 500000),
            'date_releve' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
