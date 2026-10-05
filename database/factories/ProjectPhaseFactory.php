<?php

namespace Database\Factories;

use App\Models\Project\ProjectPhase;
use App\Models\Project\Project;
use App\Models\Project\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectPhase>
 */
class ProjectPhaseFactory extends Factory
{
    protected $model = ProjectPhase::class;

    /**
     * Noms de phases réalistes
     */
    private static $phaseNames = [
        'Phase 1 - Préparation et études',
        'Phase 2 - Travaux préparatoires',
        'Phase 3 - Travaux principaux',
        'Phase 4 - Finitions',
        'Phase 5 - Tests et mise en service',
        'Étude technique préalable',
        'Dépose des installations existantes',
        'Installation des nouvelles conduites',
        'Raccordements et mise en pression',
        'Contrôle qualité et réception',
        'Terrassement et préparation',
        'Pose des canalisations',
        'Soudure et assemblage',
        'Remblaiement et voirie',
        'Tests d\'étanchéité',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupérer un projet existant
        $project = Project::inRandomOrder()->first();
        
        // Si pas de projet, utiliser des valeurs par défaut
        if (!$project) {
            $projectStart = now();
            $projectEnd = now()->addMonths(6);
            $projectDuration = 180;
            $budgetProject = 100000;
            $projectId = 1;
            $projectStatut = 'en_cours';
        } else {
            $projectStart = $project->date_debut;
            $projectEnd = $project->date_fin_prevue;
            $projectDuration = $projectStart->diffInDays($projectEnd);
            $budgetProject = (float) $project->budget_prevu;
            $projectId = $project->id;
            $projectStatut = $project->statut;
        }
        
        // Dates dans la plage du projet
        $phaseStartOffset = fake()->numberBetween(0, max(1, (int)($projectDuration * 0.7)));
        $dateDebut = (clone $projectStart)->addDays($phaseStartOffset);
        
        // La phase dure entre 10% et 40% de la durée totale du projet
        $phaseDuration = fake()->numberBetween(
            max(7, (int)($projectDuration * 0.1)), 
            max(14, (int)($projectDuration * 0.4))
        );
        $dateFin = (clone $dateDebut)->addDays($phaseDuration);
        
        // S'assurer que la phase ne dépasse pas la fin du projet
        if ($dateFin > $projectEnd) {
            $dateFin = clone $projectEnd;
        }
        
        // Coût proportionnel au budget total (10% à 40% du budget)
        $cout = fake()->randomFloat(2, $budgetProject * 0.1, $budgetProject * 0.4);
        
        // Avancement aléatoire cohérent avec le statut du projet
        $avancement = match($projectStatut) {
            'planifié' => 0,
            'en_cours' => fake()->numberBetween(0, 90),
            'suspendu' => fake()->numberBetween(10, 70),
            'terminé' => 100,
            'annulé' => fake()->numberBetween(0, 60),
            default => fake()->numberBetween(0, 100),
        };

        return [
            'project_id' => $projectId,
            'contractor_id' => Contractor::inRandomOrder()->first()?->id ?? 1,
            'nom' => fake()->randomElement(self::$phaseNames),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'cout' => $cout,
            'avancement' => $avancement,
        ];
    }

    /**
     * Pour un projet spécifique
     */
    public function forProject(Project $project): static
    {
        return $this->state(function (array $attributes) use ($project) {
            $projectStart = $project->date_debut;
            $projectEnd = $project->date_fin_prevue;
            $projectDuration = $projectStart->diffInDays($projectEnd);
            
            $phaseStartOffset = fake()->numberBetween(0, max(1, (int)($projectDuration * 0.7)));
            $dateDebut = (clone $projectStart)->addDays($phaseStartOffset);
            
            $phaseDuration = fake()->numberBetween(
                max(7, (int)($projectDuration * 0.1)), 
                max(14, (int)($projectDuration * 0.4))
            );
            $dateFin = (clone $dateDebut)->addDays($phaseDuration);
            
            if ($dateFin > $projectEnd) {
                $dateFin = clone $projectEnd;
            }
            
            $budgetProject = (float) $project->budget_prevu;
            $cout = fake()->randomFloat(2, $budgetProject * 0.1, $budgetProject * 0.4);
            
            return [
                'project_id' => $project->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'cout' => $cout,
            ];
        });
    }
}
