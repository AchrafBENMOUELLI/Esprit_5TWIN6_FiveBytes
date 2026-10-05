# Module 5 - Gestion des Projets de Rénovation et Financement

## 📋 Vue d'ensemble

Le Module 5 "Gestion des Projets de Rénovation et Financement" est un système complet permettant de gérer les projets de rénovation des infrastructures hydrauliques et leur financement participatif.

### Fonctionnalités Principales

#### 👨‍💼 Administration (Back Office)
- Gestion complète des projets (CRUD)
- Gestion des contractants
- Gestion des phases de projet
- Gestion des financements
- Upload et gestion de documents
- Approbation/Refus des dons citoyens
- Statistiques et tableaux de bord

#### 🌐 Front Office (Citoyens)
- Consultation des projets de rénovation
- Détails complets des projets (phases, budget, avancement)
- Système de don participatif
- Suivi de ses propres contributions
- Téléchargement de documents publics

---

## 📁 Structure du Module

```
app/
├── Enums/
│   └── UserRole.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── ProjectController.php
│   │   │   ├── ContractorController.php
│   │   │   ├── ProjectPhaseController.php
│   │   │   ├── FundingController.php
│   │   │   └── ProjectDocumentController.php
│   │   └── Front/
│   │       ├── ProjectController.php
│   │       └── FundingController.php
│   └── Requests/
│       ├── StoreProjectRequest.php
│       ├── UpdateProjectRequest.php
│       ├── StoreContractorRequest.php
│       ├── UpdateContractorRequest.php
│       ├── StoreProjectPhaseRequest.php
│       └── StoreFundingRequest.php
└── Models/
    └── Project/
        ├── Project.php
        ├── Contractor.php
        ├── ProjectPhase.php
        ├── Funding.php
        └── ProjectDocument.php

database/
├── factories/
│   ├── ContractorFactory.php
│   ├── ProjectFactory.php
│   ├── ProjectPhaseFactory.php
│   ├── FundingFactory.php
│   └── ProjectDocumentFactory.php
├── migrations/
│   ├── 2024_01_10_000001_create_contractors_table.php
│   ├── 2024_01_10_000002_create_projects_table.php
│   ├── 2024_01_10_000003_create_project_phases_table.php
│   ├── 2024_01_10_000004_create_fundings_table.php
│   └── 2024_01_10_000005_create_project_documents_table.php
└── seeders/
    └── ProjectModuleSeeder.php

routes/
├── admin/
│   └── project.php
└── front/
    └── project.php

resources/
└── views/
    ├── components/
    │   └── project/
    │       └── layouts/
    │           ├── admin.blade.php
    │           ├── admin.css
    │           ├── front.blade.php
    │           └── front.css
    └── project/
        ├── admin/
        │   ├── projects/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   ├── edit.blade.php
        │   │   └── show.blade.php
        │   └── contractors/
        │       └── index.blade.php
        └── front/
            ├── index.blade.php
            ├── show.blade.php
            ├── donate.blade.php
            └── my-donations.blade.php

docs/
├── README_MODULE_5.md (ce fichier)
├── GESTION_5_IMPLEMENTATION_GUIDE.md
├── DATABASE_SCHEMA_REFERENCE.md
├── ADMIN_CONTROLLERS_DOCUMENTATION.md
├── FRONT_CONTROLLERS_DOCUMENTATION.md
├── ROUTES_REFERENCE.md
├── ROUTES_VISUAL_MAP.md
├── LAYOUTS_DOCUMENTATION.md
├── VIEWS_DOCUMENTATION.md
├── VIEWS_COMPLETION_SUMMARY.md
└── TESTING_VIEWS_GUIDE.md
```

---

## 🚀 Démarrage Rapide

### 1. Installation

```bash
# Installer les dépendances
composer install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aquasecure
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Migrations et Seeders

```bash
# Exécuter les migrations
php artisan migrate

# Seeder pour l'infrastructure (zones, infrastructures)
php artisan db:seed --class=InfrastructureModuleSeeder

# Seeder pour le module 5
php artisan db:seed --class=ProjectModuleSeeder
```

Ce seeder va créer:
- 15 contractants
- 30 projets de rénovation
- ~60 phases de projet
- ~40 financements
- ~50 documents

### 3. Créer un utilisateur de test

```bash
php artisan tinker
```

```php
// Créer un admin
use App\Models\User;
use App\Enums\UserRole;

User::create([
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => UserRole::ADMIN->value,
    'email_verified_at' => now(),
]);

// Créer un citoyen
User::create([
    'name' => 'Citoyen Test',
    'email' => 'citoyen@test.com',
    'password' => bcrypt('password'),
    'role' => UserRole::CITOYEN->value,
    'email_verified_at' => now(),
]);
```

### 4. Lancer l'application

```bash
# Créer le lien symbolique pour le storage
php artisan storage:link

# Lancer le serveur
php artisan serve
```

### 5. Accéder à l'application

- **Page d'accueil:** `http://127.0.0.1:8000`
- **Admin:** `http://127.0.0.1:8000/admin/projects`
- **Projets (public):** `http://127.0.0.1:8000/projets`

**Identifiants de test:**
- Admin: `admin@test.com` / `password`
- Citoyen: `citoyen@test.com` / `password`

---

## 📊 Schéma de la Base de Données

### Tables

#### 1. `contractors`
Entreprises et contractants pour les phases de projet.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint unsigned | PK |
| nom | varchar(255) | Nom du contractant |
| adresse | text | Adresse complète |
| telephone | varchar(20) | Téléphone (format FR) |
| email | varchar(255) | Email de contact |
| specialite | varchar(100) | Spécialité (plomberie, électricité, etc.) |
| timestamps | | created_at, updated_at |

#### 2. `projects`
Projets de rénovation des infrastructures.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint unsigned | PK |
| titre | varchar(255) | Titre du projet |
| type | varchar(50) | Type (réparation, modernisation, extension, construction) |
| description | text | Description détaillée |
| budget_prevu | decimal(15,2) | Budget prévisionnel en € |
| date_debut | date | Date de début |
| date_fin_prevue | date | Date de fin prévue |
| statut | varchar(50) | Statut (planifié, en_cours, terminé, suspendu, annulé) |
| avancement_pourcentage | integer | Avancement 0-100% |
| zone_id | bigint unsigned | FK → zones |
| infrastructure_id | bigint unsigned | FK → infrastructures |
| responsable_id | bigint unsigned | FK → users |
| timestamps | | created_at, updated_at |

#### 3. `project_phases`
Phases d'exécution des projets.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint unsigned | PK |
| project_id | bigint unsigned | FK → projects |
| contractor_id | bigint unsigned | FK → contractors |
| nom | varchar(255) | Nom de la phase |
| date_debut | date | Date de début |
| date_fin | date | Date de fin |
| cout | decimal(15,2) | Coût en € |
| avancement | integer | Avancement 0-100% |
| timestamps | | created_at, updated_at |

#### 4. `fundings`
Sources de financement des projets.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint unsigned | PK |
| project_id | bigint unsigned | FK → projects |
| source | varchar(100) | Source (subvention, don, prêt, partenariat) |
| montant | decimal(15,2) | Montant en € |
| date_obtention | date | Date d'obtention |
| statut | varchar(50) | Statut (confirmé, en_attente, refusé) |
| donateur_id | bigint unsigned nullable | FK → users (si source=don) |
| description | text nullable | Description |
| timestamps | | created_at, updated_at |

#### 5. `project_documents`
Documents attachés aux projets.

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint unsigned | PK |
| project_id | bigint unsigned | FK → projects |
| nom | varchar(255) | Nom du document |
| type_document | varchar(100) | Type (plan, rapport, photo, autre) |
| chemin_fichier | varchar(500) | Chemin du fichier |
| description | text nullable | Description |
| timestamps | | created_at, updated_at |

**Voir:** `docs/DATABASE_SCHEMA_REFERENCE.md` pour plus de détails.

---

## 🔗 Routes Principales

### Admin

| Méthode | URI | Nom | Contrôleur@Action |
|---------|-----|-----|-------------------|
| GET | /admin/projects | admin.projects.index | ProjectController@index |
| GET | /admin/projects/create | admin.projects.create | ProjectController@create |
| POST | /admin/projects | admin.projects.store | ProjectController@store |
| GET | /admin/projects/{id} | admin.projects.show | ProjectController@show |
| GET | /admin/projects/{id}/edit | admin.projects.edit | ProjectController@edit |
| PUT | /admin/projects/{id} | admin.projects.update | ProjectController@update |
| DELETE | /admin/projects/{id} | admin.projects.destroy | ProjectController@destroy |

### Front

| Méthode | URI | Nom | Contrôleur@Action |
|---------|-----|-----|-------------------|
| GET | /projets | projects.index | FrontProjectController@index |
| GET | /projets/{id} | projects.show | FrontProjectController@show |
| GET | /projets/{id}/faire-un-don | projects.donate | FrontFundingController@simulateDonation |
| POST | /projets/{id}/faire-un-don | projects.storeDonation | FrontFundingController@storeDonation |
| GET | /mes-dons | my-donations | FrontFundingController@myDonations |

**Voir:** `docs/ROUTES_REFERENCE.md` et `docs/ROUTES_VISUAL_MAP.md` pour la liste complète.

---

## 🎨 Design et Layouts

### Palette de Couleurs

```css
--navy: #0b2545      /* Bleu foncé (titres, texte important) */
--ocean: #1565c0     /* Bleu océan (boutons primaires) */
--aqua: #00b8d9      /* Aqua (accents, badges info) */
--bg: #f4f8fb        /* Fond clair */

--success: #2e9e5b   /* Vert (succès) */
--warning: #f59e0b   /* Orange (avertissement) */
--danger: #d93b3b    /* Rouge (danger) */
```

### Layouts

#### Admin Layout
**Composant:** `<x-project.layouts.admin>`

Utilisé pour toutes les pages d'administration.

```blade
<x-project.layouts.admin 
    title="Titre de la page"
    :breadcrumbs="[...]">
    <!-- Contenu -->
</x-project.layouts.admin>
```

#### Front Layout
**Composant:** `<x-project.layouts.front>`

Utilisé pour toutes les pages publiques.

```blade
<x-project.layouts.front 
    title="Titre de la page"
    :hero="[...]">
    <!-- Contenu -->
</x-project.layouts.front>
```

**Voir:** `docs/LAYOUTS_DOCUMENTATION.md` pour plus de détails.

---

## 📖 Documentation Complète

### Guides d'Implémentation
- **GESTION_5_IMPLEMENTATION_GUIDE.md**: Plan en 21 étapes pour l'implémentation complète

### Architecture Technique
- **DATABASE_SCHEMA_REFERENCE.md**: Schéma détaillé de la base de données
- **ADMIN_CONTROLLERS_DOCUMENTATION.md**: Documentation des 5 controllers admin
- **FRONT_CONTROLLERS_DOCUMENTATION.md**: Documentation des 2 controllers front
- **ROUTES_REFERENCE.md**: Liste complète des 53+ routes
- **ROUTES_VISUAL_MAP.md**: Carte visuelle des routes

### Frontend
- **LAYOUTS_DOCUMENTATION.md**: Documentation des layouts et composants CSS
- **VIEWS_DOCUMENTATION.md**: Documentation de toutes les vues Blade
- **VIEWS_COMPLETION_SUMMARY.md**: Résumé de ce qui a été créé

### Tests
- **TESTING_VIEWS_GUIDE.md**: Guide complet pour tester toutes les vues

---

## 🧪 Tests

### Exécuter les tests

```bash
# Tests complets
php artisan test

# Tests spécifiques au module 5
php artisan test --filter=Project
```

### Tests manuels

Suivez le guide complet: `docs/TESTING_VIEWS_GUIDE.md`

**Checklist rapide:**
1. ✅ Créer un projet (admin)
2. ✅ Ajouter des phases et financements
3. ✅ Uploader des documents
4. ✅ Voir le projet en tant que citoyen
5. ✅ Faire un don
6. ✅ Approuver le don (admin)
7. ✅ Vérifier "Mes dons" (citoyen)

---

## 🔐 Rôles et Permissions

### Admin / Gestionnaire
- ✅ Accès complet au back office
- ✅ CRUD sur tous les projets
- ✅ Gestion des contractants
- ✅ Gestion des phases et financements
- ✅ Upload de documents
- ✅ Approbation/Refus des dons

### Citoyen
- ✅ Consultation des projets publics
- ✅ Faire des dons
- ✅ Suivi de ses propres dons
- ✅ Téléchargement de documents publics
- ❌ Pas d'accès au back office

---

## 🚨 Dépannage

### Problème: "View not found"

```bash
# Clear le cache des vues
php artisan view:clear
php artisan config:clear
```

### Problème: "Route not found"

```bash
# Vérifier les routes
php artisan route:list --path=admin
php artisan route:list --path=projets

# Clear le cache des routes
php artisan route:clear
```

### Problème: "SQLSTATE[HY000]"

```bash
# Vérifier la configuration de la base de données dans .env
# Recréer la base de données
php artisan migrate:fresh --seed
```

### Problème: "Undefined variable $projects"

Vérifier que le controller passe bien la variable à la vue:

```php
return view('project.admin.projects.index', compact('projects'));
```

### Problème: Images/Documents ne se chargent pas

```bash
# Créer le lien symbolique
php artisan storage:link
```

---

## 📦 Dépendances

### Backend
- Laravel 10+
- PHP 8.1+
- MySQL 8.0+ / PostgreSQL 13+

### Frontend
- Blade Components
- CSS vanilla (pas de framework)
- JavaScript vanilla (pas de jQuery)
- SVG inline pour les icônes

---

## 🎯 Fonctionnalités Avancées (À venir)

### Court terme
- [ ] Export PDF des projets
- [ ] Export Excel des listes
- [ ] Recherche AJAX en temps réel
- [ ] Charts et graphiques (Chart.js)

### Moyen terme
- [ ] Notifications en temps réel (WebSockets)
- [ ] Emails de notification (nouveau don, approbation)
- [ ] Dashboard avec widgets
- [ ] API REST pour intégrations

### Long terme
- [ ] Application mobile (Flutter)
- [ ] Système de commentaires
- [ ] Forum des projets
- [ ] Géolocalisation des projets (maps)

---

## 🤝 Contribution

### Guidelines
1. Respecter la structure existante
2. Suivre les conventions Laravel
3. Utiliser les composants CSS existants (préfixe `aq-`)
4. Documenter les nouvelles fonctionnalités
5. Tester avant de commit

### Workflow Git
```bash
# Créer une branche pour votre feature
git checkout -b feature/nom-de-la-feature

# Commiter vos changements
git add .
git commit -m "feat: description de la feature"

# Pousser et créer une PR
git push origin feature/nom-de-la-feature
```

---

## 📞 Support

### Ressources
- **Documentation complète:** `docs/`
- **Logs Laravel:** `storage/logs/laravel.log`
- **Laravel Documentation:** https://laravel.com/docs

### Questions Fréquentes

**Q: Comment ajouter un nouveau type de projet?**  
R: Modifier la migration `create_projects_table.php` et ajouter le type dans le seeder.

**Q: Comment personnaliser les couleurs?**  
R: Modifier les variables CSS dans `resources/views/components/project/layouts/admin.css` et `front.css`.

**Q: Comment ajouter un nouveau champ à un formulaire?**  
R: 
1. Ajouter le champ dans la migration
2. Mettre à jour le FormRequest pour la validation
3. Ajouter le champ dans la vue Blade
4. Mettre à jour le controller (store/update)

---

## 📜 License

Ce projet fait partie du projet AquaSecure développé dans le cadre du cours à l'ESPRIT.

---

## ✨ Crédits

**Développé par:** FiveBytes Team  
**Projet:** AquaSecure - Gestion des Ressources Hydriques  
**Module:** Gestion 5 - Projets de Rénovation et Financement  
**Framework:** Laravel 10 + Blade  
**Design:** Custom CSS avec palette AquaSecure  

---

**Version:** 1.0  
**Dernière mise à jour:** 2026-10-05  
**Status:** ✅ Production Ready
