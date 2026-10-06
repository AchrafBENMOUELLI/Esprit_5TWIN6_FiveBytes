<?php

namespace Database\Factories\Infrastructure;

use App\Models\Infrastructure\Maintenance;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    protected $model = Maintenance::class;

    private array $types = ['preventive', 'corrective', 'urgence'];

    private array $statuts = ['planifiee', 'en_cours', 'terminee', 'annulee'];

    private array $descriptions = [
        'Inspection annuelle et contrôle général des équipements.',
        'Remplacement des joints et garnitures défectueux.',
        'Nettoyage et désinfection du réservoir.',
        'Réparation fuite sur canalisation principale.',
        'Vérification du débit et calibration du compteur.',
        'Maintenance préventive de la station de pompage.',
        'Contrôle étanchéité et soudure des raccords.',
        'Remplacement pompe défectueuse en urgence.',
        'Inspection qualité eau au point de captage.',
        'Révision complète du système de filtration.',
    ];

    public function definition(): array
    {
        return [
            'infrastructure_id' => Infrastructure::inRandomOrder()->first()?->id ?? Infrastructure::factory(),
            'technicien_id'     => User::inRandomOrder()->first()?->id,
            'type'              => $this->faker->randomElement($this->types),
            'description'       => $this->faker->randomElement($this->descriptions),
            'date_intervention' => $this->faker->dateTimeBetween('-1 year', '+3 months')->format('Y-m-d'),
            'cout'              => $this->faker->numberBetween(5000, 150000),
            'statut'            => $this->faker->randomElement($this->statuts),
        ];
    }

    public function planifiee(): static
    {
        return $this->state([
            'statut'            => 'planifiee',
            'date_intervention' => $this->faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
        ]);
    }

    public function terminee(): static
    {
        return $this->state([
            'statut'            => 'terminee',
            'date_intervention' => $this->faker->dateTimeBetween('-1 year', '-1 day')->format('Y-m-d'),
        ]);
    }
}
