# Documentation des Vues - Module Gestion 5

## Vue d'ensemble

Ce document liste toutes les vues Blade créées pour le module Gestion 5 (Projets de Rénovation et Financement), organisées par section (Admin / Front).

---

## 📁 Structure des Vues

```
resources/views/
├── components/
│   └── project/
│       └── layouts/
│           ├── admin.blade.php          # Layout admin avec sidebar
│           ├── admin.css                # Styles pour l'admin
│           ├── front.blade.php          # Layout front avec navbar
│           ├── front.css                # Styles pour le front
│           ├── admin-example.blade.php  # Exemple d'utilisation admin
│           └── front-example.blade.php  # Exemple d'utilisation front
└── project/
    ├── admin/
    │   └── projects/
    │       ├── index.blade.php          # Liste des projets (admin)
    │       ├── create.blade.php         # Créer un projet
    │       ├── edit.blade.php           # Modifier un projet
    │       └── show.blade.php           # Détails d'un projet (admin)
    └── front/
        ├── index.blade.php              # Liste des projets (public)
        ├── show.blade.php               # Détails d'un projet (public)
        ├── donate.blade.php             # Faire un don
        └── my-donations.blade.php       # Mes dons (citoyen connecté)
```

---

## 🎨 Layouts

### Admin Layout
**Fichier:** `resources/views/components/project/layouts/admin.blade.php`

**Utilisation:**
```blade
<x-project.layouts.admin 
    title="Titre de la page"
    :breadcrumbs="[
        ['label' => 'Tableau de bord', 'url' => route('admin.dashboard')],
        ['label' => 'Projets', 'url' => route('admin.projects.index')],
        ['label' => 'Détails', 'url' => null]
    ]">
    
    <!-- Contenu de la page -->
    
</x-project.layouts.admin>
```

**Fonctionnalités:**
- Sidebar avec navigation des modules
- Breadcrumb automatique
- Messages flash (success, error, warning, info)
- Support des slots `@push('scripts')` et `@push('styles')`
- Design responsive avec menu mobile

### Front Layout
**Fichier:** `resources/views/components/project/layouts/front.blade.php`

**Utilisation:**
```blade
<x-project.layouts.front 
    title="Titre de la page"
    :hero="[
        'title' => 'Titre du hero',
        'subtitle' => 'Sous-titre',
        'background' => 'linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%)'
    ]">
    
    <!-- Contenu de la page -->
    
</x-project.layouts.front>
```

**Fonctionnalités:**
- Navbar avec navigation basée sur le rôle
- Section hero personnalisable
- Container fluide avec max-width
- Footer avec informations
- Support des slots `@push('scripts')` et `@push('styles')`

---

## 🔐 Vues Administration (Back Office)

### 1. Liste des Projets
**Route:** `admin.projects.index`  
**Fichier:** `resources/views/project/admin/projects/index.blade.php`  
**Méthode Controller:** `ProjectController@index`

**Fonctionnalités:**
- ✅ Tableau avec tous les projets
- ✅ Filtres (recherche, type, statut)
- ✅ Statistiques rapides (total, en cours, budget, terminés)
- ✅ Pagination
- ✅ Actions : Voir, Modifier, Supprimer
- ✅ Badge coloré selon le statut
- ✅ Barre de progression d'avancement

**Colonnes affichées:**
- Projet (titre + responsable)
- Type
- Zone / Infrastructure
- Budget (prévu + financé)
- Dates (début → fin)
- Statut
- Avancement (%)
- Actions

### 2. Créer un Projet
**Route:** `admin.projects.create`  
**Fichier:** `resources/views/project/admin/projects/create.blade.php`  
**Méthode Controller:** `ProjectController@create` / `store`

**Fonctionnalités:**
- ✅ Formulaire en 2 colonnes
- ✅ Tous les champs requis
- ✅ Validation en temps réel
- ✅ Filtrage des infrastructures par zone (JavaScript)
- ✅ Sélection du responsable (admin/gestionnaire)
- ✅ Messages d'erreur inline

**Champs:**
- Titre, Type, Description
- Budget prévu, Dates (début, fin)
- Zone, Infrastructure, Responsable
- Statut, Avancement (%)

### 3. Modifier un Projet
**Route:** `admin.projects.edit`  
**Fichier:** `resources/views/project/admin/projects/edit.blade.php`  
**Méthode Controller:** `ProjectController@edit` / `update`

**Fonctionnalités:**
- ✅ Formulaire pré-rempli avec données existantes
- ✅ Même structure que la création
- ✅ Mise à jour de la barre de progression en temps réel
- ✅ Boutons : Enregistrer, Annuler, Retour

### 4. Détails d'un Projet (Admin)
**Route:** `admin.projects.show`  
**Fichier:** `resources/views/project/admin/projects/show.blade.php`  
**Méthode Controller:** `ProjectController@show`

**Fonctionnalités:**
- ✅ Informations complètes du projet
- ✅ Budget et financement (prévu, obtenu, restant)
- ✅ **Section Phases** avec table interactive
  - Nom, Contractant, Période, Coût, Avancement
  - Actions : Modifier, Supprimer
  - Bouton "Ajouter une phase"
  - Total des coûts
- ✅ **Section Financements** avec table
  - Source, Montant, Date, Statut
  - Actions : Approuver, Refuser, Modifier, Supprimer
  - Total des financements
- ✅ **Section Documents** en grille
  - Icône, Nom, Type, Description
  - Actions : Télécharger, Supprimer
- ✅ Calcul automatique du retard/jours restants
- ✅ Indicateurs visuels (badges, progress bars)

---

## 🌐 Vues Front Office (Citoyens)

### 1. Liste des Projets (Public)
**Route:** `projects.index`  
**Fichier:** `resources/views/project/front/index.blade.php`  
**Méthode Controller:** `FrontProjectController@index`

**Fonctionnalités:**
- ✅ Grille de cartes (3 colonnes)
- ✅ Filtres (recherche, type, statut)
- ✅ Statistiques globales (total, en cours, terminés, budget)
- ✅ Chaque carte affiche :
  - Titre, Description (tronquée), Badges (statut, type)
  - Zone, Date de début
  - Budget + % financé
  - Barre d'avancement
  - Bouton "Voir les détails"
  - Bouton "Faire un don" (si citoyen connecté)
- ✅ Section CTA pour les citoyens connectés
- ✅ Pagination
- ✅ État vide si aucun projet

### 2. Détails d'un Projet (Public)
**Route:** `projects.show`  
**Fichier:** `resources/views/project/front/show.blade.php`  
**Méthode Controller:** `FrontProjectController@show`

**Layout:**
- **Colonne principale (2/3):**
  - Détails du projet (zone, infrastructure, responsable, description)
  - Calendrier + calcul jours restants
  - Barre d'avancement
  - Timeline des phases (design vertical avec marqueurs)
  - Documents téléchargeables

- **Colonne latérale (1/3):**
  - Budget et financement (card sticky)
  - Bouton "Faire un don" (si connecté)
  - Liste des sources de financement
  - Bouton "Retour à la liste"

**Fonctionnalités:**
- ✅ Vue read-only pour les citoyens
- ✅ Timeline interactive des phases
- ✅ Documents avec bouton téléchargement
- ✅ Call-to-action pour faire un don
- ✅ Message de connexion si non authentifié

### 3. Faire un Don
**Route:** `projects.donate`  
**Fichier:** `resources/views/project/front/donate.blade.php`  
**Méthode Controller:** `FrontFundingController@simulateDonation` / `storeDonation`

**Layout:**
- **Colonne principale (2/3):**
  - Formulaire de don
  - Montants suggérés (50€, 100€, 250€, 500€)
  - Montant personnalisé
  - Message optionnel
  - Option "Rester anonyme"
  - Checkbox d'accord obligatoire
  - Alert avec informations importantes
  - Section "Impact du don" (4 items)

- **Colonne latérale (1/3):**
  - Résumé du projet (card sticky)
  - Budget (total, déjà financé, encore nécessaire)
  - Informations du projet
  - Nombre de donateurs

**Fonctionnalités:**
- ✅ Boutons de montants pré-définis cliquables
- ✅ Feedback visuel sur le montant sélectionné
- ✅ Validation côté client et serveur
- ✅ Messages d'erreur inline
- ✅ Statut "en_attente" à la création

### 4. Mes Dons
**Route:** `my-donations`  
**Fichier:** `resources/views/project/front/my-donations.blade.php`  
**Méthode Controller:** `FrontFundingController@myDonations`

**Fonctionnalités:**
- ✅ Statistiques personnelles (total, confirmés, en attente, projets)
- ✅ Filtre par statut
- ✅ Liste détaillée des dons :
  - Titre du projet (cliquable)
  - Date et heure
  - Montant
  - Message (si présent)
  - Badges de statut
  - Avancement du projet (si confirmé)
  - Alertes selon le statut
  - Bouton "Voir le projet"
- ✅ Card "Merci" si dons confirmés
- ✅ État vide avec CTA vers la liste des projets

---

## 🎨 Composants CSS Réutilisables

### Classes principales (préfixe `aq-`)

#### Cards
- `.aq-card` - Carte de base
- `.aq-card-header` - En-tête de carte
- `.aq-card-title` - Titre de carte
- `.aq-card-subtitle` - Sous-titre
- `.aq-sticky-card` - Carte qui reste visible au scroll

#### Boutons
- `.aq-btn` - Bouton de base
- `.aq-btn-primary` - Bouton primaire (ocean)
- `.aq-btn-secondary` - Bouton secondaire
- `.aq-btn-outline` - Bouton contour
- `.aq-btn-danger` - Bouton danger
- `.aq-btn-success` - Bouton succès
- `.aq-btn-block` - Bouton pleine largeur
- `.aq-btn-sm` - Petit bouton
- `.aq-btn-icon` - Bouton icône

#### Badges
- `.aq-badge` - Badge de base
- `.aq-badge-primary` - Badge primaire (ocean)
- `.aq-badge-secondary` - Badge secondaire
- `.aq-badge-success` - Badge succès (vert)
- `.aq-badge-warning` - Badge avertissement (orange)
- `.aq-badge-danger` - Badge danger (rouge)
- `.aq-badge-info` - Badge info (aqua)

#### Formulaires
- `.aq-form` - Formulaire de base
- `.aq-form-group` - Groupe de champ
- `.aq-form-label` - Label de champ
- `.aq-form-control` - Input/Select/Textarea
- `.aq-form-error` - État d'erreur
- `.aq-error-message` - Message d'erreur
- `.aq-form-help` - Texte d'aide
- `.aq-form-actions` - Zone d'actions du formulaire
- `.aq-form-row` - Ligne de formulaire
- `.aq-required` - Indicateur requis (*)

#### Progress Bars
- `.aq-progress` - Container de barre
- `.aq-progress-bar` - Barre de progression

#### Grilles
- `.aq-grid-2` - Grille 2 colonnes
- `.aq-grid-3` - Grille 3 colonnes
- `.aq-grid-4` - Grille 4 colonnes

#### Stats
- `.aq-stat-card` - Carte de statistique
- `.aq-stat-icon` - Icône de stat
- `.aq-stat-info` - Info de stat
- `.aq-stat-label` - Label de stat
- `.aq-stat-value` - Valeur de stat
- `.aq-stats-grid` - Grille de stats (4 colonnes)

#### Alerts
- `.aq-alert` - Alert de base
- `.aq-alert-success` - Alert succès
- `.aq-alert-warning` - Alert avertissement
- `.aq-alert-danger` - Alert danger
- `.aq-alert-info` - Alert info

#### Tables
- `.aq-table` - Table de base
- `.aq-table-responsive` - Container responsive
- `.aq-table-title` - Titre dans cellule
- `.aq-table-subtitle` - Sous-titre dans cellule
- `.aq-table-empty` - État vide

#### Autres
- `.aq-icon` - Icône SVG
- `.aq-actions` - Groupe d'actions
- `.aq-filters` - Zone de filtres
- `.aq-text-muted` - Texte grisé
- `.aq-timeline` - Timeline verticale
- `.aq-document-card` - Carte de document
- `.aq-budget-info` - Info budget
- `.aq-info-item` - Item d'information

---

## 🎨 Palette de Couleurs

```css
--navy: #0b2545      /* Bleu foncé (titres, texte important) */
--ocean: #1565c0     /* Bleu océan (boutons primaires) */
--aqua: #00b8d9      /* Aqua (accents, badges info) */
--bg: #f4f8fb        /* Fond clair */

--success: #2e9e5b   /* Vert (succès) */
--warning: #f59e0b   /* Orange (avertissement) */
--danger: #d93b3b    /* Rouge (danger) */

--text: #1e293b      /* Texte principal */
--text-secondary: #64748b  /* Texte secondaire */
--text-muted: #94a3b8      /* Texte grisé */
--border: #e2e8f0    /* Bordures */
```

---

## 📊 Résumé

### Vues créées
- **Admin:** 4 vues (index, create, edit, show)
- **Front:** 4 vues (index, show, donate, my-donations)
- **Layouts:** 2 layouts (admin, front) + 2 exemples
- **Total:** **12 fichiers Blade**

### Fonctionnalités clés
✅ Design responsive (mobile, tablet, desktop)  
✅ Accessibilité (labels, ARIA, focus states)  
✅ Messages flash (success, error, warning, info)  
✅ Validation côté client et serveur  
✅ États vides gérés  
✅ Loading states  
✅ Tooltips et help text  
✅ Icons SVG inline  
✅ Confirmation avant suppression  
✅ Filtres et recherche  
✅ Pagination  
✅ Breadcrumbs  

### Patterns utilisés
- Blade Components (x-*)
- Slots (@push)
- Directives (@auth, @error, @forelse)
- Inline styles pour overrides
- CSS Variables (--*)
- Progressive Enhancement
- Mobile-First Design

---

## 🚀 Prochaines Étapes

1. ✅ Créer les vues pour les autres entités :
   - Contractors (index, create, edit, show)
   - Project Phases (create, edit)
   - Fundings (create, edit)
   - Project Documents (create)

2. ✅ Ajouter les fonctionnalités avancées :
   - Recherche en temps réel (AJAX)
   - Tri des colonnes
   - Export PDF/Excel
   - Notifications en temps réel
   - Charts/Graphs (Chart.js)

3. ✅ Tests et optimisations :
   - Tests de responsive design
   - Tests d'accessibilité
   - Optimisation des performances
   - Compression des assets

---

**Dernière mise à jour:** 2026-10-05  
**Auteur:** Kiro AI Agent  
**Version:** 1.0
