# Module de Gestion des Incidents - AquaSecure

## 🎯 Description

Module complet de gestion des incidents pour l'application AquaSecure. Permet aux citoyens de signaler des incidents (fuites, contaminations, coupures) et aux gestionnaires de les traiter.

## 📦 Installation et Configuration

Le module est déjà installé et prêt à être utilisé. Les migrations ont été exécutées et les données de test sont en place.

### Vérifier l'installation

```bash
# Vérifier que la table incidents existe
php artisan tinker --execute="echo App\Models\Incident\Incident::count();"

# Afficher les routes
php artisan route:list --name=incidents
```

## 🚀 Démarrage rapide

### 1. Lancer le serveur de développement

```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

### 2. Se connecter

**Créer un utilisateur admin :**

```bash
php artisan tinker
```

Puis dans Tinker :

```php
$admin = App\Models\User::factory()->create([
    'name' => 'Admin Test',
    'email' => 'admin@aquasecure.test',
    'password' => bcrypt('password'),
    'role' => App\Enums\UserRole::Admin
]);
```

**Credentials :**
- Email : `admin@aquasecure.test`
- Password : `password`

### 3. Accéder au module incidents

Une fois connecté, accédez à : `http://localhost:8000/admin/incidents`

## 📋 Fonctionnalités

### Pour les Gestionnaires et Admins

- ✅ **Liste des incidents** avec filtres (recherche, statut, urgence, type)
- ✅ **Création d'incidents** avec carte interactive Leaflet
- ✅ **Modification d'incidents** (affectation technicien, changement de statut)
- ✅ **Visualisation détaillée** avec carte de localisation
- ✅ **Suppression** avec confirmation
- ✅ **Gestion des doublons** (incident parent)

### Pour les Citoyens

Les citoyens ont des permissions limitées :
- Peuvent créer des incidents
- Peuvent voir uniquement leurs propres incidents
- Peuvent modifier/supprimer leurs incidents au statut "nouveau" uniquement

## 🗺️ Routes disponibles

| Méthode | URL | Action | Description |
|---------|-----|--------|-------------|
| GET | `/admin/incidents` | index | Liste paginée des incidents |
| GET | `/admin/incidents/create` | create | Formulaire de création |
| POST | `/admin/incidents` | store | Enregistrer un nouvel incident |
| GET | `/admin/incidents/{id}` | show | Voir les détails |
| GET | `/admin/incidents/{id}/edit` | edit | Formulaire de modification |
| PUT/PATCH | `/admin/incidents/{id}` | update | Mettre à jour |
| DELETE | `/admin/incidents/{id}` | destroy | Supprimer |

## 🎨 Captures d'écran des fonctionnalités

### Page Index
- Tableau avec badges colorés (statut, urgence)
- Barre de filtres (recherche, statut, urgence, type)
- Pagination (10 incidents par page)
- Actions : Voir, Modifier, Supprimer

### Formulaire (Create/Edit)
- Sélection du type et de l'urgence
- Description (min 10 caractères)
- **Carte Leaflet interactive** :
  - Cliquez sur la carte pour définir la localisation
  - Le marqueur est draggable
  - Coordonnées GPS mises à jour automatiquement
- Affectation technicien (en édition)
- Changement de statut (en édition)
- Gestion des doublons (en édition)

### Page Détails (Show)
- Informations complètes
- Carte Leaflet avec marqueur
- Citoyen signalant
- Technicien affecté
- Infrastructure concernée
- Incidents liés (doublons)

## 🔐 Permissions

### Citoyen
```php
- create() ✅
- view(own) ✅
- update(own, nouveau) ✅
- delete(own, nouveau) ✅
- assignTechnician() ❌
- changeStatus() ❌
```

### Gestionnaire
```php
- viewAny() ✅
- view(all) ✅
- update(all) ✅
- delete(all) ✅
- assignTechnician() ✅
- changeStatus() ✅
```

### Admin
```php
- Tous les droits ✅
- forceDelete() ✅
```

## 💾 Structure de la base de données

### Table : `incidents`

```sql
- id (bigint)
- reference (string, unique) -- Format: INC-2026-0001
- type (enum: fuite, contamination, coupure, autre)
- description (text)
- latitude (decimal 10,7)
- longitude (decimal 10,7)
- urgence (enum: faible, moyenne, haute, critique)
- statut (enum: nouveau, en_cours, resolu, ferme)
- citoyen_id (FK users)
- technicien_id (FK users, nullable)
- infrastructure_id (FK infrastructures, nullable)
- incident_parent_id (FK incidents, nullable)
- date_resolution (timestamp, nullable)
- created_at, updated_at
```

### Relations

- Un incident appartient à un citoyen (créateur)
- Un incident peut avoir un technicien affecté
- Un incident peut être lié à une infrastructure
- Un incident peut avoir un incident parent (doublons)
- Un incident peut avoir plusieurs incidents enfants (doublons)

## 🧪 Tests

### Tester la Policy

```bash
php artisan tinker
```

```php
use App\Models\User;
use App\Models\Incident\Incident;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Gate;

// Créer des utilisateurs de test
$citoyen = User::factory()->create(['role' => UserRole::Citoyen]);
$gestionnaire = User::factory()->create(['role' => UserRole::Gestionnaire]);
$admin = User::factory()->create(['role' => UserRole::Admin]);

// Récupérer un incident
$incident = Incident::first();

// Tester les permissions
Gate::forUser($citoyen)->allows('create', Incident::class); // true
Gate::forUser($citoyen)->allows('update', $incident); // dépend du propriétaire et statut
Gate::forUser($gestionnaire)->allows('update', $incident); // true
Gate::forUser($admin)->allows('forceDelete', $incident); // true
```

### Tester les scopes

```php
// Incidents par statut
Incident::parStatut('nouveau')->count();

// Incidents par urgence
Incident::parUrgence('critique')->count();

// Recherche
Incident::search('fuite')->count();
```

## 📊 Statistiques actuelles

Données de test (15 incidents) :
- 5 incidents "Nouveau"
- 5 incidents "En cours"
- 3 incidents "Résolu"
- 5 incidents "Critique"

## 🐛 Dépannage

### Les vues ne s'affichent pas

```bash
php artisan view:clear
php artisan cache:clear
```

### Les routes ne fonctionnent pas

```bash
php artisan route:clear
php artisan route:cache
```

### Erreur 403 (Unauthorized)

Vérifiez que :
1. Vous êtes connecté
2. Votre utilisateur a le bon rôle (Gestionnaire ou Admin)
3. La policy est bien enregistrée dans `AuthServiceProvider`

### La carte Leaflet ne s'affiche pas

Vérifiez que :
1. Vous avez une connexion internet (Leaflet chargé via CDN)
2. Le layout `admin.blade.php` inclut bien les scripts Leaflet

## 📚 Documentation complémentaire

- **Laravel Breeze** : Authentification
- **TailwindCSS** : Framework CSS
- **Alpine.js** : Framework JavaScript
- **Leaflet** : Cartes interactives
- **Laravel Policies** : Autorisations

## 🚧 Améliorations futures

- [ ] Téléchargement de photos (table `incident_photos`)
- [ ] Système de commentaires (table `incident_comments`)
- [ ] Historique des changements de statut (table `incident_status_history`)
- [ ] Notifications email/SMS
- [ ] Export PDF/Excel
- [ ] Tableau de bord avec statistiques
- [ ] API REST pour mobile
- [ ] Détection automatique de doublons par IA

## 👨‍💻 Développeur

Module développé dans le cadre du projet AquaSecure - Gestion de l'eau potable.

---

**✅ Le module est prêt à être utilisé en production !**
