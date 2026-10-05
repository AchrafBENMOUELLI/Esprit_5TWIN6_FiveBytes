<?php

namespace Database\Seeders;

use App\Enums\IncidentStatut;
use App\Enums\IncidentType;
use App\Enums\IncidentUrgence;
use App\Enums\UserRole;
use App\Models\Incident\Incident;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citoyens = User::where('role', UserRole::Citoyen)->get();
        $gestionnaires = User::whereIn('role', [UserRole::Gestionnaire, UserRole::Admin])->get();
        $infrastructures = Infrastructure::all();

        if ($citoyens->isEmpty()) {
            $this->command->warn('⚠️  Aucun citoyen trouvé. Exécutez UserSeeder d\'abord.');
            return;
        }

        if ($infrastructures->isEmpty()) {
            $this->command->warn('⚠️  Aucune infrastructure trouvée. Exécutez InfrastructureSeeder d\'abord.');
            return;
        }

        // Incidents réalistes avec contexte tunisien
        $incidents = [
            // Incidents résolus
            [
                'type' => IncidentType::Fuite,
                'description' => 'Fuite d\'eau importante au niveau de l\'Avenue Habib Bourguiba. L\'eau s\'écoule depuis hier soir, formant une grande flaque qui gêne la circulation.',
                'urgence' => IncidentUrgence::Haute,
                'statut' => IncidentStatut::Resolu,
                'latitude' => 36.8065,
                'longitude' => 10.1815,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'date_resolution' => now()->subDays(2),
                'created_at' => now()->subDays(5),
            ],
            [
                'type' => IncidentType::Coupure,
                'description' => 'Coupure d\'eau complète dans tout le quartier de La Marsa depuis ce matin 6h. Plus de 200 familles affectées.',
                'urgence' => IncidentUrgence::Critique,
                'statut' => IncidentStatut::Resolu,
                'latitude' => 36.8785,
                'longitude' => 10.3250,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Marsa%')->first()?->id,
                'date_resolution' => now()->subDays(1),
                'created_at' => now()->subDays(3),
            ],

            // Incidents en cours de traitement
            [
                'type' => IncidentType::Contamination,
                'description' => 'Eau trouble avec odeur désagréable depuis 2 jours. Plusieurs voisins se plaignent de la même chose. Couleur jaunâtre suspecte.',
                'urgence' => IncidentUrgence::Haute,
                'statut' => IncidentStatut::EnCours,
                'latitude' => 36.8625,
                'longitude' => 10.1950,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Ariana%')->first()?->id,
                'created_at' => now()->subDays(2),
            ],
            [
                'type' => IncidentType::Fuite,
                'description' => 'Petite fuite au niveau du compteur d\'eau devant l\'immeuble. Perte d\'eau continue mais pas très importante.',
                'urgence' => IncidentUrgence::Moyenne,
                'statut' => IncidentStatut::EnCours,
                'latitude' => 35.8256,
                'longitude' => 10.6369,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(36),
            ],

            // Incidents assignés
            [
                'type' => IncidentType::Fuite,
                'description' => 'Fuite importante visible sur la chaussée Avenue de Carthage. Le trottoir est complètement inondé.',
                'urgence' => IncidentUrgence::Haute,
                'statut' => IncidentStatut::Assigne,
                'latitude' => 34.7406,
                'longitude' => 10.7603,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Sfax%')->first()?->id,
                'created_at' => now()->subHours(24),
            ],
            [
                'type' => IncidentType::Contamination,
                'description' => 'Eau avec goût de chlore très prononcé depuis hier. Impossible à boire même bouillie.',
                'urgence' => IncidentUrgence::Moyenne,
                'statut' => IncidentStatut::Assigne,
                'latitude' => 35.7774,
                'longitude' => 10.8269,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Monastir%')->first()?->id,
                'created_at' => now()->subHours(18),
            ],

            // Incidents nouveaux (en attente)
            [
                'type' => IncidentType::Coupure,
                'description' => 'Pas d\'eau depuis ce matin dans notre immeuble de 6 étages. Les autres immeubles de la rue semblent avoir de l\'eau normalement.',
                'urgence' => IncidentUrgence::Haute,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 36.8345,
                'longitude' => 10.1625,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(6),
            ],
            [
                'type' => IncidentType::Fuite,
                'description' => 'Grosse fuite au croisement Rue de la Liberté et Avenue Mohamed V. L\'eau jaillit du sol comme une fontaine.',
                'urgence' => IncidentUrgence::Critique,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 36.8115,
                'longitude' => 10.1785,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(3),
            ],
            [
                'type' => IncidentType::Autre,
                'description' => 'Bruit étrange dans les canalisations, comme un sifflement continu. Cela se produit surtout la nuit et empêche de dormir.',
                'urgence' => IncidentUrgence::Faible,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 36.8855,
                'longitude' => 10.3310,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(12),
            ],
            [
                'type' => IncidentType::Contamination,
                'description' => 'Présence de particules blanches dans l\'eau du robinet. Semble être du calcaire mais en quantité anormale.',
                'urgence' => IncidentUrgence::Moyenne,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 35.8335,
                'longitude' => 10.6125,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(8),
            ],

            // Incidents refusés/rejetés
            [
                'type' => IncidentType::Autre,
                'description' => 'Ma facture d\'eau est trop élevée ce mois-ci. Je soupçonne un problème de compteur.',
                'urgence' => IncidentUrgence::Faible,
                'statut' => IncidentStatut::Rejete,
                'latitude' => 34.7465,
                'longitude' => 10.7525,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => null,
                'created_at' => now()->subDays(4),
            ],

            // Incidents doublons
            [
                'type' => IncidentType::Fuite,
                'description' => 'Fuite signalée au croisement Mohamed V (même endroit que INC-2026-0008). J\'ajoute mon signalement.',
                'urgence' => IncidentUrgence::Moyenne,
                'statut' => IncidentStatut::Doublon,
                'latitude' => 36.8115,
                'longitude' => 10.1785,
                'citoyen_id' => $citoyens->random()->id,
                'technicien_id' => $gestionnaires->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subHours(2),
            ],

            // Incidents urgents récents
            [
                'type' => IncidentType::Coupure,
                'description' => 'Coupure généralisée dans toute la zone d\'Ennasr. Pas d\'eau depuis 2 heures. Plusieurs centaines de foyers touchés.',
                'urgence' => IncidentUrgence::Critique,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 36.8555,
                'longitude' => 10.1825,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Ennasr%')->first()?->id,
                'created_at' => now()->subMinutes(45),
            ],
            [
                'type' => IncidentType::Contamination,
                'description' => 'Eau complètement marron qui sort du robinet ! Impossible à utiliser. Ça ressemble à de la boue.',
                'urgence' => IncidentUrgence::Critique,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 35.7685,
                'longitude' => 10.8385,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->random()->id,
                'created_at' => now()->subMinutes(30),
            ],
            [
                'type' => IncidentType::Fuite,
                'description' => 'Fuite sous pression sur canalisation principale. Le jet d\'eau atteint 3 mètres de hauteur. Situation dangereuse.',
                'urgence' => IncidentUrgence::Critique,
                'statut' => IncidentStatut::Nouveau,
                'latitude' => 35.8185,
                'longitude' => 10.6445,
                'citoyen_id' => $citoyens->random()->id,
                'infrastructure_id' => $infrastructures->where('nom', 'like', '%Sousse%')->first()?->id,
                'created_at' => now()->subMinutes(15),
            ],
        ];

        foreach ($incidents as $incidentData) {
            Incident::create($incidentData);
        }

        $this->command->info('✅ 15 incidents réalistes créés');
        $this->command->info('   - 2 résolus');
        $this->command->info('   - 2 en cours');
        $this->command->info('   - 2 assignés');
        $this->command->info('   - 7 nouveaux (dont 3 critiques)');
        $this->command->info('   - 1 rejeté');
        $this->command->info('   - 1 doublon');
    }
}
