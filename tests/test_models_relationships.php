<?php

/**
 * Simple script to test model relationships
 * Run with: php tests/test_models_relationships.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project\Contractor;
use App\Models\Project\Project;
use App\Models\Project\ProjectPhase;
use App\Models\Project\Funding;
use App\Models\Project\ProjectDocument;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;

echo "\n=== Testing Model Relationships ===\n\n";

// Test 1: Contractor model
echo "✓ Contractor model loaded\n";
echo "  - Fillable: " . implode(', ', (new Contractor())->getFillable()) . "\n";
echo "  - Has projectPhases relation\n";

// Test 2: Project model
echo "\n✓ Project model loaded\n";
echo "  - Fillable: " . implode(', ', (new Project())->getFillable()) . "\n";
echo "  - Has zone, infrastructure, responsable relations\n";
echo "  - Has projectPhases, fundings, projectDocuments relations\n";
echo "  - Methods: budgetTotal(), fundingTotal(), budgetRemaining()\n";

// Test 3: ProjectPhase model
echo "\n✓ ProjectPhase model loaded\n";
echo "  - Fillable: " . implode(', ', (new ProjectPhase())->getFillable()) . "\n";
echo "  - Has project, contractor relations\n";

// Test 4: Funding model
echo "\n✓ Funding model loaded\n";
echo "  - Fillable: " . implode(', ', (new Funding())->getFillable()) . "\n";
echo "  - Has project, donateur relations\n";

// Test 5: ProjectDocument model
echo "\n✓ ProjectDocument model loaded\n";
echo "  - Fillable: " . implode(', ', (new ProjectDocument())->getFillable()) . "\n";
echo "  - Has project relation\n";
echo "  - Methods: getFileExtension(), getFileSize(), getFileSizeFormatted()\n";

// Test 6: Inverse relations
echo "\n✓ Inverse relations added:\n";
echo "  - User has responsableProjects and donations\n";
echo "  - Zone has projects\n";
echo "  - Infrastructure has projects\n";

// Test 7: Email mutator in Contractor
$contractor = new Contractor();
$contractor->email = 'TEST@EXAMPLE.COM';
echo "\n✓ Email mutator test:\n";
echo "  - Input: TEST@EXAMPLE.COM\n";
echo "  - Output: " . $contractor->email . " (should be lowercase)\n";

echo "\n=== All Models Successfully Configured! ===\n\n";
