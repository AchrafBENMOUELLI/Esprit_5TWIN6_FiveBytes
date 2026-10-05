<?php

namespace Database\Factories;

use App\Models\Project\ProjectDocument;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectDocument>
 */
class ProjectDocumentFactory extends Factory
{
    protected $model = ProjectDocument::class;

    /**
     * Titres de documents par type
     */
    private static $documentTitles = [
        'rapport' => [
            'Rapport d\'étude technique',
            'Rapport d\'avancement mensuel',
            'Rapport de fin de travaux',
            'Étude de faisabilité',
            'Analyse de conformité',
            'Rapport de contrôle qualité',
            'Bilan environnemental',
        ],
        'photo' => [
            'Photos avant travaux',
            'Photos pendant chantier',
            'Photos après réalisation',
            'Vue aérienne du site',
            'Détails techniques',
            'État des lieux initial',
        ],
        'facture' => [
            'Facture matériaux Phase 1',
            'Facture prestation Phase 2',
            'Facture finale travaux',
            'Devis accepté',
            'Bon de commande équipements',
        ],
        'contrat' => [
            'Contrat prestataire principal',
            'Contrat sous-traitance',
            'Convention de financement',
            'Accord de partenariat',
            'Cahier des charges',
        ],
        'plan' => [
            'Plans techniques détaillés',
            'Schémas de réseau',
            'Plans de récolement',
            'Plan de situation',
            'Plans des ouvrages',
        ],
        'autre' => [
            'Documents administratifs',
            'Autorisations de travaux',
            'Certificats de conformité',
            'Notes techniques',
            'Compte-rendu de réunion',
        ],
    ];

    /**
     * Extensions par type
     */
    private static $extensions = [
        'rapport' => ['pdf', 'docx', 'doc'],
        'photo' => ['jpg', 'jpeg', 'png'],
        'facture' => ['pdf', 'xlsx', 'xls'],
        'contrat' => ['pdf', 'docx'],
        'plan' => ['pdf', 'dwg', 'dxf'],
        'autre' => ['pdf', 'docx', 'zip'],
    ];

    /**
     * Types de documents
     */
    private static $types = ['rapport', 'photo', 'facture', 'contrat', 'plan', 'autre'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(self::$types);
        $titre = fake()->randomElement(self::$documentTitles[$type]);
        $extension = fake()->randomElement(self::$extensions[$type]);
        
        // Récupérer un projet
        $project = Project::inRandomOrder()->first();
        $projectId = $project?->id ?? 1;
        
        // Générer un nom de fichier réaliste
        $filename = date('Y-m-d') . '_' . 
                   strtolower(str_replace([' ', '\''], ['_', ''], $titre)) . 
                   '_' . fake()->numberBetween(1000, 9999) . 
                   '.' . $extension;
        
        $cheminFichier = 'projects/' . $projectId . '/documents/' . $filename;

        return [
            'project_id' => $projectId,
            'titre' => $titre,
            'chemin_fichier' => $cheminFichier,
            'type' => $type,
        ];
    }

    /**
     * Pour un projet spécifique
     */
    public function forProject(Project $project): static
    {
        return $this->state(function (array $attributes) use ($project) {
            $type = $attributes['type'] ?? fake()->randomElement(self::$types);
            $titre = $attributes['titre'] ?? fake()->randomElement(self::$documentTitles[$type]);
            $extension = fake()->randomElement(self::$extensions[$type]);
            
            $filename = date('Y-m-d') . '_' . 
                       strtolower(str_replace([' ', '\''], ['_', ''], $titre)) . 
                       '_' . fake()->numberBetween(1000, 9999) . 
                       '.' . $extension;
            
            $cheminFichier = 'projects/' . $project->id . '/documents/' . $filename;

            return [
                'project_id' => $project->id,
                'chemin_fichier' => $cheminFichier,
            ];
        });
    }

    /**
     * État: Document de type rapport
     */
    public function rapport(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'rapport',
            'titre' => fake()->randomElement(self::$documentTitles['rapport']),
        ]);
    }

    /**
     * État: Document de type photo
     */
    public function photo(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'photo',
            'titre' => fake()->randomElement(self::$documentTitles['photo']),
        ]);
    }

    /**
     * État: Document de type facture
     */
    public function facture(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'facture',
            'titre' => fake()->randomElement(self::$documentTitles['facture']),
        ]);
    }
}
