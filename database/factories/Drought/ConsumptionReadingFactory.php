<?php

namespace Database\Factories\Drought;

use App\Models\Drought\ConsumptionReading;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumptionReadingFactory extends Factory
{
    protected $model = ConsumptionReading::class;

    public function definition(): array
    {
        $debut = $this->faker->dateTimeBetween('-30 days', '-1 days');
        $fin = clone $debut;
        $fin->modify('+7 days');

        return [
            'zone_id' => Zone::factory(),
            'volume_m3' => $this->faker->numberBetween(5000, 50000),
            'periode_debut' => $debut,
            'periode_fin' => $fin,
            'prevision_ia' => $this->faker->sentence(),
        ];
    }
}
