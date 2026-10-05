# Guide de Référence Rapide - Module 5

## 🚀 Commandes Essentielles

### Installation et Configuration

```bash
# Installer les dépendances
composer install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Migrations
php artisan migrate

# Seeders
php artisan db:seed --class=InfrastructureModuleSeeder
php artisan db:seed --class=ProjectModuleSeeder

# Lien symbolique pour le storage
php artisan storage:link

# Lancer le serveur
php artisan serve
```

### Gestion de la Base de Données

```bash
# Recréer complètement la BDD
php artisan migrate:fresh --seed

# Exécuter un seeder spécifique
php artisan db:seed --class=ProjectModuleSeeder

# Rollback des migrations
php artisan migrate:rollback

# Voir l'état des migrations
php artisan migrate:status
```

### Cache et Optimisation

```bash
# Clear tous les caches
php artisan optimize:clear

# Clear les caches individuellement
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear

# Optimiser pour la production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Debugging

```bash
# Voir toutes les routes
php artisan route:list

# Voir les routes d'un préfixe spécifique
php artisan route:list --path=admin
php artisan route:list --path=projets

# Tinker (REPL Laravel)
php artisan tinker

# Voir les logs en temps réel
tail -f storage/logs/laravel.log
```

---

## 📁 Fichiers Importants

### Configuration

| Fichier | Description |
|---------|-------------|
| `.env` | Variables d'environnement (BDD, mail, etc.) |
| `config/app.php` | Configuration de l'application |
| `config/database.php` | Configuration de la base de données |
| `config/filesystems.php` | Configuration du stockage de fichiers |

### Modèles

| Fichier | Description |
|---------|-------------|
| `app/Models/Project/Project.php` | Modèle des projets |
| `app/Models/Project/Contractor.php` | Modèle des contractants |
| `app/Models/Project/ProjectPhase.php` | Modèle des phases |
| `app/Models/Project/Funding.php` | Modèle des financements |
| `app/Models/Project/ProjectDocument.php` | Modèle des documents |

### Controllers

| Fichier | Description |
|---------|-------------|
| `app/Http/Controllers/Admin/ProjectController.php` | CRUD projets (admin) |
| `app/Http/Controllers/Admin/ContractorController.php` | CRUD contractants |
| `app/Http/Controllers/Admin/ProjectPhaseController.php` | CRUD phases |
| `app/Http/Controllers/Admin/FundingController.php` | CRUD financements |
| `app/Http/Controllers/Admin/ProjectDocumentController.php` | CRUD documents |
| `app/Http/Controllers/Front/ProjectController.php` | Projets (public) |
| `app/Http/Controllers/Front/FundingController.php` | Dons (citoyens) |

### Vues

| Fichier | Description |
|---------|-------------|
| `resources/views/components/project/layouts/admin.blade.php` | Layout admin |
| `resources/views/components/project/layouts/front.blade.php` | Layout front |
| `resources/views/project/admin/projects/index.blade.php` | Liste projets (admin) |
| `resources/views/project/front/index.blade.php` | Liste projets (public) |
| `resources/views/project/front/donate.blade.php` | Formulaire de don |

### Routes

| Fichier | Description |
|---------|-------------|
| `routes/admin/project.php` | Routes administration |
| `routes/front/project.php` | Routes front office |

---

## 🔗 URLs Importantes

### Administration

| Page | URL | Rôle requis |
|------|-----|-------------|
| Liste des projets | `http://127.0.0.1:8000/admin/projects` | Admin/Gestionnaire |
| Créer un projet | `http://127.0.0.1:8000/admin/projects/create` | Admin/Gestionnaire |
| Détails d'un projet | `http://127.0.0.1:8000/admin/projects/{id}` | Admin/Gestionnaire |
| Liste des contractants | `http://127.0.0.1:8000/admin/contractors` | Admin/Gestionnaire |

### Front Office

| Page | URL | Rôle requis |
|------|-----|-------------|
| Liste des projets | `http://127.0.0.1:8000/projets` | Public |
| Détails d'un projet | `http://127.0.0.1:8000/projets/{id}` | Public |
| Faire un don | `http://127.0.0.1:8000/projets/{id}/faire-un-don` | Citoyen connecté |
| Mes dons | `http://127.0.0.1:8000/mes-dons` | Citoyen connecté |

---

## 👤 Comptes de Test

### Admin
- **Email:** `admin@test.com`
- **Mot de passe:** `password`
- **Rôle:** Admin
- **Permissions:** Accès complet au back office

### Citoyen
- **Email:** `citoyen@test.com`
- **Mot de passe:** `password`
- **Rôle:** Citoyen
- **Permissions:** Consultation projets + dons

### Créer un nouveau compte

```bash
php artisan tinker
```

```php
use App\Models\User;
use App\Enums\UserRole;

// Admin
User::create([
    'name' => 'Nom Utilisateur',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'role' => UserRole::ADMIN->value,
    'email_verified_at' => now(),
]);

// Citoyen
User::create([
    'name' => 'Nom Utilisateur',
    'email' => 'email@example.com',
    'password' => bcrypt('password'),
    'role' => UserRole::CITOYEN->value,
    'email_verified_at' => now(),
]);
```

---

## 🎨 Classes CSS Principales

### Layout

| Classe | Description |
|--------|-------------|
| `.aq-card` | Carte de base (fond blanc, bordure, ombre) |
| `.aq-card-header` | En-tête de carte |
| `.aq-card-title` | Titre de carte |
| `.aq-card-subtitle` | Sous-titre |
| `.aq-grid-2` | Grille 2 colonnes |
| `.aq-grid-3` | Grille 3 colonnes |
| `.aq-grid-4` | Grille 4 colonnes |

### Boutons

| Classe | Description |
|--------|-------------|
| `.aq-btn` | Bouton de base |
| `.aq-btn-primary` | Bouton primaire (bleu océan) |
| `.aq-btn-secondary` | Bouton secondaire |
| `.aq-btn-outline` | Bouton contour |
| `.aq-btn-danger` | Bouton danger (rouge) |
| `.aq-btn-success` | Bouton succès (vert) |
| `.aq-btn-block` | Bouton pleine largeur |
| `.aq-btn-sm` | Petit bouton |
| `.aq-btn-icon` | Bouton icône seule |

### Badges

| Classe | Description |
|--------|-------------|
| `.aq-badge` | Badge de base |
| `.aq-badge-primary` | Badge bleu océan |
| `.aq-badge-secondary` | Badge gris |
| `.aq-badge-success` | Badge vert |
| `.aq-badge-warning` | Badge orange |
| `.aq-badge-danger` | Badge rouge |
| `.aq-badge-info` | Badge aqua |

### Formulaires

| Classe | Description |
|--------|-------------|
| `.aq-form` | Formulaire de base |
| `.aq-form-group` | Groupe de champ |
| `.aq-form-label` | Label de champ |
| `.aq-form-control` | Input/Select/Textarea |
| `.aq-form-error` | État d'erreur (bordure rouge) |
| `.aq-error-message` | Message d'erreur (texte rouge) |
| `.aq-form-help` | Texte d'aide (gris) |
| `.aq-form-actions` | Zone d'actions du formulaire |
| `.aq-required` | Indicateur requis (*) |

### Alerts

| Classe | Description |
|--------|-------------|
| `.aq-alert` | Alert de base |
| `.aq-alert-success` | Alert succès (vert) |
| `.aq-alert-warning` | Alert avertissement (orange) |
| `.aq-alert-danger` | Alert danger (rouge) |
| `.aq-alert-info` | Alert info (bleu) |

### Autres

| Classe | Description |
|--------|-------------|
| `.aq-progress` | Container de barre de progression |
| `.aq-progress-bar` | Barre de progression |
| `.aq-table` | Table de base |
| `.aq-table-responsive` | Container responsive pour table |
| `.aq-stat-card` | Carte de statistique |
| `.aq-icon` | Icône SVG |
| `.aq-text-muted` | Texte grisé |

---

## 🎨 Palette de Couleurs

### Couleurs Principales

```css
--navy: #0b2545      /* Bleu foncé (titres, texte important) */
--ocean: #1565c0     /* Bleu océan (boutons primaires, liens) */
--aqua: #00b8d9      /* Aqua (accents, badges info) */
--bg: #f4f8fb        /* Fond clair */
```

### Couleurs de Statut

```css
--success: #2e9e5b   /* Vert (succès, confirmé) */
--warning: #f59e0b   /* Orange (avertissement, en attente) */
--danger: #d93b3b    /* Rouge (danger, erreur, refusé) */
```

### Couleurs de Texte

```css
--text: #1e293b      /* Texte principal (noir grisé) */
--text-secondary: #64748b  /* Texte secondaire */
--text-muted: #94a3b8      /* Texte grisé (labels, help) */
--border: #e2e8f0    /* Bordures */
```

### Utilisation dans le HTML

```html
<!-- Inline styles -->
<div style="color: var(--navy);">Texte en navy</div>
<button style="background: var(--ocean);">Bouton ocean</button>

<!-- Classes CSS -->
<span class="aq-badge aq-badge-success">Succès</span>
<p class="aq-text-muted">Texte grisé</p>
```

---

## 📊 Données de Test

### Créer des projets de test

```bash
php artisan tinker
```

```php
use App\Models\Project\Project;
use App\Models\Infrastructure\Zone;
use App\Models\Infrastructure\Infrastructure;
use App\Models\User;

// Récupérer une zone, infrastructure et responsable
$zone = Zone::first();
$infrastructure = Infrastructure::first();
$responsable = User::where('role', 'admin')->first();

// Créer un projet
Project::create([
    'titre' => 'Test Projet',
    'type' => 'réparation',
    'description' => 'Ceci est un projet de test',
    'budget_prevu' => 100000,
    'date_debut' => now(),
    'date_fin_prevue' => now()->addMonths(6),
    'statut' => 'planifié',
    'avancement_pourcentage' => 0,
    'zone_id' => $zone->id,
    'infrastructure_id' => $infrastructure->id,
    'responsable_id' => $responsable->id,
]);
```

### Créer un don de test

```php
use App\Models\Project\Funding;

Funding::create([
    'project_id' => 1, // ID du projet
    'source' => 'don',
    'montant' => 100,
    'date_obtention' => now(),
    'statut' => 'en_attente',
    'donateur_id' => 2, // ID du citoyen
    'description' => 'Don de test',
]);
```

---

## 🔍 Recherche et Filtres

### Recherche dans les projets (admin)

```
URL: http://127.0.0.1:8000/admin/projects?search=rénovation
```

### Filtrer par statut

```
URL: http://127.0.0.1:8000/admin/projects?statut=en_cours
```

### Filtrer par type

```
URL: http://127.0.0.1:8000/admin/projects?type=modernisation
```

### Combiner plusieurs filtres

```
URL: http://127.0.0.1:8000/admin/projects?search=eau&statut=en_cours&type=réparation
```

---

## 🐛 Débogage Commun

### Erreur: "Class not found"

```bash
# Reconstruire l'autoloader
composer dump-autoload
```

### Erreur: "Target class [Controller] does not exist"

Vérifier que le namespace est correct dans le controller:

```php
namespace App\Http\Controllers\Admin;
```

### Erreur: "Undefined variable"

Vérifier que la variable est passée à la vue:

```php
// Controller
return view('project.admin.projects.index', compact('projects'));
```

### Erreur: "Foreign key constraint fails"

```bash
# Vérifier l'ordre des migrations
# Recréer la BDD
php artisan migrate:fresh --seed
```

### Erreur: "Storage link not found"

```bash
# Créer le lien symbolique
php artisan storage:link
```

### CSS ne se charge pas

```bash
# Clear le cache des vues
php artisan view:clear

# Vérifier que le fichier CSS existe
ls -la resources/views/components/project/layouts/
```

---

## 📈 Statistiques du Module

### Backend

- **Migrations:** 5 tables
- **Models:** 5 models avec relations
- **Factories:** 5 factories
- **Seeders:** 1 seeder principal (30 projets, 15 contractants)
- **Form Requests:** 6 form requests avec validation
- **Controllers Admin:** 5 controllers (36 méthodes CRUD)
- **Controllers Front:** 2 controllers (8 méthodes)
- **Routes:** 53+ routes (33 admin, 5 front, reste auth)

### Frontend

- **Layouts:** 2 layouts (admin + front) + 2 CSS
- **Vues Admin:** 5 vues principales
- **Vues Front:** 4 vues principales
- **Composants CSS:** 60+ classes réutilisables
- **Icônes SVG:** 40+ icônes inline
- **Lignes de code:** ~4800 lignes (PHP + Blade + CSS)

### Documentation

- **Fichiers Markdown:** 11 fichiers
- **Pages documentées:** ~50 pages
- **Lignes de documentation:** ~3000 lignes

---

## ✅ Checklist de Déploiement

### Avant le déploiement

- [ ] Tous les tests passent
- [ ] Les seeders fonctionnent
- [ ] Les routes sont testées
- [ ] Les formulaires valident correctement
- [ ] Les messages flash s'affichent
- [ ] Le responsive fonctionne
- [ ] Les uploads de fichiers fonctionnent
- [ ] Les permissions sont correctes

### Configuration de production

```bash
# .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Optimisations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Après le déploiement

- [ ] Migrations exécutées
- [ ] Seeders exécutés (si nécessaire)
- [ ] Lien storage créé
- [ ] SSL configuré
- [ ] Backups configurés
- [ ] Monitoring configuré
- [ ] Logs vérifiés

---

## 📞 Ressources

### Documentation du Projet

- `docs/README_MODULE_5.md` - Guide principal
- `docs/TESTING_VIEWS_GUIDE.md` - Guide de test complet
- `docs/VIEWS_DOCUMENTATION.md` - Documentation des vues

### Ressources Laravel

- **Documentation:** https://laravel.com/docs
- **Blade Templates:** https://laravel.com/docs/blade
- **Eloquent ORM:** https://laravel.com/docs/eloquent
- **Validation:** https://laravel.com/docs/validation

### Outils Utiles

- **Laravel Debugbar:** `composer require barryvdh/laravel-debugbar --dev`
- **Laravel IDE Helper:** `composer require barryvdh/laravel-ide-helper --dev`
- **PHP CS Fixer:** `composer require friendsofphp/php-cs-fixer --dev`

---

**Version:** 1.0  
**Dernière mise à jour:** 2026-10-05  
**Créé par:** Kiro AI Agent
