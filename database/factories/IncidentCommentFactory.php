<?php

namespace Database\Factories;

use App\Models\Incident\Incident;
use App\Models\Incident\IncidentComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident\IncidentComment>
 */
class IncidentCommentFactory extends Factory
{
    protected $model = IncidentComment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'incident_id' => Incident::factory(),
            'user_id' => User::factory(),
            'contenu' => fake()->paragraph(),
            'interne' => fake()->boolean(30), // 30% de chance d'être un commentaire interne
        ];
    }

    /**
     * Indique que le commentaire est interne
     */
    public function interne(): static
    {
        return $this->state(fn (array $attributes) => [
            'interne' => true,
        ]);
    }

    /**
     * Indique que le commentaire est public
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'interne' => false,
        ]);
    }
}
