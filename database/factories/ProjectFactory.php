<?php

namespace Database\Factories;

use App\Models\Project\Project;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Titres de projets réalistes pour l'eau potable
     */
    private static $projectTitles = [
        'Remplacement canalisation principale',
        'Décontamination réservoir Est',
        'Rénovation station de pompage Nord',
        'Extension réseau quartier des Fleurs',
        'Modernisation compteurs zone industrielle',
        'Réhabilitation canalisation avenue Victor Hugo',
        'Décontamination réservoir municipal',
        'Installation nouveaux compteurs intelligents',
        'Rénovation complète réseau centre-ville',
        'Remplacement canalisations vétustes secteur Sud',
        'Mise aux normes station d\'épuration',
        'Extension réseau eau potable zone rurale',
        'Réfection canalisation principale rue Nationale',
        'Modernisation système de traitement',
        'Décontamination infrastructure captage',
        'Rénovation réservoir d\'eau communal',
        'Remplacement pompes station principale',
        'Extension réseau nouveaux quartiers',
        'Mise en conformité installations anciennes',
        'Réhabilitation réseau sans tranchée',
    ];

    /**
     * Types de projets disponibles
     */
    private static $types = ['réparation', 'modernisation', 'extension', 'construction'];

    /**
     * Statuts de projets avec probabilités
     */
    private static $statuts = [
        'planifié' => 20,
        'en_cours' => 45,
        'suspendu' => 10,
        'terminé' => 20,
        'annulé' => 5,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(self::$types);
        $statut = fake()->randomElement(
            array_merge(...array_map(
                fn($status, $weight) => array_fill(0, $weight, $status),
                array_keys(self::$statuts),
                array_values(self::$statuts)
            ))
        );

        // Avancement cohérent avec le statut
        $avancement = match($statut) {
            'planifié' => fake()->numberBetween(0, 10),
            'en_cours' => fake()->numberBetween(20, 80),
            'suspendu' => fake()->numberBetween(30, 70),
            'terminé' => 100,
            'annulé' => fake()->numberBetween(0, 50),
        };

        // Dates cohérentes
        $dateDebut = fake()->dateTimeBetween('-2 years', '+3 months');
        $dureeJours = fake()->numberBetween(60, 730); // Entre 2 mois et 2 ans
        $dateFinPrevue = (clone $dateDebut)->modify("+{$dureeJours} days");

        // Budget réaliste selon le type
        $budget = match($type) {
            'extension' => fake()->randomFloat(2, 100000, 500000),
            'modernisation' => fake()->randomFloat(2, 50000, 300000),
            'construction' => fake()->randomFloat(2, 150000, 600000),
            'réparation' => fake()->randomFloat(2, 20000, 250000),
        };

        // 50% de chance d'avoir une infrastructure liée
        $infrastructureId = fake()->boolean(50) 
            ? Infrastructure::inRandomOrder()->first()?->id 
            : null;

        return [
            'titre' => fake()->randomElement(self::$projectTitles) . ' - ' . fake()->city(),
            'type' => $type,
            'description' => $this->generateDescription($type),
            'budget_prevu' => $budget,
            'date_debut' => $dateDebut,
            'date_fin_prevue' => $dateFinPrevue,
            'statut' => $statut,
            'avancement_pourcentage' => $avancement,
            'zone_id' => Zone::inRandomOrder()->first()?->id ?? 1,
            'infrastructure_id' => $infrastructureId,
            'responsable_id' => User::where('role', UserRole::Gestionnaire)->inRandomOrder()->first()?->id ?? 1,
        ];
    }

    /**
     * Générer une description réaliste selon le type de projet
     */
    private function generateDescription(string $type): string
    {
        $descriptions = [
            'réparation' => [
                'Réparation complète des canalisations vétustes du secteur. Remplacement des tuyaux en fonte par des conduites modernes en PVC haute résistance.',
                'Travaux de réfection du réseau d\'eau potable incluant le remplacement des vannes défectueuses et la mise aux normes des raccordements.',
                'Réhabilitation du réseau avec technique sans tranchée pour minimiser les perturbations. Pose de nouvelles canalisations PEHD.',
                'Réparation urgente des fuites détectées sur le réseau principal. Remplacement des sections endommagées et tests d\'étanchéité.',
            ],
            'construction' => [
                'Construction d\'une nouvelle station de pompage pour améliorer la distribution d\'eau. Installation complète des équipements et raccordement au réseau.',
                'Construction d\'un nouveau réservoir d\'eau potable de 500m³. Génie civil complet et mise en place du système de régulation.',
                'Construction d\'une station de traitement moderne avec technologies de filtration avancées. Mise en conformité avec les normes européennes.',
                'Construction d\'une nouvelle infrastructure de captage et traitement d\'eau. Forage, équipements de pompage et système de contrôle.',
            ],
            'extension' => [
                'Extension du réseau d\'eau potable pour desservir les nouveaux lotissements. Pose de 2 km de canalisations et installation de 3 bornes incendie.',
                'Raccordement du nouveau quartier au réseau principal. Installation de compteurs divisionnaires et mise en place d\'un surpresseur.',
                'Extension du réseau vers la zone industrielle. Renforcement de la capacité avec pose de conduites de grand diamètre.',
            ],
            'modernisation' => [
                'Modernisation du système de télégestion avec installation de compteurs intelligents. Mise en place d\'un système de détection des fuites en temps réel.',
                'Remplacement des anciennes pompes par des équipements à haut rendement énergétique. Automatisation complète de la station.',
                'Mise à niveau du système de traitement avec installation de nouveaux filtres et d\'un système de désinfection UV moderne.',
            ],
        ];

        return fake()->randomElement($descriptions[$type] ?? ['Projet de gestion de l\'eau potable.']);
    }

    /**
     * État: projet planifié
     */
    public function planifie(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'planifié',
            'avancement_pourcentage' => fake()->numberBetween(0, 10),
            'date_debut' => fake()->dateTimeBetween('+1 week', '+3 months'),
        ]);
    }

    /**
     * État: projet en cours
     */
    public function enCours(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'en_cours',
            'avancement_pourcentage' => fake()->numberBetween(20, 80),
            'date_debut' => fake()->dateTimeBetween('-6 months', '-1 week'),
        ]);
    }

    /**
     * État: projet terminé
     */
    public function termine(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'terminé',
            'avancement_pourcentage' => 100,
            'date_debut' => fake()->dateTimeBetween('-2 years', '-3 months'),
        ]);
    }
}
