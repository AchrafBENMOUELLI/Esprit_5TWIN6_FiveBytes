<?php

namespace Database\Factories\Drought;

use App\Models\Drought\Restriction;
use App\Models\Drought\ScheduledCut;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduledCutFactory extends Factory
{
    protected $model = ScheduledCut::class;

    public function definition(): array
    {
        $debut = $this->faker->dateTimeBetween('now', '+30 days');
        $fin = clone $debut;
        $fin->modify('+6 hours');

        return [
            'restriction_id' => Restriction::factory(),
            'zone_id' => Zone::factory(),
            'debut' => $debut,
            'fin' => $fin,
            'motif' => $this->faker->sentence(),
        ];
    }
}
