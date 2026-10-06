<?php

namespace Database\Factories\Drought;

use App\Models\Drought\Restriction;
use App\Models\Infrastructure\Zone;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestrictionFactory extends Factory
{
    protected $model = Restriction::class;

    public function definition(): array
    {
        $debut = $this->faker->dateTimeBetween('-10 days', 'now');
        $fin = clone $debut;
        $fin->modify('+30 days');

        return [
            'titre' => $this->faker->sentence(3),
            'niveau' => $this->faker->randomElement(['vigilance', 'alerte', 'crise']),
            'description' => $this->faker->paragraph(),
            'date_debut' => $debut,
            'date_fin' => $fin,
            'zone_id' => Zone::factory(),
            'cree_par' => User::factory(),
        ];
    }
}
