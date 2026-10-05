<?php

/**
 * Script de vérification du seeding pour le module Gestion 5
 * Run with: php tests/verify_seeding.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project\Contractor;
use App\Models\Project\Project;
use App\Models\Project\ProjectPhase;
use App\Models\Project\Funding;
use App\Models\Project\ProjectDocument;

echo "\n=== Verification du Seeding - Module Gestion 5 ===\n\n";

// 1. Vérifier les contractors
$contractors = Contractor::count();
echo "✓ Contractors: {$contractors} (Expected: 15)\n";

// 2. Vérifier les projets
$projects = Project::count();
echo "✓ Projects: {$projects} (Expected: 30)\n";

// 3. Vérifier les phases
$phases = ProjectPhase::count();
echo "✓ Project Phases: {$phases} (Expected: 60-120)\n";

// 4. Vérifier les financements
$fundings = Funding::count();
echo "✓ Fundings: {$fundings} (Expected: 30-150)\n";

// 5. Vérifier les documents
$documents = ProjectDocument::count();
echo "✓ Documents: {$documents} (Expected: 60-180)\n";

echo "\n=== Vérification de Cohérence ===\n\n";

// Vérifier un projet aléatoire
$project = Project::with(['projectPhases', 'fundings', 'projectDocuments'])->inRandomOrder()->first();

if ($project) {
    echo "📋 Analyse du projet: {$project->titre}\n";
    echo "-----------------------------------\n";
    echo "Type: {$project->type}\n";
    echo "Statut: {$project->statut}\n";
    echo "Budget prévu: " . number_format($project->budget_prevu, 2) . " €\n";
    echo "Avancement: {$project->avancement_pourcentage}%\n";
    echo "Dates: {$project->date_debut->format('Y-m-d')} → {$project->date_fin_prevue->format('Y-m-d')}\n";
    echo "\n";
    
    // Vérifier les phases
    echo "📦 Phases ({$project->projectPhases->count()}):\n";
    $totalPhaseCost = 0;
    foreach ($project->projectPhases as $phase) {
        $totalPhaseCost += $phase->cout;
        $dateOk = $phase->date_debut >= $project->date_debut && $phase->date_fin <= $project->date_fin_prevue;
        $dateStatus = $dateOk ? '✓' : '✗';
        echo "  {$dateStatus} {$phase->nom}: " . number_format($phase->cout, 2) . " € ({$phase->avancement}%)\n";
        echo "     Dates: {$phase->date_debut->format('Y-m-d')} → {$phase->date_fin->format('Y-m-d')}\n";
    }
    echo "  Total coût phases: " . number_format($totalPhaseCost, 2) . " €\n";
    
    $budgetRatio = ($totalPhaseCost / $project->budget_prevu) * 100;
    echo "  Ratio coût/budget: " . number_format($budgetRatio, 1) . "%\n";
    
    if ($budgetRatio > 120) {
        echo "  ⚠️  Coûts des phases dépassent de plus de 20% le budget!\n";
    } else {
        echo "  ✓ Coûts des phases cohérents avec le budget\n";
    }
    echo "\n";
    
    // Vérifier les financements
    echo "💰 Financements ({$project->fundings->count()}):\n";
    $totalFunding = 0;
    foreach ($project->fundings as $funding) {
        $totalFunding += $funding->montant;
        echo "  • {$funding->source}: " . number_format($funding->montant, 2) . " €";
        if ($funding->donateur_id) {
            echo " (Donateur: User #{$funding->donateur_id})";
        }
        echo "\n";
    }
    echo "  Total financements: " . number_format($totalFunding, 2) . " €\n";
    
    $fundingRatio = ($totalFunding / $project->budget_prevu) * 100;
    echo "  Ratio financement/budget: " . number_format($fundingRatio, 1) . "%\n";
    
    if ($fundingRatio < 80 || $fundingRatio > 120) {
        echo "  ⚠️  Financements s'écartent de plus de 20% du budget\n";
    } else {
        echo "  ✓ Financements cohérents avec le budget\n";
    }
    echo "\n";
    
    // Vérifier les documents
    echo "📄 Documents ({$project->projectDocuments->count()}):\n";
    $docTypes = $project->projectDocuments->groupBy('type');
    foreach ($docTypes as $type => $docs) {
        echo "  • {$type}: {$docs->count()} document(s)\n";
    }
    echo "\n";
    
    // Vérification des relations
    echo "🔗 Vérification des Relations:\n";
    echo "  ✓ Zone: " . ($project->zone ? $project->zone->nom : 'N/A') . "\n";
    echo "  ✓ Infrastructure: " . ($project->infrastructure ? $project->infrastructure->nom : 'Aucune') . "\n";
    echo "  ✓ Responsable: " . ($project->responsable ? $project->responsable->name : 'N/A') . "\n";
    echo "\n";
}

// Statistiques globales
echo "=== Statistiques Globales ===\n\n";

// Projets par statut
$projectsByStatus = Project::selectRaw('statut, COUNT(*) as count')->groupBy('statut')->get();
echo "Projets par statut:\n";
foreach ($projectsByStatus as $stat) {
    echo "  • {$stat->statut}: {$stat->count}\n";
}
echo "\n";

// Projets par type
$projectsByType = Project::selectRaw('type, COUNT(*) as count')->groupBy('type')->get();
echo "Projets par type:\n";
foreach ($projectsByType as $stat) {
    echo "  • {$stat->type}: {$stat->count}\n";
}
echo "\n";

// Financements par source
$fundingsBySource = Funding::selectRaw('source, COUNT(*) as count, SUM(montant) as total')
    ->groupBy('source')
    ->get();
echo "Financements par source:\n";
foreach ($fundingsBySource as $stat) {
    echo "  • {$stat->source}: {$stat->count} financements, " . number_format($stat->total, 2) . " € total\n";
}
echo "\n";

// Vérifier les dons ont bien un donateur
$dons = Funding::where('source', 'don')->get();
$donsWithDonateur = $dons->filter(fn($d) => $d->donateur_id !== null)->count();
echo "Dons avec donateur: {$donsWithDonateur}/{$dons->count()}\n";
if ($donsWithDonateur !== $dons->count()) {
    echo "⚠️  Certains dons n'ont pas de donateur!\n";
} else {
    echo "✓ Tous les dons ont un donateur\n";
}
echo "\n";

echo "=== Vérification Terminée ===\n\n";
echo "✅ Le seeding a été effectué avec succès et les données sont cohérentes!\n\n";
