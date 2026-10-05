<?php

namespace Database\Factories;

use App\Models\Project\Funding;
use App\Models\Project\Project;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Funding>
 */
class FundingFactory extends Factory
{
    protected $model = Funding::class;

    /**
     * Sources de financement disponibles
     */
    private static $sources = ['municipal', 'régional', 'fédéral', 'européen', 'privé', 'don'];

    /**
     * Probabilités des sources (pour répartition réaliste)
     */
    private static $sourceProbabilities = [
        'municipal' => 35,
        'régional' => 25,
        'fédéral' => 15,
        'européen' => 10,
        'privé' => 10,
        'don' => 5,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sélectionner une source avec probabilités
        $source = fake()->randomElement(
            array_merge(...array_map(
                fn($src, $weight) => array_fill(0, $weight, $src),
                array_keys(self::$sourceProbabilities),
                array_values(self::$sourceProbabilities)
            ))
        );

        // Si c'est un don, il faut un donateur (citoyen)
        $donateurId = null;
        if ($source === 'don') {
            $donateurId = User::where('role', UserRole::Citoyen)
                ->inRandomOrder()
                ->first()?->id;
        }

        // Récupérer un projet pour calculer un montant cohérent
        $project = Project::inRandomOrder()->first();
        $budgetProject = $project ? (float) $project->budget_prevu : 50000;
        
        // Montant selon la source
        $montant = match($source) {
            'municipal' => fake()->randomFloat(2, $budgetProject * 0.2, $budgetProject * 0.5),
            'régional' => fake()->randomFloat(2, $budgetProject * 0.15, $budgetProject * 0.4),
            'fédéral' => fake()->randomFloat(2, $budgetProject * 0.1, $budgetProject * 0.35),
            'européen' => fake()->randomFloat(2, $budgetProject * 0.05, $budgetProject * 0.25),
            'privé' => fake()->randomFloat(2, $budgetProject * 0.05, $budgetProject * 0.2),
            'don' => fake()->randomFloat(2, 100, 5000),
        };

        // Date de versement cohérente avec le projet
        if ($project) {
            // Versement avant ou pendant le projet
            $dateVersement = fake()->dateTimeBetween(
                $project->date_debut->copy()->subMonths(6),
                min(now(), $project->date_fin_prevue)
            );
        } else {
            $dateVersement = fake()->dateTimeBetween('-1 year', 'now');
        }

        return [
            'project_id' => $project?->id ?? 1,
            'source' => $source,
            'donateur_id' => $donateurId,
            'montant' => $montant,
            'date_versement' => $dateVersement,
        ];
    }

    /**
     * Pour un projet spécifique
     */
    public function forProject(Project $project): static
    {
        return $this->state(function (array $attributes) use ($project) {
            $budgetProject = (float) $project->budget_prevu;
            $source = $attributes['source'] ?? fake()->randomElement(self::$sources);
            
            $montant = match($source) {
                'municipal' => fake()->randomFloat(2, $budgetProject * 0.2, $budgetProject * 0.5),
                'régional' => fake()->randomFloat(2, $budgetProject * 0.15, $budgetProject * 0.4),
                'fédéral' => fake()->randomFloat(2, $budgetProject * 0.1, $budgetProject * 0.35),
                'européen' => fake()->randomFloat(2, $budgetProject * 0.05, $budgetProject * 0.25),
                'privé' => fake()->randomFloat(2, $budgetProject * 0.05, $budgetProject * 0.2),
                'don' => fake()->randomFloat(2, 100, 5000),
            };

            $dateVersement = fake()->dateTimeBetween(
                $project->date_debut->copy()->subMonths(6),
                min(now(), $project->date_fin_prevue)
            );

            return [
                'project_id' => $project->id,
                'montant' => $montant,
                'date_versement' => $dateVersement,
            ];
        });
    }

    /**
     * État: Financement municipal
     */
    public function municipal(): static
    {
        return $this->state(fn (array $attributes) => [
            'source' => 'municipal',
            'donateur_id' => null,
        ]);
    }

    /**
     * État: Don d'un citoyen
     */
    public function don(): static
    {
        return $this->state(fn (array $attributes) => [
            'source' => 'don',
            'donateur_id' => User::where('role', UserRole::Citoyen)->inRandomOrder()->first()?->id,
            'montant' => fake()->randomFloat(2, 50, 2000),
        ]);
    }
}
