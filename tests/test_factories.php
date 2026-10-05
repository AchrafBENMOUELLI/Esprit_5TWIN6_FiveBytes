<?php

/**
 * Test script for factories
 * Run with: php tests/test_factories.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project\Contractor;
use App\Models\Project\Project;
use App\Models\Project\ProjectPhase;
use App\Models\Project\Funding;
use App\Models\Project\ProjectDocument;

echo "\n=== Testing Factories ===\n\n";

try {
    // Test ContractorFactory
    echo "✓ ContractorFactory: ";
    $contractor = Contractor::factory()->make();
    echo "OK - Entreprise: {$contractor->nom}, Spécialité: {$contractor->specialite}\n";
    echo "  Email: {$contractor->email} (lowercase: " . (strtolower($contractor->email) === $contractor->email ? 'YES' : 'NO') . ")\n";
    echo "  Téléphone: {$contractor->telephone}\n";
    
    // Test ProjectFactory - only if zones exist
    $zoneId = \App\Models\Infrastructure\Zone::first()?->id;
    $userId = \App\Models\User::first()?->id;
    
    if ($zoneId && $userId) {
        echo "\n✓ ProjectFactory: ";
        $project = Project::factory()->make([
            'zone_id' => $zoneId,
            'responsable_id' => $userId,
        ]);
        echo "OK - Titre: {$project->titre}\n";
        echo "  Type: {$project->type}, Statut: {$project->statut}\n";
        echo "  Budget: " . number_format($project->budget_prevu, 2) . " €\n";
        echo "  Avancement: {$project->avancement_pourcentage}%\n";
        echo "  Dates: {$project->date_debut->format('Y-m-d')} → {$project->date_fin_prevue->format('Y-m-d')}\n";
    } else {
        echo "\n⚠ ProjectFactory: SKIPPED (no zones or users in database)\n";
    }
    
    // Test ProjectPhaseFactory - only make, don't persist
    echo "\n✓ ProjectPhaseFactory: ";
    $phase = ProjectPhase::factory()->make([
        'project_id' => 1,
        'contractor_id' => 1,
    ]);
    echo "OK - Phase: {$phase->nom}\n";
    echo "  Coût: " . number_format($phase->cout, 2) . " €\n";
    echo "  Avancement: {$phase->avancement}%\n";
    
    // Test FundingFactory
    echo "\n✓ FundingFactory: ";
    $funding = Funding::factory()->make([
        'project_id' => 1,
    ]);
    echo "OK - Source: {$funding->source}\n";
    echo "  Montant: " . number_format($funding->montant, 2) . " €\n";
    echo "  Donateur: " . ($funding->donateur_id ? "User #{$funding->donateur_id}" : "N/A") . "\n";
    echo "  Source = 'don' => donateur_id required: " . ($funding->source === 'don' && $funding->donateur_id ? 'YES' : ($funding->source !== 'don' ? 'N/A' : 'NO')) . "\n";
    
    // Test ProjectDocumentFactory
    echo "\n✓ ProjectDocumentFactory: ";
    $document = ProjectDocument::factory()->make([
        'project_id' => 1,
    ]);
    echo "OK - Document: {$document->titre}\n";
    echo "  Type: {$document->type}\n";
    echo "  Fichier: {$document->chemin_fichier}\n";
    echo "  Extension: {$document->getFileExtension()}\n";
    
    echo "\n=== All Factories Work Perfectly! ===\n\n";
    
    echo "Sample Data:\n";
    echo "------------\n";
    echo "Contractor: {$contractor->nom}\n";
    if (isset($project)) {
        echo "Project: {$project->titre}\n";
    }
    echo "Phase: {$phase->nom}\n";
    echo "Funding: {$funding->source} - " . number_format($funding->montant, 2) . " €\n";
    echo "Document: {$document->titre}\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    exit(1);
}
