<?php

namespace Database\Factories;

use App\Models\Project\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contractor>
 */
class ContractorFactory extends Factory
{
    protected $model = Contractor::class;

    /**
     * Noms d'entreprises réalistes pour travaux d'eau potable
     */
    private static $companyNames = [
        'Aquatech Solutions',
        'HydroServices France',
        'Canalisations du Nord',
        'Plomberie Industrielle Dupont',
        'Travaux Hydrauliques Martin',
        'EauTech Rénovation',
        'SociétéGénérale de Canalisations',
        'Entreprise Lefebvre TP',
        'Hydro-Rénovation SA',
        'Bernard & Fils Plomberie',
        'Réseaux d\'Eau Services',
        'AquaPro Maintenance',
        'Canalisations Modernes SARL',
        'Dubois Travaux Publics',
        'TechniEau Industries',
        'Fontaine Hydraulique',
        'Régie des Eaux Techniques',
        'Moreau Canalisations',
        'AquaServices Plus',
        'Hydrotech Bretagne',
    ];

    /**
     * Spécialités pour le secteur de l'eau potable
     */
    private static $specialites = [
        'Rénovation canalisations',
        'Décontamination',
        'Pose de compteurs',
        'Travaux de forage',
        'Électromécanique',
        'Installation de pompes',
        'Étanchéité réservoirs',
        'Pose de vannes',
        'Diagnostic de fuites',
        'Réhabilitation sans tranchée',
    ];

    /**
     * Villes françaises pour les adresses
     */
    private static $villes = [
        ['nom' => 'Lyon', 'postal' => '69000'],
        ['nom' => 'Marseille', 'postal' => '13000'],
        ['nom' => 'Toulouse', 'postal' => '31000'],
        ['nom' => 'Nice', 'postal' => '06000'],
        ['nom' => 'Nantes', 'postal' => '44000'],
        ['nom' => 'Strasbourg', 'postal' => '67000'],
        ['nom' => 'Montpellier', 'postal' => '34000'],
        ['nom' => 'Bordeaux', 'postal' => '33000'],
        ['nom' => 'Lille', 'postal' => '59000'],
        ['nom' => 'Rennes', 'postal' => '35000'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyName = fake()->unique()->randomElement(self::$companyNames);
        $ville = fake()->randomElement(self::$villes);
        
        // Créer un slug pour l'email basé sur le nom de l'entreprise
        $emailSlug = strtolower(str_replace([' ', '\'', '&'], ['', '', 'et'], $companyName));
        $emailSlug = preg_replace('/[^a-z0-9]/', '', $emailSlug);

        return [
            'nom' => $companyName,
            'specialite' => fake()->randomElement(self::$specialites),
            'email' => $emailSlug . '@' . fake()->randomElement(['entreprise.fr', 'tp.com', 'services.fr', 'pro.fr']),
            'telephone' => '+33 ' . fake()->numberBetween(1, 9) . ' ' . 
                          fake()->numerify('## ## ## ##'),
            'adresse' => fake()->numberBetween(1, 150) . ' ' . 
                        fake()->randomElement(['rue', 'avenue', 'boulevard', 'allée', 'impasse']) . ' ' .
                        fake()->randomElement(['de la République', 'Jean Jaurès', 'Victor Hugo', 'des Lilas', 'du Commerce', 'Nationale', 'de la Gare', 'des Écoles']) . ', ' .
                        $ville['postal'] . ' ' . $ville['nom'],
        ];
    }
}
