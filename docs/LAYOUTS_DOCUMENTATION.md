# Documentation des Layouts Blade - Module 5

## 📋 Vue d'ensemble

Ce document décrit les layouts Blade créés pour le module "Gestion 5 : Projets de Rénovation et Financement".

Les layouts respectent la structure existante du projet et utilisent la palette de couleurs définie dans `base.css`.

---

## 🎨 Palette de Couleurs (base.css)

```css
--navy: #0b2545      /* Bleu foncé principal */
--ocean: #1565c0     /* Bleu moyen (CTA, liens) */
--aqua: #00b8d9      /* Bleu cyan (accents) */
--bg: #f4f8fb        /* Fond gris clair */
--white: #ffffff     /* Blanc */
--text: #1e2a3a      /* Texte principal */
--muted: #5f7285     /* Texte secondaire */
--border: #dce6ee    /* Bordures */

--success: #2e9e5b   /* Vert (succès) */
--warning: #f59e0b   /* Orange (attention) */
--danger: #d93b3b    /* Rouge (danger) */
```

---

## 🏗️ Layouts Créés

### 1. Layout Admin (`admin.blade.php`)

**Fichier**: `resources/views/components/project/layouts/admin.blade.php`

**Utilisation**: Pages d'administration (Back Office)

#### Structure:

```blade
<!DOCTYPE html>
<html>
<head>
    - Meta tags
    - Title (personnalisable avec @yield('title'))
    - Bootstrap CSS
    - Styles de base (base.css)
    - Styles dashboard (sidebar, navbar)
    - Styles admin personnalisés (admin.css)
    - @stack('styles') pour styles additionnels
</head>
<body>
    - Sidebar (dashboardsidebar component)
    - Navbar dashboard (dashboardnavbar component)
    
    <main class="aq-admin-main">
        - Fil d'Ariane (breadcrumb)
        - En-tête de page (titre + actions)
        - Messages flash (success, error, warning)
        - Erreurs de validation
        - @yield('content')
    </main>
    
    - Scripts Bootstrap
    - @stack('scripts') pour scripts additionnels
</body>
</html>
```

#### Utilisation:

```blade
@extends('components.project.layouts.admin')

@section('title', 'Liste des Projets')

@section('page-title', 'Gestion des Projets')

@section('content')
    {{-- Contenu de la page --}}
@endsection

@push('styles')
    <style>
        /* Styles personnalisés */
    </style>
@endpush

@push('scripts')
    <script>
        // Scripts personnalisés
    </script>
@endpush
```

#### Variables Disponibles:

| Variable | Type | Description |
|----------|------|-------------|
| `$breadcrumbs` | array | Fil d'Ariane (optionnel) |
| `$header` | string | Titre de la page |
| `$description` | string | Description sous le titre (optionnel) |
| `$headerActions` | slot | Boutons d'action en haut (optionnel) |

#### Exemple Complet:

```blade
@extends('components.project.layouts.admin')

@section('title', 'Créer un Projet')

@php
    $breadcrumbs = [
        ['label' => 'Projets', 'url' => route('admin.project.index')],
        ['label' => 'Créer']
    ];
    $header = 'Créer un Nouveau Projet';
    $description = 'Remplissez le formulaire ci-dessous pour créer un nouveau projet de rénovation.';
    $headerActions = '<a href="'.route('admin.project.index').'" class="aq-btn aq-btn-secondary">Retour</a>';
@endphp

@section('content')
    <div class="aq-card">
        <div class="aq-card-body">
            {{-- Formulaire --}}
        </div>
    </div>
@endsection
```

---

### 2. Layout Front (`front.blade.php`)

**Fichier**: `resources/views/components/project/layouts/front.blade.php`

**Utilisation**: Pages publiques (Front Office)

#### Structure:

```blade
<!DOCTYPE html>
<html>
<head>
    - Meta tags
    - Title (personnalisable avec @yield('title'))
    - Bootstrap CSS
    - Styles de base (base.css)
    - Styles front personnalisés (front.css)
    - @stack('styles') pour styles additionnels
</head>
<body>
    - Navbar (shared.navbar component)
    
    <main class="aq-front-main">
        - Hero Section (optionnel)
        
        <div class="aq-container">
            - Messages flash (success, error, warning)
            - Erreurs de validation
            - @yield('content')
        </div>
    </main>
    
    - Footer
    
    - Scripts Bootstrap
    - @stack('scripts') pour scripts additionnels
</body>
</html>
```

#### Utilisation:

```blade
@extends('components.project.layouts.front')

@section('title', 'Nos Projets de Rénovation')

@section('content')
    {{-- Contenu de la page --}}
@endsection

@push('styles')
    <style>
        /* Styles personnalisés */
    </style>
@endpush

@push('scripts')
    <script>
        // Scripts personnalisés
    </script>
@endpush
```

#### Variables Disponibles:

| Variable | Type | Description |
|----------|------|-------------|
| `$hero` | array | Hero section (optionnel) |
| `$hero['title']` | string | Titre du hero |
| `$hero['description']` | string | Description du hero |

#### Exemple Complet:

```blade
@extends('components.project.layouts.front')

@section('title', 'Projets de Rénovation')

@php
    $hero = [
        'title' => 'Soutenez nos Projets de Rénovation',
        'description' => 'Découvrez les projets en cours et contribuez à l\'amélioration du réseau d\'eau potable dans votre région.'
    ];
@endphp

@section('content')
    <div class="aq-grid aq-grid-3">
        {{-- Cartes de projets --}}
    </div>
@endsection
```

---

## 📦 Composants Réutilisables

### Messages Flash

Les messages flash sont automatiquement affichés dans les deux layouts.

#### Types disponibles:
- `session('success')` - Message de succès (vert)
- `session('error')` - Message d'erreur (rouge)
- `session('warning')` - Message d'avertissement (orange)
- `$errors->any()` - Erreurs de validation (rouge)

#### Exemple dans un contrôleur:

```php
return redirect()->route('admin.project.index')
    ->with('success', 'Le projet a été créé avec succès.');

return redirect()->back()
    ->with('error', 'Une erreur est survenue.');

return redirect()->back()
    ->with('warning', 'Attention, ce projet contient des phases en attente.');
```

---

## 🎨 Classes CSS Disponibles

### Layout Admin

#### Cartes
```html
<div class="aq-card">
    <div class="aq-card-header">
        <h3 class="aq-card-title">Titre</h3>
    </div>
    <div class="aq-card-body">
        Contenu
    </div>
    <div class="aq-card-footer">
        Actions
    </div>
</div>
```

#### Boutons
```html
<button class="aq-btn aq-btn-primary">Principal</button>
<button class="aq-btn aq-btn-success">Succès</button>
<button class="aq-btn aq-btn-danger">Danger</button>
<button class="aq-btn aq-btn-secondary">Secondaire</button>

<!-- Tailles -->
<button class="aq-btn aq-btn-primary aq-btn-sm">Petit</button>
<button class="aq-btn aq-btn-primary">Normal</button>
<button class="aq-btn aq-btn-primary aq-btn-lg">Grand</button>
```

#### Tableaux
```html
<table class="aq-table">
    <thead>
        <tr>
            <th>Colonne 1</th>
            <th>Colonne 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Donnée 1</td>
            <td>Donnée 2</td>
        </tr>
    </tbody>
</table>
```

#### Formulaires
```html
<div class="aq-form-group">
    <label class="aq-form-label aq-form-label-required">Titre</label>
    <input type="text" class="aq-form-control" name="titre">
    <small class="aq-form-text">Texte d'aide</small>
    @error('titre')
        <span class="aq-form-error">{{ $message }}</span>
    @enderror
</div>
```

#### Badges
```html
<span class="aq-badge aq-badge-success">Approuvé</span>
<span class="aq-badge aq-badge-warning">En attente</span>
<span class="aq-badge aq-badge-danger">Rejeté</span>
<span class="aq-badge aq-badge-info">Info</span>
<span class="aq-badge aq-badge-secondary">Autre</span>
```

---

### Layout Front

#### Grilles Responsive
```html
<div class="aq-grid aq-grid-2">
    <!-- 2 colonnes (responsive) -->
</div>

<div class="aq-grid aq-grid-3">
    <!-- 3 colonnes (responsive) -->
</div>

<div class="aq-grid aq-grid-4">
    <!-- 4 colonnes (responsive) -->
</div>
```

#### Cartes
```html
<div class="aq-card">
    <img src="..." alt="..." class="aq-card-image">
    <div class="aq-card-body">
        <h3 class="aq-card-title">Titre</h3>
        <p class="aq-card-text">Texte</p>
        <a href="#" class="aq-btn aq-btn-primary">Action</a>
    </div>
    <div class="aq-card-footer">
        Footer
    </div>
</div>
```

#### Boutons
```html
<button class="aq-btn aq-btn-primary">Principal</button>
<button class="aq-btn aq-btn-secondary">Secondaire</button>
<button class="aq-btn aq-btn-success">Succès</button>

<!-- Tailles -->
<button class="aq-btn aq-btn-primary aq-btn-sm">Petit</button>
<button class="aq-btn aq-btn-primary">Normal</button>
<button class="aq-btn aq-btn-primary aq-btn-lg">Grand</button>

<!-- Pleine largeur -->
<button class="aq-btn aq-btn-primary aq-btn-block">Pleine largeur</button>
```

#### Badges
```html
<span class="aq-badge aq-badge-success">En cours</span>
<span class="aq-badge aq-badge-warning">Planifié</span>
<span class="aq-badge aq-badge-info">Terminé</span>
<span class="aq-badge aq-badge-secondary">Autre</span>
```

---

## 📱 Responsive Design

Les layouts sont entièrement responsives avec les breakpoints suivants:

| Breakpoint | Largeur | Comportement |
|------------|---------|--------------|
| Desktop | > 992px | Affichage complet |
| Tablet | 576px - 992px | Colonnes réduites |
| Mobile | < 576px | Une seule colonne |

---

## 🎯 Bonnes Pratiques

### 1. Utiliser @extends

```blade
{{-- Correct --}}
@extends('components.project.layouts.admin')

{{-- Incorrect --}}
<x-project.layouts.admin>
```

### 2. Définir les Variables en Haut

```blade
@extends('components.project.layouts.admin')

@php
    $breadcrumbs = [...];
    $header = '...';
    $description = '...';
@endphp

@section('content')
    ...
@endsection
```

### 3. Utiliser @stack pour les Assets

```blade
{{-- Dans la page --}}
@push('styles')
    <style>
        /* CSS spécifique à cette page */
    </style>
@endpush

@push('scripts')
    <script>
        // JS spécifique à cette page
    </script>
@endpush
```

### 4. Respecter la Palette de Couleurs

```css
/* Utiliser les variables CSS */
color: var(--navy);
background: var(--ocean);
border-color: var(--aqua);

/* Ne pas utiliser de couleurs en dur */
/* color: #0b2545; -- Éviter */
```

---

## 🔧 Personnalisation

### Surcharger les Styles

```blade
@push('styles')
<style>
    /* Personnalisations spécifiques à cette page */
    .aq-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
```

### Ajouter des Scripts

```blade
@push('scripts')
<script>
    // Confirmation de suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
```

---

## 📂 Structure des Fichiers

```
resources/views/components/project/
├── layouts/
│   ├── admin.blade.php         (Layout admin)
│   ├── admin.css               (Styles admin)
│   ├── front.blade.php         (Layout front)
│   └── front.css               (Styles front)
├── admin/
│   ├── index.blade.php         (utilise admin layout)
│   ├── create.blade.php
│   └── ...
└── front/
    ├── index.blade.php         (utilise front layout)
    ├── show.blade.php
    └── ...
```

---

## ✅ Checklist de Validation

Avant de créer une nouvelle vue :

- [ ] Choisir le bon layout (admin ou front)
- [ ] Définir un titre unique (@section('title'))
- [ ] Définir les variables de layout si nécessaire
- [ ] Utiliser les classes CSS prédéfinies
- [ ] Respecter la palette de couleurs
- [ ] Ajouter les messages flash appropriés
- [ ] Tester le responsive design
- [ ] Vérifier l'accessibilité

---

## 🔗 Fichiers Connexes

- Layouts: `resources/views/components/project/layouts/`
- Styles de base: `resources/views/base.css`
- Navbar: `resources/views/components/shared/navbar.blade.php`
- Dashboard: `resources/views/components/dashboard/`

---

**Status**: ✅ Layouts créés et documentés!
