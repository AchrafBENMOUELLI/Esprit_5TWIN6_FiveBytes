<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project\Contractor;
use App\Models\Project\Project;
use App\Models\Project\ProjectPhase;
use App\Models\Project\Funding;
use App\Models\Project\ProjectDocument;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;
use App\Enums\UserRole;

class ProjectModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Seeding Project Module (Gestion 5) - Projets de Rénovation et Financement');
        
        // Étape 1 : Créer 15 contractors
        $this->command->info('📦 Creating 15 contractors...');
        $contractors = Contractor::factory()->count(15)->create();
        $this->command->info("✅ Created {$contractors->count()} contractors");
        
        // Récupérer les zones et infrastructures existantes
        $zones = Zone::all();
        $infrastructures = Infrastructure::all();
        $gestionnaires = User::where('role', UserRole::Gestionnaire)->get();
        $citoyens = User::where('role', UserRole::Citoyen)->get();
        
        if ($zones->isEmpty()) {
            $this->command->warn('⚠️  No zones found. Please seed zones first!');
            return;
        }
        
        if ($gestionnaires->isEmpty()) {
            $this->command->warn('⚠️  No gestionnaires found. Creating default users...');
            $gestionnaires = User::factory()->count(3)->create(['role' => UserRole::Gestionnaire]);
        }
        
        // Étape 2 : Créer 30 projects répartis sur différentes zones
        $this->command->info('📦 Creating 30 projects...');
        
        $projectsData = [
            ['state' => 'planifie', 'count' => 6],      // 20%
            ['state' => 'enCours', 'count' => 14],      // ~47%
            ['state' => 'termine', 'count' => 6],       // 20%
            ['state' => null, 'count' => 4],            // 13% (suspendu/annulé aléatoire)
        ];
        
        $allProjects = collect();
        
        foreach ($projectsData as $data) {
            $count = $data['count'];
            $state = $data['state'];
            
            for ($i = 0; $i < $count; $i++) {
                // Sélectionner une zone aléatoire
                $zone = $zones->random();
                
                // 60% de chance d'avoir une infrastructure liée
                $infrastructure = rand(1, 10) <= 6 && $infrastructures->isNotEmpty() 
                    ? $infrastructures->where('zone_id', $zone->id)->random() ?? null
                    : null;
                
                // Créer le projet avec ou sans state
                $projectFactory = Project::factory();
                if ($state) {
                    $projectFactory = $projectFactory->$state();
                }
                
                $project = $projectFactory->create([
                    'zone_id' => $zone->id,
                    'infrastructure_id' => $infrastructure?->id,
                    'responsable_id' => $gestionnaires->random()->id,
                ]);
                
                $allProjects->push($project);
            }
        }
        
        $this->command->info("✅ Created {$allProjects->count()} projects");
        
        // Étape 3 : Pour chaque projet, créer les relations
        $this->command->info('📦 Creating project phases, fundings, and documents...');
        
        $totalPhases = 0;
        $totalFundings = 0;
        $totalDocuments = 0;
        
        foreach ($allProjects as $project) {
            // 2 à 4 phases avec des contractors différents
            $numberOfPhases = rand(2, 4);
            $usedContractors = [];
            
            // Calculer le budget disponible pour les phases (80-120% du budget prévu)
            $budgetForPhases = (float) $project->budget_prevu * (rand(80, 120) / 100);
            $budgetPerPhase = $budgetForPhases / $numberOfPhases;
            
            // Calculer la durée du projet
            $projectStart = $project->date_debut;
            $projectEnd = $project->date_fin_prevue;
            $projectDuration = $projectStart->diffInDays($projectEnd);
            $phaseDuration = max(7, (int) ($projectDuration / $numberOfPhases));
            
            for ($i = 0; $i < $numberOfPhases; $i++) {
                // Sélectionner un contractor différent
                $availableContractors = $contractors->whereNotIn('id', $usedContractors);
                $contractor = $availableContractors->isNotEmpty() 
                    ? $availableContractors->random() 
                    : $contractors->random();
                
                $usedContractors[] = $contractor->id;
                
                // Calculer les dates de la phase
                $phaseStart = (clone $projectStart)->addDays($i * $phaseDuration);
                $phaseEnd = (clone $phaseStart)->addDays($phaseDuration - 1);
                
                // S'assurer que la phase ne dépasse pas la fin du projet
                if ($phaseEnd > $projectEnd) {
                    $phaseEnd = clone $projectEnd;
                }
                
                // Coût de la phase avec variation (80-120% du budget moyen par phase)
                $phaseCost = $budgetPerPhase * (rand(80, 120) / 100);
                
                // Avancement cohérent avec le statut du projet
                $avancement = match($project->statut) {
                    'planifié' => 0,
                    'en_cours' => rand(10 * $i, 90 - (10 * ($numberOfPhases - $i - 1))),
                    'suspendu' => rand(20, 60),
                    'terminé' => 100,
                    'annulé' => rand(0, 50),
                    default => rand(0, 100),
                };
                
                ProjectPhase::create([
                    'project_id' => $project->id,
                    'contractor_id' => $contractor->id,
                    'nom' => "Phase " . ($i + 1) . " - " . $this->getPhaseNameByIndex($i, $numberOfPhases),
                    'date_debut' => $phaseStart,
                    'date_fin' => $phaseEnd,
                    'cout' => round($phaseCost, 2),
                    'avancement' => $avancement,
                ]);
                
                $totalPhases++;
            }
            
            // 1 à 5 fundings de sources variées
            $numberOfFundings = rand(1, 5);
            
            // Calculer le total des financements (95-105% du budget prévu pour meilleure cohérence)
            $totalFundingAmount = (float) $project->budget_prevu * (rand(95, 105) / 100);
            
            // Sources de financement disponibles avec priorités
            $fundingSources = [
                'municipal' => 0.35,
                'régional' => 0.25,
                'fédéral' => 0.15,
                'européen' => 0.10,
                'privé' => 0.10,
                'don' => 0.05,
            ];
            
            // Sélectionner des sources variées
            $selectedSources = $this->selectVariedSources($fundingSources, $numberOfFundings);
            
            $remainingAmount = $totalFundingAmount;
            
            foreach ($selectedSources as $index => $source) {
                // Dernier financement prend le reste
                if ($index === count($selectedSources) - 1) {
                    $amount = $remainingAmount;
                } else {
                    // Montant entre 10% et 50% du reste
                    $amount = $remainingAmount * (rand(10, 50) / 100);
                    $remainingAmount -= $amount;
                }
                
                // Si c'est un don, montant plus petit et nécessite un donateur
                if ($source === 'don') {
                    $amount = min($amount, rand(100, 5000));
                    $donateurId = $citoyens->isNotEmpty() ? $citoyens->random()->id : null;
                } else {
                    $donateurId = null;
                }
                
                // Date de versement cohérente
                $dateVersement = $this->getRandomDateInRange(
                    $projectStart->copy()->subMonths(6),
                    min($projectEnd, now())
                );
                
                Funding::create([
                    'project_id' => $project->id,
                    'source' => $source,
                    'donateur_id' => $donateurId,
                    'montant' => round($amount, 2),
                    'date_versement' => $dateVersement,
                ]);
                
                $totalFundings++;
            }
            
            // 2 à 6 documents de types variés
            $numberOfDocuments = rand(2, 6);
            
            $documentTypes = ['rapport', 'photo', 'facture', 'contrat', 'plan', 'autre'];
            $selectedTypes = [];
            
            for ($i = 0; $i < $numberOfDocuments; $i++) {
                // Éviter les doublons quand possible
                $availableTypes = array_diff($documentTypes, $selectedTypes);
                $type = !empty($availableTypes) ? $availableTypes[array_rand($availableTypes)] : $documentTypes[array_rand($documentTypes)];
                $selectedTypes[] = $type;
                
                ProjectDocument::factory()->create([
                    'project_id' => $project->id,
                    'type' => $type,
                ]);
                
                $totalDocuments++;
            }
        }
        
        $this->command->info("✅ Created {$totalPhases} project phases");
        $this->command->info("✅ Created {$totalFundings} fundings");
        $this->command->info("✅ Created {$totalDocuments} documents");
        
        // Afficher les statistiques
        $this->displayStatistics($allProjects);
        
        $this->command->info('');
        $this->command->info('🎉 Project Module seeding completed successfully!');
    }
    
    /**
     * Obtenir un nom de phase basé sur l'index
     */
    private function getPhaseNameByIndex(int $index, int $total): string
    {
        $phases = [
            'Études et préparation',
            'Travaux préparatoires',
            'Travaux principaux',
            'Finitions',
            'Tests et mise en service',
        ];
        
        if ($total <= 2) {
            return $index === 0 ? 'Travaux principaux' : 'Finitions et tests';
        }
        
        return $phases[$index] ?? 'Travaux complémentaires';
    }
    
    /**
     * Sélectionner des sources de financement variées
     */
    private function selectVariedSources(array $sources, int $count): array
    {
        $selected = [];
        $sourceKeys = array_keys($sources);
        
        // Toujours inclure 'municipal' si count >= 2
        if ($count >= 2 && !in_array('municipal', $selected)) {
            $selected[] = 'municipal';
            $count--;
        }
        
        // Ajouter les autres sources aléatoirement
        $remainingSources = array_diff($sourceKeys, $selected);
        shuffle($remainingSources);
        
        foreach (array_slice($remainingSources, 0, $count) as $source) {
            $selected[] = $source;
        }
        
        return $selected;
    }
    
    /**
     * Obtenir une date aléatoire dans une plage
     */
    private function getRandomDateInRange(\DateTime $start, \DateTime $end)
    {
        $timestamp = rand($start->getTimestamp(), $end->getTimestamp());
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        return $date;
    }
    
    /**
     * Afficher les statistiques de seeding
     */
    private function displayStatistics($projects): void
    {
        $this->command->info('');
        $this->command->info('📊 Seeding Statistics:');
        $this->command->info('-----------------------------------');
        
        // Statistiques par statut
        $statusCounts = $projects->countBy('statut');
        $this->command->info('Projects by status:');
        foreach ($statusCounts as $status => $count) {
            $percentage = round(($count / $projects->count()) * 100, 1);
            $this->command->info("  • {$status}: {$count} ({$percentage}%)");
        }
        
        // Statistiques par type
        $this->command->info('');
        $typeCounts = $projects->countBy('type');
        $this->command->info('Projects by type:');
        foreach ($typeCounts as $type => $count) {
            $percentage = round(($count / $projects->count()) * 100, 1);
            $this->command->info("  • {$type}: {$count} ({$percentage}%)");
        }
        
        // Projets avec/sans infrastructure
        $withInfra = $projects->whereNotNull('infrastructure_id')->count();
        $withoutInfra = $projects->whereNull('infrastructure_id')->count();
        $this->command->info('');
        $this->command->info('Projects with infrastructure:');
        $this->command->info("  • With: {$withInfra} (" . round(($withInfra / $projects->count()) * 100, 1) . "%)");
        $this->command->info("  • Without: {$withoutInfra} (" . round(($withoutInfra / $projects->count()) * 100, 1) . "%)");
        
        // Budget total
        $totalBudget = $projects->sum('budget_prevu');
        $this->command->info('');
        $this->command->info('Financial data:');
        $this->command->info("  • Total budget: " . number_format($totalBudget, 2) . " €");
        $this->command->info("  • Average budget: " . number_format($totalBudget / $projects->count(), 2) . " €");
    }
}
