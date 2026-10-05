# Database Schema Reference - Module 5

## 📋 Quick Reference Guide

This document lists the **ACTUAL** database column names and relationship names to use in views and controllers.

---

## Projects Table

### Table Name: `projects`

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `titre` | string(200) | Project title |
| `type` | enum | Type: 'rénovation', 'décontamination', 'extension', 'modernisation' |
| `description` | text | Project description |
| `budget_prevu` | decimal(15,2) | **Planned budget** (NOT `budget_estime`) |
| `date_debut` | date | Start date |
| `date_fin_prevue` | date | Expected end date |
| `statut` | enum | Status: 'planifié', 'en_cours', 'suspendu', 'terminé', 'annulé' |
| `avancement_pourcentage` | integer | Progress percentage (0-100) |
| `zone_id` | bigint | Foreign key to zones |
| `infrastructure_id` | bigint (nullable) | Foreign key to infrastructures |
| `responsable_id` | bigint | Foreign key to users |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Relationships (Model: `App\Models\Project\Project`):
```php
$project->zone              // BelongsTo Zone
$project->infrastructure    // BelongsTo Infrastructure (nullable)
$project->responsable       // BelongsTo User
$project->projectPhases     // HasMany ProjectPhase (NOT $project->phases)
$project->fundings          // HasMany Funding
$project->projectDocuments  // HasMany ProjectDocument (NOT $project->documents)
```

### Methods:
```php
$project->budgetTotal()     // float - Sum of all phase costs
$project->fundingTotal()    // float - Sum of all funding amounts
$project->budgetRemaining() // float - fundingTotal() - budgetTotal()
```

---

## Project Phases Table

### Table Name: `project_phases`

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `project_id` | bigint | Foreign key to projects |
| `contractor_id` | bigint | Foreign key to contractors |
| `nom` | string(150) | Phase name |
| `date_debut` | date | Start date |
| `date_fin` | date | End date |
| `cout` | decimal(15,2) | **Cost** (NOT `budget_alloue`) |
| `avancement` | integer | Progress percentage (0-100) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### ⚠️ Note: NO `statut` or `description` columns!

### Relationships (Model: `App\Models\Project\ProjectPhase`):
```php
$phase->project     // BelongsTo Project
$phase->contractor  // BelongsTo Contractor
```

---

## Fundings Table

### Table Name: `fundings`

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `project_id` | bigint | Foreign key to projects |
| `source` | enum | 'subvention_publique', 'don', 'emprunt', 'fonds_propres' |
| `montant` | decimal(15,2) | Funding amount |
| `date_obtention` | date | Date obtained |
| `statut` | enum | 'en_attente', 'approuve', 'rejete' |
| `donateur_id` | bigint (nullable) | Foreign key to users (only if source='don') |
| `description` | text (nullable) | Description |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Relationships (Model: `App\Models\Project\Funding`):
```php
$funding->project   // BelongsTo Project
$funding->donateur  // BelongsTo User (nullable)
```

---

## Project Documents Table

### Table Name: `project_documents`

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `project_id` | bigint | Foreign key to projects |
| `nom` | string(200) | Document name |
| `type_document` | enum | 'cahier_charges', 'plan_technique', 'rapport_etude', 'photo', 'autre' |
| `chemin_fichier` | string(500) | File path in storage |
| `description` | text (nullable) | Description |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Relationships (Model: `App\Models\Project\ProjectDocument`):
```php
$document->project  // BelongsTo Project
```

---

## Contractors Table

### Table Name: `contractors`

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `nom` | string(200) | Company name |
| `adresse` | text | Address |
| `telephone` | string(20) | Phone number |
| `email` | string | Email |
| `specialite` | string(150) | Specialization |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Relationships (Model: `App\Models\Project\Contractor`):
```php
$contractor->projectPhases  // HasMany ProjectPhase
```

---

## Common Mistakes to Avoid

### ❌ WRONG:
```php
$project->budget_estime     // Column doesn't exist!
$project->type_projet       // Column doesn't exist!
$project->phases            // Relationship doesn't exist!
$project->documents         // Relationship doesn't exist!
$phase->budget_alloue       // Column doesn't exist!
$phase->statut              // Column doesn't exist!
$phase->description         // Column doesn't exist!
```

### ✅ CORRECT:
```php
$project->budget_prevu      // ✓
$project->type              // ✓
$project->projectPhases     // ✓
$project->projectDocuments  // ✓
$phase->cout                // ✓
$phase->avancement          // ✓
```

---

## Blade View Examples

### Display Project Budget:
```blade
<div>{{ number_format($project->budget_prevu, 2, ',', ' ') }} €</div>
```

### Display Project Type:
```blade
<span>{{ ucfirst($project->type) }}</span>
```

### Loop Through Phases:
```blade
@if($project->projectPhases->count() > 0)
    @foreach($project->projectPhases as $phase)
        <div>
            <h3>{{ $phase->nom }}</h3>
            <p>Coût: {{ number_format($phase->cout, 2, ',', ' ') }} €</p>
            <p>Avancement: {{ $phase->avancement }}%</p>
            <p>Entrepreneur: {{ $phase->contractor->nom }}</p>
        </div>
    @endforeach
@endif
```

### Loop Through Documents:
```blade
@if($project->projectDocuments->count() > 0)
    @foreach($project->projectDocuments as $document)
        <a href="{{ Storage::url($document->chemin_fichier) }}" target="_blank">
            {{ $document->nom }}
        </a>
    @endforeach
@endif
```

---

## Controller Eager Loading

### Correct Way:
```php
public function show(Project $project)
{
    $project->load([
        'zone',
        'infrastructure',
        'responsable',
        'projectPhases.contractor',      // ✓
        'fundings.donateur',
        'projectDocuments'               // ✓
    ]);
    
    return view('project.show', compact('project'));
}
```

### Wrong Way:
```php
// ❌ These relationships don't exist!
$project->load([
    'phases.contractor',     // Wrong!
    'documents'              // Wrong!
]);
```

---

## Database Query Examples

### Get projects with all relations:
```php
$projects = Project::with([
    'zone',
    'infrastructure',
    'responsable',
    'projectPhases',
    'fundings',
    'projectDocuments'
])->get();
```

### Calculate totals:
```php
$project = Project::find(1);
$budgetTotal = $project->budgetTotal();        // Sum of phase costs
$fundingTotal = $project->fundingTotal();      // Sum of funding amounts
$remaining = $project->budgetRemaining();      // Difference
```

---

## Status Values (with French accents)

### Project Status:
- `planifié` (with é)
- `en_cours`
- `suspendu`
- `terminé` (with é)
- `annulé` (with é)

### Funding Status:
- `en_attente`
- `approuve` (with é)
- `rejete` (with é)

### Display in Blade:
```blade
{{ ucfirst(str_replace('_', ' ', $project->statut)) }}
```

---

## Related Files
- Migrations: `database/migrations/2026_10_05_181517_*.php`
- Models: `app/Models/Project/*.php`
- Factories: `database/factories/*.php`
- Seeders: `database/seeders/ProjectModuleSeeder.php`

---

## Need to Add Columns?

If you need columns like `statut` or `description` on `project_phases`, you'll need to:

1. Create a new migration:
```bash
php artisan make:migration add_statut_description_to_project_phases_table
```

2. Add the columns:
```php
Schema::table('project_phases', function (Blueprint $table) {
    $table->enum('statut', ['planifie', 'en_cours', 'termine', 'suspendu'])->default('planifie');
    $table->text('description')->nullable();
});
```

3. Run the migration:
```bash
php artisan migrate
```

4. Update the model's `$fillable` array
5. Update factories and seeders
