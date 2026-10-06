<?php

namespace Database\Factories;

use App\Models\Incident\Incident;
use App\Models\Incident\IncidentPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident\IncidentPhoto>
 */
class IncidentPhotoFactory extends Factory
{
    protected $model = IncidentPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'incident_id' => Incident::factory(),
            'chemin_fichier' => 'incidents/photos/' . fake()->uuid() . '.jpg',
            'legende' => fake()->optional(0.7)->sentence(),
        ];
    }
}
