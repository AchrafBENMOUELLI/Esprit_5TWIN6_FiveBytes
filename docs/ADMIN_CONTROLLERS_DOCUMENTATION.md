# Documentation des Contrôleurs Admin - Module 5

## 📋 Vue d'ensemble

Ce document décrit tous les contrôleurs créés pour l'administration (Back Office) du module "Gestion 5 : Projets de Rénovation et Financement".

---

## 🎯 Contrôleurs Créés

### 1. ProjectController (Resource Controller)
**Fichier**: `app/Http/Controllers/Admin/Project/ProjectController.php`

**Namespace**: `App\Http\Controllers\Admin\Project`

#### Méthodes:

| Méthode | Route | Description |
|---------|-------|-------------|
| `index()` | GET /admin/projects | Liste paginée avec filtres (statut, type, zone) et recherche |
| `create()` | GET /admin/projects/create | Formulaire de création |
| `store()` | POST /admin/projects | Enregistrement nouveau projet |
| `show()` | GET /admin/projects/{id} | Détails complets du projet |
| `edit()` | GET /admin/projects/{id}/edit | Formulaire d'édition |
| `update()` | PUT /admin/projects/{id} | Mise à jour projet |
| `destroy()` | DELETE /admin/projects/{id} | Suppression avec vérification dépendances |

#### Fonctionnalités:
- ✅ **Filtres**: statut, type, zone
- ✅ **Recherche**: titre, description
- ✅ **Pagination**: 15 projets par page
- ✅ **Eager loading**: zone, infrastructure, responsable
- ✅ **Validation**: StoreProjectRequest, UpdateProjectRequest
- ✅ **Messages flash**: succès et erreurs
- ✅ **Vérification dépendances**: empêche suppression si phases/fundings/documents existent

#### Dépendances injectées:
```php
$zones = Zone::all();
$infrastructures = Infrastructure::all();
$gestionnaires = User::where('role', UserRole::Gestionnaire)->get();
```

---

### 2. ContractorController (Resource Controller)
**Fichier**: `app/Http/Controllers/Admin/Project/ContractorController.php`

#### Méthodes:

| Méthode | Route | Description |
|---------|-------|-------------|
| `index()` | GET /admin/contractors | Liste avec recherche et nombre de phases |
| `create()` | GET /admin/contractors/create | Formulaire de création |
| `store()` | POST /admin/contractors | Enregistrement entrepreneur |
| `show()` | GET /admin/contractors/{id} | Détails et phases associées |
| `edit()` | GET /admin/contractors/{id}/edit | Formulaire d'édition |
| `update()` | PUT /admin/contractors/{id} | Mise à jour |
| `destroy()` | DELETE /admin/contractors/{id} | Suppression avec vérification |

#### Fonctionnalités:
- ✅ **Recherche**: nom, spécialité, email
- ✅ **Filtre**: spécialité
- ✅ **Count**: nombre de phases associées (`withCount('projectPhases')`)
- ✅ **Validation**: StoreContractorRequest, UpdateContractorRequest
- ✅ **Vérification**: empêche suppression si phases associées

---

### 3. ProjectPhaseController
**Fichier**: `app/Http/Controllers/Admin/Project/ProjectPhaseController.php`

#### Méthodes:

| Méthode | Route | Description |
|---------|-------|-------------|
| `index()` | GET /admin/projects/{projectId}/phases | Liste phases d'un projet |
| `create()` | GET /admin/projects/{projectId}/phases/create | Formulaire de création |
| `store()` | POST /admin/phases | Enregistrement nouvelle phase |
| `edit()` | GET /admin/phases/{id}/edit | Formulaire d'édition |
| `update()` | PUT /admin/phases/{id} | Mise à jour phase |
| `destroy()` | DELETE /admin/phases/{id} | Suppression phase |

#### Fonctionnalités:
- ✅ **Contexte projet**: charge toujours le projet parent
- ✅ **Dropdowns**: liste des entrepreneurs
- ✅ **Validation**: StoreProjectPhaseRequest
- ✅ **Redirection**: vers la page du projet après chaque action

#### Dépendances:
```php
$contractors = Contractor::orderBy('nom')->get();
```

---

### 4. FundingController
**Fichier**: `app/Http/Controllers/Admin/Project/FundingController.php`

#### Méthodes:

| Méthode | Route | Description |
|---------|-------|-------------|
| `index()` | GET /admin/projects/{projectId}/fundings | Liste financements projet |
| `create()` | GET /admin/projects/{projectId}/fundings/create | Formulaire création |
| `store()` | POST /admin/fundings | Enregistrement financement |
| `edit()` | GET /admin/fundings/{id}/edit | Formulaire édition |
| `update()` | PUT /admin/fundings/{id} | Mise à jour |
| `destroy()` | DELETE /admin/fundings/{id} | Suppression |

#### Fonctionnalités:
- ✅ **Contexte projet**: charge le projet parent
- ✅ **Dropdowns**: liste des donateurs potentiels
- ✅ **Validation**: StoreFundingRequest (avec validation conditionnelle donateur_id)
- ✅ **Messages**: affiche montant formaté

#### Dépendances:
```php
$donateurs = User::whereHas('donations')->orWhere('id', '>', 0)->orderBy('name')->get();
```

---

### 5. ProjectDocumentController
**Fichier**: `app/Http/Controllers/Admin/Project/ProjectDocumentController.php`

#### Méthodes:

| Méthode | Route | Description |
|---------|-------|-------------|
| `index()` | GET /admin/projects/{projectId}/documents | Liste documents projet |
| `create()` | GET /admin/projects/{projectId}/documents/create | Formulaire upload |
| `store()` | POST /admin/documents | Upload et enregistrement |
| `edit()` | GET /admin/documents/{id}/edit | Formulaire édition métadonnées |
| `update()` | PUT /admin/documents/{id} | Mise à jour métadonnées |
| `destroy()` | DELETE /admin/documents/{id} | Suppression fichier + BDD |
| `download()` | GET /admin/documents/{id}/download | Téléchargement fichier |

#### Fonctionnalités Upload:
- ✅ **Validation fichier**: max 10 Mo, types autorisés (pdf, doc, docx, xls, xlsx, jpg, jpeg, png, gif)
- ✅ **Nom unique**: slug + timestamp
- ✅ **Stockage**: `storage/app/public/projects/{projectId}/`
- ✅ **Suppression**: fichier + enregistrement BDD
- ✅ **Téléchargement**: avec nom original

#### Validation personnalisée:
```php
'fichier' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif'
```

---

## 🛣️ Routes Admin

**Fichier**: `routes/admin/project.php`

### Routes Projects (Resource):
```
GET     /admin/projects                    admin.project.index
GET     /admin/projects/create             admin.project.create
POST    /admin/projects                    admin.project.store
GET     /admin/projects/{id}               admin.project.show
GET     /admin/projects/{id}/edit          admin.project.edit
PUT     /admin/projects/{id}               admin.project.update
DELETE  /admin/projects/{id}               admin.project.destroy
```

### Routes Contractors (Resource):
```
GET     /admin/contractors                 admin.contractor.index
GET     /admin/contractors/create          admin.contractor.create
POST    /admin/contractors                 admin.contractor.store
GET     /admin/contractors/{id}            admin.contractor.show
GET     /admin/contractors/{id}/edit       admin.contractor.edit
PUT     /admin/contractors/{id}            admin.contractor.update
DELETE  /admin/contractors/{id}            admin.contractor.destroy
```

### Routes Phases:
```
GET     /admin/projects/{projectId}/phases                admin.phase.index
GET     /admin/projects/{projectId}/phases/create         admin.phase.create
POST    /admin/phases                                     admin.phase.store
GET     /admin/phases/{id}/edit                           admin.phase.edit
PUT     /admin/phases/{id}                                admin.phase.update
DELETE  /admin/phases/{id}                                admin.phase.destroy
```

### Routes Fundings:
```
GET     /admin/projects/{projectId}/fundings              admin.funding.index
GET     /admin/projects/{projectId}/fundings/create       admin.funding.create
POST    /admin/fundings                                   admin.funding.store
GET     /admin/fundings/{id}/edit                         admin.funding.edit
PUT     /admin/fundings/{id}                              admin.funding.update
DELETE  /admin/fundings/{id}                              admin.funding.destroy
```

### Routes Documents:
```
GET     /admin/projects/{projectId}/documents             admin.document.index
GET     /admin/projects/{projectId}/documents/create      admin.document.create
POST    /admin/documents                                  admin.document.store
GET     /admin/documents/{id}/edit                        admin.document.edit
PUT     /admin/documents/{id}                             admin.document.update
DELETE  /admin/documents/{id}                             admin.document.destroy
GET     /admin/documents/{id}/download                    admin.document.download
```

---

## 🔒 Middleware & Sécurité

### Middleware appliqué:
```php
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    // Toutes les routes admin
});
```

### Dans chaque contrôleur:
```php
public function __construct()
{
    $this->middleware('auth');
}
```

### TODO: Ajouter middleware de rôle
Pour restreindre l'accès aux gestionnaires/admins uniquement:
```php
Route::middleware(['web', 'auth', 'role:gestionnaire,admin'])->prefix('admin')->group(function () {
    // Routes admin
});
```

---

## 💬 Messages Flash

### Types de messages utilisés:

#### Succès:
```php
->with('success', 'Le projet "' . $project->titre . '" a été créé avec succès.')
```

#### Erreurs:
```php
->with('error', 'Impossible de supprimer ce projet car il contient des phases...')
```

### Affichage dans les vues:
```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

---

## 📦 Dépendances Entre Contrôleurs

### Hiérarchie:
```
Project
  ├── ProjectPhase → Contractor
  ├── Funding → User (donateur)
  └── ProjectDocument
```

### Règles de suppression:
1. **Project**: ne peut être supprimé si phases/fundings/documents existent
2. **Contractor**: ne peut être supprimé si phases associées existent
3. **ProjectPhase**: suppression libre, recalcule automatiquement budgetTotal()
4. **Funding**: suppression libre, recalcule automatiquement fundingTotal()
5. **ProjectDocument**: supprime fichier + enregistrement BDD

---

## 🎨 Flux de Travail Admin

### Création d'un projet complet:

1. **Créer le projet** (`admin.project.create`)
   - Remplir titre, description, budget, dates
   - Sélectionner zone, infrastructure (optionnel), responsable
   
2. **Ajouter des phases** (`admin.phase.create`)
   - Pour chaque phase: nom, dates, coût, entrepreneur
   
3. **Ajouter des financements** (`admin.funding.create`)
   - Source, montant, statut, donateur (si don)
   
4. **Uploader des documents** (`admin.document.create`)
   - Fichiers: cahiers des charges, plans, rapports, photos

### Édition:
- Modifier projet: dates, budget, statut, avancement
- Modifier phases: dates, coûts, entrepreneurs
- Modifier financements: montants, statuts
- Modifier documents: métadonnées uniquement (nom, type, description)

### Suppression:
- Supprimer dans l'ordre: documents → phases → financements → projet

---

## 🔍 Validation

### Form Requests utilisés:
- `StoreProjectRequest` - Création projet
- `UpdateProjectRequest` - Mise à jour projet
- `StoreContractorRequest` - Création entrepreneur
- `UpdateContractorRequest` - Mise à jour entrepreneur
- `StoreProjectPhaseRequest` - Phases
- `StoreFundingRequest` - Financements (avec validation conditionnelle)

### Validation inline:
- **ProjectDocumentController**: validation fichier upload directement dans le contrôleur

---

## 📊 Calculs Automatiques

### Dans Project model:
```php
$project->budgetTotal()     // Somme des coûts des phases
$project->fundingTotal()    // Somme des montants de financement
$project->budgetRemaining() // fundingTotal() - budgetTotal()
```

Ces méthodes sont utilisées dans les vues pour afficher:
- Budget prévisionnel
- Budget réel (somme phases)
- Financement obtenu
- Budget restant à financer

---

## 🚀 Prochaines Étapes

### 1. Créer les vues admin (Blade templates)
- [ ] `components/project/admin/index.blade.php`
- [ ] `components/project/admin/create.blade.php`
- [ ] `components/project/admin/edit.blade.php`
- [ ] `components/project/admin/show.blade.php`
- [ ] Vues pour contractors, phases, fundings, documents

### 2. Ajouter middleware de rôle
```bash
php artisan make:middleware CheckRole
```

### 3. Créer les composants Blade réutilisables
- Formulaire de projet
- Tableau de phases
- Liste de financements
- Galerie de documents

### 4. Ajouter JavaScript pour UX
- Confirmation de suppression
- Upload progressif de fichiers
- Validation côté client

### 5. Tests
- Tests unitaires des contrôleurs
- Tests de validation
- Tests d'upload de fichiers

---

## 📝 Exemples de Requêtes

### Lister projets avec filtres:
```
GET /admin/projects?statut=en_cours&zone_id=5&search=renovation
```

### Créer une phase:
```
POST /admin/phases
{
    "project_id": 1,
    "contractor_id": 3,
    "nom": "Phase 1 - Études",
    "date_debut": "2026-11-01",
    "date_fin": "2026-12-01",
    "cout": 15000.00,
    "avancement": 0
}
```

### Uploader un document:
```
POST /admin/documents
{
    "project_id": 1,
    "nom": "Cahier des charges",
    "type_document": "cahier_charges",
    "description": "Spécifications techniques",
    "fichier": [file upload]
}
```

---

## 🔗 Fichiers Connexes

- Migrations: `database/migrations/2026_10_05_*.php`
- Models: `app/Models/Project/*.php`
- Form Requests: `app/Http/Requests/Project/*.php`
- Routes: `routes/admin/project.php`, `routes/admin.php`
- Documentation: `docs/DATABASE_SCHEMA_REFERENCE.md`
