# Documentation des Contrôleurs Front Office - Module 5

## 📋 Vue d'ensemble

Ce document décrit les contrôleurs Front Office (espace citoyen) du module "Gestion 5 : Projets de Rénovation et Financement".

Les contrôleurs front sont conçus pour :
- ✅ Afficher uniquement les projets non annulés
- ✅ Filtrer les données sensibles
- ✅ Promouvoir la transparence budgétaire
- ✅ Permettre aux citoyens de faire des dons

---

## 🎯 Contrôleurs Front

### 1. ProjectController
**Fichier**: `app/Http/Controllers/Front/Project/ProjectController.php`

**Namespace**: `App\Http\Controllers\Front\Project`

#### Méthodes:

##### `index(Request $request)`
**Route**: `GET /projets` → `project.index`

**Description**: Liste publique des projets avec filtres

**Filtrage**:
- ✅ Exclut automatiquement les projets annulés (`statut != 'annulé'`)
- ✅ Affiche uniquement les informations publiques

**Filtres disponibles**:
- Zone (`zone_id`)
- Type de projet (`type`)
- Statut (`statut`)

**Fonctionnalités**:
- Pagination: 12 projets par page
- Eager loading: zone, infrastructure, responsable
- Tri: par date de début (desc)

**Exemple d'utilisation**:
```php
// Tous les projets
GET /projets

// Projets filtrés
GET /projets?zone_id=5&type=rénovation&statut=en_cours
```

---

##### `show(Project $project)`
**Route**: `GET /projets/{id}` → `project.show`

**Description**: Détails publics d'un projet avec transparence budgétaire

**Sécurité**:
- ✅ Vérifie que le projet n'est pas annulé (404 si annulé)
- ✅ Affiche uniquement les financements approuvés (`statut = 'approuve'`)
- ✅ Masque les informations sensibles

**Relations chargées**:
```php
- zone
- infrastructure
- responsable
- projectPhases.contractor
- fundings (uniquement statut='approuve')
- projectDocuments (triés par date)
```

**Transparence budgétaire affichée**:
- Budget prévu (`budget_prevu`)
- Budget total des phases (`budgetTotal()`)
- Financement obtenu (`fundingTotal()`)
- Budget restant (`budgetRemaining()`)
- Avancement du projet (`avancement_pourcentage`)

**Données publiques**:
- Titre, description, type
- Dates (début, fin prévue)
- Zone et infrastructure
- Responsable du projet
- Phases avec entrepreneurs
- Financements approuvés (source, montant, statut)
- Documents téléchargeables

**Données masquées**:
- Financements en attente ou rejetés
- Informations internes sensibles

---

### 2. FundingController
**Fichier**: `app/Http/Controllers/Front/Project/FundingController.php`

**Namespace**: `App\Http\Controllers\Front\Project`

#### Méthodes:

##### `simulateDonation($projectId)`
**Route**: `GET /projets/{projectId}/faire-un-don` → `project.donate`

**Middleware**: `auth` (authentification requise)

**Description**: Affiche le formulaire de don simulé pour un projet

**Fonctionnalités**:
- Vérifie que le projet n'est pas annulé
- Calcule et affiche:
  - Budget prévu
  - Financement déjà obtenu
  - Budget restant à financer
- Pré-remplit le formulaire avec les infos utilisateur

**Utilisation**:
```php
// Afficher le formulaire de don pour le projet #5
GET /projets/5/faire-un-don
```

---

##### `storeDonation(Request $request)`
**Route**: `POST /projets/don` → `project.donate.store`

**Middleware**: `auth` (authentification requise)

**Description**: Enregistre un don simulé avec l'utilisateur connecté comme donateur

**Validation**:
```php
'project_id' => 'required|exists:projects,id',
'montant' => 'required|numeric|min:1|max:1000000',
'description' => 'nullable|string|max:1000',
```

**Messages de validation (français)**:
- Montant minimum: 1 €
- Montant maximum: 1 000 000 €
- Description max: 1000 caractères

**Processus**:
1. Valide les données
2. Vérifie que le projet n'est pas annulé
3. Crée un enregistrement `Funding` avec:
   - `source` = 'don'
   - `statut` = 'en_attente' (nécessite approbation gestionnaire)
   - `donateur_id` = utilisateur connecté
   - `date_obtention` = maintenant
4. Redirige vers la page du projet avec message de succès

**Sécurité**:
- ✅ Uniquement accessible aux utilisateurs authentifiés
- ✅ Vérifie que le projet existe et n'est pas annulé
- ✅ Crée le don en statut "en attente" (nécessite validation admin)
- ✅ Associe automatiquement l'utilisateur connecté comme donateur

**Message de succès**:
```
"Merci pour votre don de {montant} € ! Votre contribution sera examinée 
par notre équipe et vous recevrez une confirmation prochainement."
```

---

##### `myDonations()`
**Route**: `GET /mes-dons` → `donations.index`

**Middleware**: `auth` (authentification requise)

**Description**: Affiche l'historique des dons de l'utilisateur connecté

**Fonctionnalités**:
- Liste tous les dons de l'utilisateur
- Affiche le projet associé et la zone
- Tri par date (plus récent en premier)
- Pagination: 10 dons par page

**Informations affichées**:
- Montant du don
- Date du don
- Statut (en_attente, approuve, rejete)
- Projet associé
- Description

---

## 🛣️ Routes Front Office

### Routes Publiques (sans auth)
```
GET     /projets                        project.index
GET     /projets/{id}                   project.show
```

### Routes Authentifiées (citoyens)
```
GET     /projets/{id}/faire-un-don      project.donate
POST    /projets/don                    project.donate.store
GET     /mes-dons                       donations.index
```

---

## 🔒 Sécurité et Filtrage

### Projets Annulés
**Règle**: Les projets avec `statut = 'annulé'` ne sont jamais affichés au public.

```php
// Dans index()
->where('statut', '!=', 'annulé')

// Dans show()
if ($project->statut === 'annulé') {
    abort(404, 'Ce projet n\'est pas disponible.');
}
```

### Financements
**Règle**: Seuls les financements approuvés sont affichés au public.

```php
'fundings' => function ($query) {
    $query->where('statut', 'approuve');
}
```

### Dons
**Règle**: Tous les dons créés par les citoyens sont en statut "en_attente" par défaut.

```php
'statut' => 'en_attente', // Nécessite approbation gestionnaire
```

---

## 💰 Transparence Budgétaire

### Informations Affichées au Public

#### Sur la page d'un projet:

1. **Budget Prévu**
   ```php
   $project->budget_prevu
   ```

2. **Budget Total des Phases** (coût réel)
   ```php
   $project->budgetTotal() // Somme des coûts de toutes les phases
   ```

3. **Financement Obtenu** (financements approuvés uniquement)
   ```php
   $project->fundingTotal() // Somme des montants approuvés
   ```

4. **Budget Restant à Financer**
   ```php
   $project->budgetRemaining() // fundingTotal() - budgetTotal()
   ```

5. **Avancement du Projet**
   ```php
   $project->avancement_pourcentage // 0-100%
   ```

#### Sur le formulaire de don:

- Budget prévu
- Financement déjà obtenu
- Montant encore nécessaire
- Suggestion de montant (optionnel)

---

## 💬 Messages Flash

### Types de messages:

#### ✅ Succès - Don Enregistré
```php
'Merci pour votre don de {montant} € ! Votre contribution sera examinée 
par notre équipe et vous recevrez une confirmation prochainement.'
```

#### ❌ Erreurs - Validation
- Montant invalide
- Projet inexistant
- Projet annulé
- Description trop longue

---

## 🎨 Flux Utilisateur Citoyen

### Parcours de Don:

1. **Navigation**
   - Visiteur accède à `/projets`
   - Parcourt la liste des projets
   - Filtre par zone/type/statut

2. **Consultation**
   - Clique sur un projet
   - Consulte les détails (`/projets/{id}`)
   - Voit la transparence budgétaire
   - Lit les phases, financements, documents

3. **Authentification** (si pas déjà connecté)
   - Clique sur "Faire un don"
   - Redirigé vers login
   - Après login, retour au projet

4. **Don**
   - Accède au formulaire (`/projets/{id}/faire-un-don`)
   - Voit budget prévu, obtenu, restant
   - Saisit montant et description
   - Soumet le formulaire

5. **Confirmation**
   - Redirigé vers page du projet
   - Message de confirmation affiché
   - Don visible dans "Mes dons" avec statut "En attente"

6. **Suivi**
   - Accès à `/mes-dons`
   - Voit tous ses dons
   - Statut: en_attente, approuve, ou rejete

---

## 📊 Calculs Budgétaires

### Méthodes utilisées (dans Project model):

```php
// Coût total des phases
public function budgetTotal(): float
{
    return (float) $this->projectPhases()->sum('cout');
}

// Financement total obtenu
public function fundingTotal(): float
{
    return (float) $this->fundings()
        ->where('statut', 'approuve')
        ->sum('montant');
}

// Budget restant à financer
public function budgetRemaining(): float
{
    return $this->fundingTotal() - $this->budgetTotal();
}
```

### Affichage dans les vues:

```blade
<!-- Budget prévu -->
{{ number_format($project->budget_prevu, 2, ',', ' ') }} €

<!-- Financement obtenu -->
{{ number_format($project->fundingTotal(), 2, ',', ' ') }} €

<!-- Budget restant -->
{{ number_format($project->budgetRemaining(), 2, ',', ' ') }} €

<!-- Avancement -->
{{ $project->avancement_pourcentage }}%
```

---

## 🔍 Différences Front vs Admin

| Fonctionnalité | Front Office (Citoyen) | Back Office (Admin) |
|----------------|------------------------|---------------------|
| **Projets affichés** | Uniquement non annulés | Tous projets |
| **Financements** | Uniquement approuvés | Tous statuts |
| **CRUD** | Lecture seule | Complet (Create, Read, Update, Delete) |
| **Dons** | Peut créer (en_attente) | Peut approuver/rejeter |
| **Documents** | Téléchargement uniquement | Upload, édition, suppression |
| **Phases** | Lecture uniquement | Gestion complète |
| **Authentification** | Optionnelle (sauf dons) | Requise |

---

## 📝 Exemples de Requêtes

### Lister les projets en cours dans la zone 5:
```
GET /projets?zone_id=5&statut=en_cours
```

### Voir les détails d'un projet:
```
GET /projets/12
```

### Faire un don (authentifié):
```
GET /projets/12/faire-un-don
```

### Soumettre un don:
```
POST /projets/don
{
    "project_id": 12,
    "montant": 500.00,
    "description": "Don pour soutenir la rénovation du réseau"
}
```

### Voir mes dons:
```
GET /mes-dons
```

---

## 🎯 Cas d'Usage

### Cas 1: Visiteur Anonymous
- ✅ Peut voir la liste des projets
- ✅ Peut voir les détails d'un projet
- ✅ Voit la transparence budgétaire
- ❌ Ne peut pas faire de don (doit s'authentifier)

### Cas 2: Citoyen Authentifié
- ✅ Peut voir la liste des projets
- ✅ Peut voir les détails d'un projet
- ✅ Voit la transparence budgétaire
- ✅ Peut faire un don (statut: en_attente)
- ✅ Peut voir l'historique de ses dons

### Cas 3: Gestionnaire/Admin
- ✅ Accède au back office (`/admin/projects`)
- ✅ Gère tous les projets (CRUD complet)
- ✅ Approuve ou rejette les dons
- ✅ Upload des documents
- ✅ Gère les phases et financements

---

## ✅ Checklist Sécurité

- [x] Projets annulés masqués du public
- [x] Financements non approuvés masqués
- [x] Dons nécessitent authentification
- [x] Dons créés en statut "en_attente"
- [x] Validation des montants (min 1€, max 1M€)
- [x] Vérification existence projet avant don
- [x] Association automatique donateur = user connecté
- [x] Messages flash informatifs
- [x] Gestion des erreurs (404 si projet annulé)

---

## 🔗 Fichiers Connexes

- Contrôleur Project Front: `app/Http/Controllers/Front/Project/ProjectController.php`
- Contrôleur Funding Front: `app/Http/Controllers/Front/Project/FundingController.php`
- Routes Front: `routes/front/project.php`
- Models: `app/Models/Project/*.php`
- Vues Front: `resources/views/components/project/front/*.blade.php`
- Documentation: `docs/FRONT_OFFICE_IMPLEMENTATION.md`

---

## 🚀 Prochaines Étapes

### Vues à créer:
1. [ ] `resources/views/components/project/front/donate.blade.php` - Formulaire de don
2. [ ] `resources/views/components/project/front/my-donations.blade.php` - Historique dons
3. [ ] Ajouter bouton "Faire un don" sur `show.blade.php`

### Fonctionnalités bonus:
- [ ] Statistiques de dons par projet
- [ ] Badges pour donateurs réguliers
- [ ] Notifications email après approbation/rejet don
- [ ] Certificat de don téléchargeable (PDF)

---

**Status**: ✅ Contrôleurs Front Office créés et fonctionnels!
