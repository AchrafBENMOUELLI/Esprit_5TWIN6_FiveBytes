# Référence Complète des Routes - Module 5

## 📋 Vue d'ensemble

Ce document liste **toutes les routes** du module "Gestion 5 : Projets de Rénovation et Financement".

---

## 🌐 Routes Front Office (Citoyens & Visiteurs)

### Consultation Publique (Sans Auth)

| Méthode | URI | Nom | Contrôleur | Description |
|---------|-----|-----|------------|-------------|
| GET | `/projets` | `project.index` | ProjectController@index | Liste des projets publics |
| GET | `/projets/{id}` | `project.show` | ProjectController@show | Détails d'un projet |

### Système de Dons (Avec Auth)

| Méthode | URI | Nom | Contrôleur | Description |
|---------|-----|-----|------------|-------------|
| GET | `/projets/{id}/faire-un-don` | `project.donate` | FundingController@simulateDonation | Formulaire de don |
| GET | `/projets/{id}/confirmer-don` | `project.donate.confirm` | FundingController@confirmDonation | Confirmation don |
| POST | `/projets/don` | `project.donate.store` | FundingController@storeDonation | Enregistrer don |

### Historique Dons Personnel (Avec Auth)

| Méthode | URI | Nom | Contrôleur | Description |
|---------|-----|-----|------------|-------------|
| GET | `/mes-dons` | `donations.index` | FundingController@myDonations | Liste mes dons |
| GET | `/mes-dons/{id}` | `donations.show` | FundingController@showDonation | Détails d'un don |
| DELETE | `/mes-dons/{id}/cancel` | `donations.cancel` | FundingController@cancelDonation | Annuler don en attente |

### Statistiques Publiques (Optionnel)

| Méthode | URI | Nom | Contrôleur | Description |
|---------|-----|-----|------------|-------------|
| GET | `/statistiques/projets` | `stats.projects` | ProjectController@statistics | Stats globales projets |
| GET | `/statistiques/dons` | `stats.donations` | FundingController@donationStatistics | Impact des dons |

---

## 🔐 Routes Back Office (Admin & Gestionnaires)

### Projects - CRUD Complet

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/admin/projects` | `admin.project.index` | Liste tous les projets |
| GET | `/admin/projects/create` | `admin.project.create` | Formulaire création projet |
| POST | `/admin/projects` | `admin.project.store` | Enregistrer nouveau projet |
| GET | `/admin/projects/{id}` | `admin.project.show` | Détails d'un projet |
| GET | `/admin/projects/{id}/edit` | `admin.project.edit` | Formulaire édition projet |
| PUT | `/admin/projects/{id}` | `admin.project.update` | Mettre à jour projet |
| DELETE | `/admin/projects/{id}` | `admin.project.destroy` | Supprimer projet |

### Projects - Actions Spéciales

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| PATCH | `/admin/projects/{id}/archive` | `admin.project.archive` | Archiver un projet |
| PATCH | `/admin/projects/{id}/restore` | `admin.project.restore` | Restaurer un projet |
| PATCH | `/admin/projects/{id}/status` | `admin.project.update-status` | Changer statut rapidement |
| POST | `/admin/projects/{id}/duplicate` | `admin.project.duplicate` | Dupliquer un projet |
| GET | `/admin/projects/{id}/export` | `admin.project.export` | Exporter projet (PDF/Excel) |

### Contractors - CRUD Complet

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/admin/contractors` | `admin.contractor.index` | Liste entrepreneurs |
| GET | `/admin/contractors/create` | `admin.contractor.create` | Formulaire création |
| POST | `/admin/contractors` | `admin.contractor.store` | Enregistrer entrepreneur |
| GET | `/admin/contractors/{id}` | `admin.contractor.show` | Détails entrepreneur |
| GET | `/admin/contractors/{id}/edit` | `admin.contractor.edit` | Formulaire édition |
| PUT | `/admin/contractors/{id}` | `admin.contractor.update` | Mettre à jour |
| DELETE | `/admin/contractors/{id}` | `admin.contractor.destroy` | Supprimer |

### Project Phases - Routes Imbriquées

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/admin/projects/{id}/phases` | `admin.project.phase.index` | Liste phases du projet |
| GET | `/admin/projects/{id}/phases/create` | `admin.project.phase.create` | Formulaire création phase |
| POST | `/admin/projects/{id}/phases` | `admin.project.phase.store` | Enregistrer nouvelle phase |
| GET | `/admin/phases/{id}` | `admin.phase.show` | Détails d'une phase |
| GET | `/admin/phases/{id}/edit` | `admin.phase.edit` | Formulaire édition phase |
| PUT | `/admin/phases/{id}` | `admin.phase.update` | Mettre à jour phase |
| DELETE | `/admin/phases/{id}` | `admin.phase.destroy` | Supprimer phase |

### Fundings - Routes Imbriquées

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/admin/projects/{id}/fundings` | `admin.project.funding.index` | Liste financements du projet |
| GET | `/admin/projects/{id}/fundings/create` | `admin.project.funding.create` | Formulaire création financement |
| POST | `/admin/projects/{id}/fundings` | `admin.project.funding.store` | Enregistrer financement |
| GET | `/admin/fundings/{id}` | `admin.funding.show` | Détails d'un financement |
| GET | `/admin/fundings/{id}/edit` | `admin.funding.edit` | Formulaire édition |
| PUT | `/admin/fundings/{id}` | `admin.funding.update` | Mettre à jour |
| DELETE | `/admin/fundings/{id}` | `admin.funding.destroy` | Supprimer |
| PATCH | `/admin/fundings/{id}/approve` | `admin.funding.approve` | Approuver don citoyen |
| PATCH | `/admin/fundings/{id}/reject` | `admin.funding.reject` | Rejeter don citoyen |

### Documents - Routes Imbriquées avec Upload

| Méthode | URI | Nom | Description |
|---------|-----|-----|-------------|
| GET | `/admin/projects/{id}/documents` | `admin.project.document.index` | Liste documents du projet |
| GET | `/admin/projects/{id}/documents/create` | `admin.project.document.create` | Formulaire upload |
| POST | `/admin/projects/{id}/documents` | `admin.project.document.store` | Upload document |
| GET | `/admin/documents/{id}` | `admin.document.show` | Détails document |
| GET | `/admin/documents/{id}/edit` | `admin.document.edit` | Formulaire édition |
| PUT | `/admin/documents/{id}` | `admin.document.update` | Mettre à jour métadonnées |
| DELETE | `/admin/documents/{id}` | `admin.document.destroy` | Supprimer document |
| GET | `/admin/documents/{id}/download` | `admin.document.download` | Télécharger fichier |
| GET | `/admin/documents/{id}/preview` | `admin.document.preview` | Prévisualiser document |

---

## 📊 Statistiques des Routes

### Par Type

| Type | Nombre | Description |
|------|--------|-------------|
| **Front Office** | 11 | Routes publiques et citoyens |
| **Back Office** | 42+ | Routes admin et gestionnaires |
| **Total** | 53+ | Toutes les routes module 5 |

### Par Méthode HTTP

| Méthode | Utilisation |
|---------|-------------|
| **GET** | Affichage (index, show, create, edit) |
| **POST** | Création (store) |
| **PUT/PATCH** | Mise à jour (update, archive, approve) |
| **DELETE** | Suppression (destroy, cancel) |

### Par Middleware

| Middleware | Routes | Description |
|------------|--------|-------------|
| **Aucun** | 2 | Routes publiques (index, show projets) |
| **auth** | 9 | Routes front authentifiées (dons) |
| **auth + admin** | 42+ | Routes admin/gestionnaires |

---

## 🎯 Conventions de Nommage

### Schéma de Nommage

```
{scope}.{resource}.{action}
```

**Exemples:**
- `admin.project.index` - Admin, Projects, Liste
- `project.show` - Front, Project, Détails
- `admin.project.phase.create` - Admin, Phases d'un projet, Création

### Prefixes

| Prefix | Scope | Description |
|--------|-------|-------------|
| `admin.` | Back Office | Routes administratives |
| `project.` | Front Office | Routes projets publics |
| `donations.` | Front Office | Routes dons personnels |
| `stats.` | Front Office | Routes statistiques |

---

## 🛣️ Routes Imbriquées (Nested Routes)

### Pourquoi des Routes Imbriquées?

Les routes imbriquées expriment clairement les relations parent-enfant :

```
/admin/projects/{id}/phases       → "Les phases DU projet {id}"
/admin/projects/{id}/fundings     → "Les financements DU projet {id}"
/admin/projects/{id}/documents    → "Les documents DU projet {id}"
```

### Structure Hiérarchique

```
Project (Parent)
  ├── Phases (Enfant)
  ├── Fundings (Enfant)
  └── Documents (Enfant)
```

### Avantages

1. **Clarté**: URL lisible et logique
2. **Contexte**: Toujours savoir à quel projet appartient une ressource
3. **Sécurité**: Vérifier facilement les permissions
4. **UX**: Navigation intuitive (breadcrumbs faciles)

---

## 🔒 Middleware et Permissions

### Configuration Actuelle

#### routes/admin.php
```php
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    require __DIR__ . '/admin/project.php';
});
```

#### routes/front/project.php
```php
// Routes publiques (aucun middleware)
Route::prefix('projets')->name('project.')->group(function () {
    Route::get('/', ...);
    Route::get('/{project}', ...);
});

// Routes authentifiées
Route::middleware('auth')->group(function () {
    // Dons et historique
});
```

### TODO: Middleware de Rôle

Pour restreindre l'accès admin aux gestionnaires et admins uniquement :

```php
Route::middleware(['web', 'auth', 'role:gestionnaire,admin'])->prefix('admin')->group(function () {
    // Routes admin
});
```

---

## 📝 Exemples d'Utilisation

### Blade Templates

#### Générer des URLs

```blade
{{-- Front Office --}}
<a href="{{ route('project.index') }}">Voir tous les projets</a>
<a href="{{ route('project.show', $project) }}">Détails du projet</a>
<a href="{{ route('project.donate', $project) }}">Faire un don</a>
<a href="{{ route('donations.index') }}">Mes dons</a>

{{-- Back Office --}}
<a href="{{ route('admin.project.index') }}">Gérer les projets</a>
<a href="{{ route('admin.project.create') }}">Créer un projet</a>
<a href="{{ route('admin.project.edit', $project) }}">Modifier</a>
<a href="{{ route('admin.project.phase.index', $project) }}">Phases du projet</a>
<a href="{{ route('admin.project.phase.create', $project) }}">Ajouter une phase</a>
```

#### Formulaires

```blade
{{-- Formulaire de création --}}
<form action="{{ route('admin.project.store') }}" method="POST">
    @csrf
    <!-- Champs -->
    <button type="submit">Créer</button>
</form>

{{-- Formulaire de mise à jour --}}
<form action="{{ route('admin.project.update', $project) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- Champs -->
    <button type="submit">Mettre à jour</button>
</form>

{{-- Formulaire de suppression --}}
<form action="{{ route('admin.project.destroy', $project) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Supprimer</button>
</form>
```

### Contrôleurs

#### Redirections

```php
// Après création
return redirect()->route('admin.project.show', $project)
    ->with('success', 'Projet créé avec succès.');

// Après mise à jour
return redirect()->route('admin.project.index')
    ->with('success', 'Projet mis à jour.');

// Après suppression
return redirect()->route('admin.project.index')
    ->with('success', 'Projet supprimé.');
```

#### Vérifier la Route Actuelle

```php
// Dans un contrôleur
if (request()->routeIs('admin.project.show')) {
    // Code spécifique
}

// Dans une vue Blade
@if(request()->routeIs('admin.project.*'))
    <span class="active">Projets</span>
@endif
```

---

## 🧪 Test des Routes

### Commandes Artisan

```bash
# Lister toutes les routes
php artisan route:list

# Filtrer par nom
php artisan route:list --name=admin.project
php artisan route:list --name=project

# Filtrer par chemin
php artisan route:list --path=admin/projects
php artisan route:list --path=projets

# Filtrer par méthode
php artisan route:list --method=GET
php artisan route:list --method=POST

# Voir une route spécifique
php artisan route:list --name=admin.project.index
```

### Vérifier qu'une Route Existe

```bash
# PowerShell
php artisan route:list --name=admin.project.index

# Devrait afficher:
# GET /admin/projects ... admin.project.index › ProjectController@index
```

---

## 🚀 Nouvelles Routes Ajoutées

### Actions Spéciales Projects

- ✅ `admin.project.archive` - Archiver un projet
- ✅ `admin.project.restore` - Restaurer un projet archivé
- ✅ `admin.project.update-status` - Changer statut rapidement
- ✅ `admin.project.duplicate` - Dupliquer un projet
- ✅ `admin.project.export` - Exporter projet (PDF/Excel)

### Actions Fundings

- ✅ `admin.funding.approve` - Approuver un don
- ✅ `admin.funding.reject` - Rejeter un don

### Actions Documents

- ✅ `admin.document.preview` - Prévisualiser un document

### Routes Front Optionnelles

- ✅ `project.donate.confirm` - Confirmation avant don
- ✅ `donations.show` - Détails d'un don spécifique
- ✅ `donations.cancel` - Annuler un don en attente
- ✅ `stats.projects` - Statistiques projets
- ✅ `stats.donations` - Statistiques dons

---

## 📌 Notes Importantes

### Route Model Binding

Laravel utilise le **Route Model Binding** automatique :

```php
// Dans la route
Route::get('/admin/projects/{project}', [ProjectController::class, 'show']);

// Dans le contrôleur (injecte automatiquement le modèle)
public function show(Project $project) {
    // $project est déjà chargé depuis la BDD
}
```

### Soft Deletes (Si Implémenté)

Si vous implémentez les soft deletes sur les projets :

```php
// Migration
$table->softDeletes();

// Model
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model {
    use SoftDeletes;
}

// Routes archive/restore fonctionneront avec:
$project->delete();    // Soft delete
$project->restore();   // Restaurer
$project->forceDelete(); // Suppression permanente
```

---

## 🔗 Fichiers Connexes

- Routes Front: `routes/front/project.php`
- Routes Admin: `routes/admin/project.php`
- Routes Main: `routes/admin.php`, `routes/web.php`
- Contrôleurs: `app/Http/Controllers/Admin/Project/`, `app/Http/Controllers/Front/Project/`
- Documentation: `docs/ADMIN_CONTROLLERS_DOCUMENTATION.md`, `docs/FRONT_CONTROLLERS_DOCUMENTATION.md`

---

**Dernière mise à jour**: Routes complètement configurées avec conventions RESTful Laravel ✅
