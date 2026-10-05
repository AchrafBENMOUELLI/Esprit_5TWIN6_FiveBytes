# Structure des Modèles - Gestion 5 : Projets de Rénovation et Financement

## 📦 Modèles Créés

### 1. **Contractor** (`App\Models\Project\Contractor`)

**Attributs fillable:**
- nom (string, 100)
- specialite (string, 100)
- email (string, unique)
- telephone (string, 20)
- adresse (text)

**Fonctionnalités:**
- ✅ Email automatiquement converti en minuscules via mutateur
- ✅ Validation du format email avec `isValidEmail()`
- ✅ Attribut calculé `projects_count` pour compter les projets

**Relations:**
- `projectPhases()` → HasMany vers ProjectPhase
- Permet de récupérer toutes les phases confiées au prestataire

---

### 2. **Project** (`App\Models\Project\Project`)

**Attributs fillable:**
- titre (string, 200)
- type (enum)
- description (text)
- budget_prevu (decimal, 15,2)
- date_debut (date)
- date_fin_prevue (date)
- statut (enum)
- avancement_pourcentage (integer)
- zone_id (foreignId)
- infrastructure_id (foreignId, nullable)
- responsable_id (foreignId)

**Casts:**
- budget_prevu → decimal:2
- avancement_pourcentage → integer
- date_debut → date
- date_fin_prevue → date

**Relations:**
- `zone()` → BelongsTo Zone
- `infrastructure()` → BelongsTo Infrastructure (nullable)
- `responsable()` → BelongsTo User
- `projectPhases()` → HasMany ProjectPhase
- `fundings()` → HasMany Funding
- `projectDocuments()` → HasMany ProjectDocument

**Méthodes Calculées:**
- ✅ `budgetTotal()` : Somme des coûts de toutes les phases
- ✅ `fundingTotal()` : Somme de tous les financements reçus
- ✅ `budgetRemaining()` : Financements - Coûts des phases
- ✅ `budgetDifference()` : Financements - Budget prévu
- ✅ `isOverBudget()` : Vérifie si les coûts dépassent le budget prévu
- ✅ `isFullyFunded()` : Vérifie si le projet est entièrement financé

---

### 3. **ProjectPhase** (`App\Models\Project\ProjectPhase`)

**Attributs fillable:**
- project_id (foreignId)
- contractor_id (foreignId)
- nom (string, 150)
- date_debut (date)
- date_fin (date)
- cout (decimal, 15,2)
- avancement (integer)

**Casts:**
- cout → decimal:2
- avancement → integer
- date_debut → date
- date_fin → date

**Relations:**
- `project()` → BelongsTo Project
- `contractor()` → BelongsTo Contractor

**Méthodes Utilitaires:**
- ✅ `getDurationInDays()` : Calcule la durée en jours
- ✅ `isCompleted()` : Vérifie si la phase est terminée (100%)
- ✅ `isOverdue()` : Vérifie si la phase est en retard

---

### 4. **Funding** (`App\Models\Project\Funding`)

**Attributs fillable:**
- project_id (foreignId)
- source (enum: 'municipal', 'régional', 'fédéral', 'européen', 'privé', 'don')
- donateur_id (foreignId, nullable)
- montant (decimal, 15,2)
- date_versement (date)

**Casts:**
- montant → decimal:2
- date_versement → date

**Relations:**
- `project()` → BelongsTo Project
- `donateur()` → BelongsTo User (nullable)

**Méthodes Utilitaires:**
- ✅ `isDonation()` : Vérifie si c'est un don
- ✅ `isPublicFunding()` : Vérifie si c'est un financement public
- ✅ `getSourceLabel()` : Retourne le label en français de la source

---

### 5. **ProjectDocument** (`App\Models\Project\ProjectDocument`)

**Attributs fillable:**
- project_id (foreignId)
- titre (string, 200)
- chemin_fichier (string, 500)
- type (enum: 'rapport', 'photo', 'facture', 'contrat', 'plan', 'autre')

**Relations:**
- `project()` → BelongsTo Project

**Méthodes Fichiers:**
- ✅ `getFileExtension()` : Récupère l'extension du fichier
- ✅ `getFileSize()` : Récupère la taille en bytes
- ✅ `getFileSizeFormatted()` : Taille formatée (KB, MB, GB)
- ✅ `getDownloadUrl()` : URL de téléchargement
- ✅ `fileExists()` : Vérifie si le fichier existe
- ✅ `getTypeLabel()` : Label français du type
- ✅ `getIconClass()` : Classe d'icône Font Awesome selon l'extension

---

## 🔗 Relations Inverses Ajoutées

### **User** (`App\Models\User`)
```php
// Projets dont l'utilisateur est responsable
public function responsableProjects() → HasMany Project

// Dons effectués par l'utilisateur (citoyens)
public function donations() → HasMany Funding
```

### **Zone** (`App\Models\Infrastructure\Zone`)
```php
// Projets dans cette zone
public function projects() → HasMany Project
```

### **Infrastructure** (`App\Models\Infrastructure\Infrastructure`)
```php
// Projets liés à cette infrastructure
public function projects() → HasMany Project
```

---

## 🎯 Diagramme des Relations

```
┌──────────────┐
│     Zone     │
└──────┬───────┘
       │ 1:N
       ▼
┌──────────────┐       ┌──────────────┐
│Infrastructure│       │     User     │
└──────┬───────┘       └──────┬───────┘
       │ 1:N (nullable)       │ 1:N (responsable)
       │                      │
       │         ┌────────────┴────────────┐
       │         │                         │
       └─────────►     Project     ◄───────┘
                 └──────┬──────────┘
                        │
         ┌──────────────┼──────────────┬────────────────┐
         │ 1:N          │ 1:N          │ 1:N            │
         ▼              ▼              ▼                ▼
   ┌──────────┐  ┌──────────┐  ┌──────────┐     ┌──────────┐
   │ Funding  │  │  Phase   │  │ Document │     │ User     │
   └──────────┘  └────┬─────┘  └──────────┘     │(donateur)│
                      │ N:1                       └──────────┘
                      ▼
                 ┌──────────┐
                 │Contractor│
                 └──────────┘
```

---

## ✅ Validation des Critères

| Critère | Status | Détails |
|---------|--------|---------|
| **Namespace correct** | ✅ | `App\Models\Project` |
| **$fillable définis** | ✅ | Tous les attributs mass-assignables |
| **Casts configurés** | ✅ | Decimal, integer, date selon spécifications |
| **Relations belongsTo** | ✅ | Project → Zone, Infrastructure, User |
| **Relations hasMany** | ✅ | Project → Phases, Fundings, Documents |
| **Méthodes calculées** | ✅ | budgetTotal(), fundingTotal(), budgetRemaining() |
| **Email lowercase** | ✅ | Mutateur dans Contractor |
| **Validation email** | ✅ | Méthode isValidEmail() |
| **File methods** | ✅ | getFileExtension(), getFileSize() |
| **Relations inverses** | ✅ | User, Zone, Infrastructure |

---

## 🚀 Prochaines Étapes

1. ✅ Migrations créées et exécutées
2. ✅ Modèles Eloquent créés avec relations
3. ⏭️ Créer les Factories (Étape 4)
4. ⏭️ Créer les Seeders (Étape 5)
5. ⏭️ Form Requests de validation (Étape 6)

---

## 💡 Exemples d'Utilisation

### Récupérer un projet avec toutes ses relations
```php
$project = Project::with(['zone', 'infrastructure', 'responsable', 'projectPhases.contractor', 'fundings.donateur', 'projectDocuments'])
    ->find($id);

// Calculs
$totalBudget = $project->budgetTotal();
$totalFunding = $project->fundingTotal();
$remaining = $project->budgetRemaining();

// Vérifications
if ($project->isOverBudget()) {
    // Le projet dépasse le budget
}

if ($project->isFullyFunded()) {
    // Le projet est entièrement financé
}
```

### Récupérer les projets d'une zone
```php
$zone = Zone::find($zoneId);
$projects = $zone->projects()
    ->where('statut', 'en_cours')
    ->with('responsable')
    ->get();
```

### Récupérer les dons d'un citoyen
```php
$user = Auth::user();
$donations = $user->donations()
    ->with('project')
    ->orderBy('date_versement', 'desc')
    ->get();
```

### Récupérer les phases d'un prestataire
```php
$contractor = Contractor::find($id);
$phases = $contractor->projectPhases()
    ->with('project')
    ->where('avancement', '<', 100)
    ->get();

$projectsCount = $contractor->projects_count;
```

---

**Date de création:** 2026-10-05  
**Module:** Gestion 5 - Projets de Rénovation et Financement  
**Statut:** ✅ Modèles complétés et testés
