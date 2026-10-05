<?php

namespace Database\Factories\Incident;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Enums\UserRole;
use App\Models\Incident\Incident;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident\Incident>
 */
class IncidentFactory extends Factory
{
    protected $model = Incident::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupère un citoyen aléatoire
        $citoyen = User::where('role', UserRole::Citoyen)->inRandomOrder()->first() 
                   ?? User::factory()->create(['role' => UserRole::Citoyen]);

        // Récupère parfois un technicien (50% de chances)
        $technicien = fake()->boolean(50) 
            ? (User::whereIn('role', [UserRole::Gestionnaire, UserRole::Admin])->inRandomOrder()->first() 
               ?? User::factory()->create(['role' => UserRole::Gestionnaire]))
            : null;

        // Récupère parfois une infrastructure (60% de chances)
        $infrastructure = fake()->boolean(60) 
            ? Infrastructure::inRandomOrder()->first()
            : null;

        $statut = fake()->randomElement(IncidentStatut::cases());
        $type = fake()->randomElement(IncidentType::cases());
        
        // Descriptions réalistes en français selon le type
        $descriptions = [
            'fuite' => [
                'Importante fuite d\'eau détectée au niveau de la canalisation principale. L\'eau coule de manière continue depuis ce matin. La chaussée commence à être inondée et la situation nécessite une intervention rapide.',
                'Fuite visible au niveau du compteur d\'eau. L\'eau s\'écoule en continu depuis 2 jours. Gaspillage important d\'eau potable constaté dans la rue.',
                'Canalisation cassée dans notre quartier. Une grosse fuite au niveau du trottoir provoque une mare d\'eau importante. Plusieurs voisins sont concernés.',
                'Fuite importante sur la conduite principale. L\'eau jaillit depuis hier soir et commence à endommager la route. Intervention urgente nécessaire.',
                'Rupture de canalisation détectée près du réservoir. Perte d\'eau considérable observée. La pression a fortement diminué dans tout le secteur.',
            ],
            'contamination' => [
                'L\'eau du robinet a une odeur et un goût inhabituels depuis ce matin. Couleur légèrement trouble constatée. Plusieurs personnes du quartier rapportent le même problème.',
                'Eau trouble avec particules en suspension depuis 3 jours. Odeur désagréable persistante. Crainte de contamination pour la santé des habitants.',
                'Changement de couleur de l\'eau potable détecté. L\'eau est devenue jaunâtre depuis hier. Nous avons peur de la consommer.',
                'Présence de sédiments dans l\'eau du robinet. Goût métallique inhabituel. Plusieurs familles du quartier sont inquiètes pour leur santé.',
                'Qualité de l\'eau suspecte depuis la semaine dernière. Odeur de chlore très forte et goût anormal. Des enfants ont eu des maux de ventre.',
            ],
            'coupure' => [
                'Coupure d\'eau sans préavis depuis ce matin 6h. Tout le quartier est affecté. Aucune information n\'a été communiquée aux habitants.',
                'Absence d\'eau courante depuis 2 jours dans notre zone. Situation difficile pour les familles. Nous demandons un rétablissement rapide du service.',
                'Interruption totale de l\'approvisionnement en eau depuis hier après-midi. Pression nulle au robinet. Situation critique pour plusieurs immeubles.',
                'Pas d\'eau dans notre secteur depuis 48 heures. Aucune explication fournie par les services. Les habitants sont très affectés par cette situation.',
                'Coupure d\'eau prolongée non planifiée. Le quartier entier est privé d\'eau potable depuis ce matin. Besoin urgent de citerne d\'approvisionnement.',
            ],
            'autre' => [
                'Pression d\'eau très faible depuis plusieurs jours. L\'eau coule au compte-goutte aux étages supérieurs. Situation très gênante pour les résidents.',
                'Problème de distribution d\'eau dans notre immeuble. Certains appartements reçoivent de l\'eau, d\'autres non. Situation incompréhensible.',
                'Bruit anormal dans les canalisations depuis une semaine. Vibrations importantes lors de l\'ouverture des robinets. Risque de casse à prévoir.',
                'Variation importante de la pression d\'eau tout au long de la journée. Le débit devient très faible le soir. Problème persistant depuis 10 jours.',
                'Dysfonctionnement du système de distribution. L\'eau arrive par intermittence. Nous ne pouvons pas planifier nos activités quotidiennes.',
            ],
        ];
        
        $description = fake()->randomElement($descriptions[$type->value]);
        
        return [
            'type' => $type,
            'description' => $description,
            'latitude' => fake()->latitude(min: 33.0, max: 37.5), // Tunisie
            'longitude' => fake()->longitude(min: 7.5, max: 11.6), // Tunisie
            'urgence' => fake()->randomElement(IncidentUrgence::cases()),
            'statut' => $statut,
            'citoyen_id' => $citoyen->id,
            'technicien_id' => $technicien?->id,
            'infrastructure_id' => $infrastructure?->id,
            'date_resolution' => in_array($statut, [IncidentStatut::Resolu, IncidentStatut::Ferme])
                ? fake()->dateTimeBetween('-30 days', 'now')
                : null,
        ];
    }

    /**
     * Indicate that the incident is new (nouveau).
     */
    public function nouveau(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => IncidentStatut::Nouveau,
            'technicien_id' => null,
            'date_resolution' => null,
        ]);
    }

    /**
     * Indicate that the incident is in progress (en_cours).
     */
    public function enCours(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => IncidentStatut::EnCours,
            'date_resolution' => null,
        ]);
    }

    /**
     * Indicate that the incident is resolved (resolu).
     */
    public function resolu(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => IncidentStatut::Resolu,
            'date_resolution' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the incident is critical.
     */
    public function critique(): static
    {
        return $this->state(fn (array $attributes) => [
            'urgence' => IncidentUrgence::Critique,
        ]);
    }
}
