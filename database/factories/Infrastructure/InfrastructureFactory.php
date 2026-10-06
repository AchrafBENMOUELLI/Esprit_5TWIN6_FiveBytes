<?php

namespace Database\Factories\Infrastructure;

use App\Models\Infrastructure\Infrastructure;
use App\Models\Infrastructure\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfrastructureFactory extends Factory
{
    protected $model = Infrastructure::class;

    private array $types = [
        'canalisation',
        'reservoir',
        'station_pompage',
        'captage',
        'compteur',
    ];

    private array $materiaux = [
        'Acier', 'PVC', 'Béton', 'Fonte', 'PEHD', 'Acier inoxydable',
    ];

    private array $statuts = [
        'operationnel', 'operationnel', 'operationnel', // plus probable
        'maintenance',
        'hors_service',
    ];

    private array $noms = [
        'Réservoir Principal',    'Réservoir Secondaire',
        'Canalisation Principale','Canalisation Secondaire',
        'Station de Pompage A',   'Station de Pompage B',
        'Captage Source Nord',    'Captage Source Sud',
        'Compteur Central',       'Compteur Quartier Est',
        'Réservoir Haute Pression','Canalisation de Distribution',
    ];

    public function definition(): array
    {
        $type = $this->faker->randomElement($this->types);

        $capaciteMap = [
            'reservoir'      => $this->faker->numberBetween(1000, 10000),
            'canalisation'   => $this->faker->numberBetween(200, 2000),
            'station_pompage'=> $this->faker->numberBetween(500, 5000),
            'captage'        => $this->faker->numberBetween(100, 1000),
            'compteur'       => $this->faker->numberBetween(50, 500),
        ];

        return [
            'nom'               => $this->faker->randomElement($this->noms) . ' ' . $this->faker->city(),
            'type'              => $type,
            'materiau'          => $this->faker->randomElement($this->materiaux),
            'date_installation' => $this->faker->dateTimeBetween('-20 years', '-1 year')->format('Y-m-d'),
            'capacite'          => $capaciteMap[$type],
            'latitude'          => $this->faker->latitude(30, 37),
            'longitude'         => $this->faker->longitude(-2, 9),
            'statut'            => $this->faker->randomElement($this->statuts),
            'score_risque'      => $this->faker->numberBetween(0, 100),
            'zone_id'           => Zone::inRandomOrder()->first()?->id ?? Zone::factory(),
        ];
    }

    public function operationnel(): static
    {
        return $this->state(['statut' => 'operationnel']);
    }

    public function horsService(): static
    {
        return $this->state(['statut' => 'hors_service']);
    }
}
