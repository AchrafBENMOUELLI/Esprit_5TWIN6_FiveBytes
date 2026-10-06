<?php

namespace Database\Factories\Infrastructure;

use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->word() . ' Zone',
            'commune' => $this->faker->city(),
            'code_postal' => $this->faker->postcode(),
            'population' => $this->faker->numberBetween(5000, 500000),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
