# Guide d'Utilisation - Project Module CSS

## 📋 Table des Matières
1. [Palette de Couleurs](#palette-de-couleurs)
2. [Cards de Projets](#cards-de-projets)
3. [Badges de Statut](#badges-de-statut)
4. [Barres de Progression](#barres-de-progression)
5. [Timeline Visuelle](#timeline-visuelle)
6. [Graphiques Budget](#graphiques-budget)
7. [Boutons d'Action](#boutons-daction)
8. [Classes Utilitaires](#classes-utilitaires)

---

## 🎨 Palette de Couleurs

### Couleurs Principales
```css
--navy: #0b2545       /* Bleu marine foncé */
--ocean: #1565c0      /* Bleu océan */
--aqua: #00b8d9       /* Bleu aqua clair */
--bg: #f4f8fb         /* Fond gris clair */
--white: #ffffff      /* Blanc */
--text: #1e2a3a       /* Texte principal */
--muted: #5f7285      /* Texte secondaire */
--border: #dce6ee     /* Bordures */
```

### Couleurs de Statut
```css
--success: #2e9e5b    /* Vert - succès */
--warning: #f59e0b    /* Orange - attention */
--danger: #d93b3b     /* Rouge - danger */
```

### Couleurs Statut Projet
```css
--status-planifie: #1565c0   /* Bleu */
--status-en-cours: #2e9e5b   /* Vert */
--status-termine: #5f7285    /* Gris */
--status-suspendu: #f59e0b   /* Orange */
--status-annule: #d93b3b     /* Rouge */
```

---

## 📦 Cards de Projets

### Card de Base
```html
<div class="project-card">
    <div class="project-card-header">
        <div class="project-card-icon">
            <i class="fas fa-tools"></i>
        </div>
        <div class="project-card-title">
            <h3>Titre du Projet</h3>
        </div>
    </div>
    
    <div class="project-card-body">
        <p class="project-card-description">
            Description du projet...
        </p>
        
        <div class="project-card-meta">
            <div class="project-meta-item">
                <i class="fas fa-calendar"></i>
                <span class="project-meta-label">Date:</span>
                <span class="project-meta-value">01/01/2024</span>
            </div>
        </div>
    </div>
    
    <div class="project-card-footer">
        <!-- Boutons d'action -->
    </div>
</div>
```

### Responsive Behavior
- **Mobile (< 768px)**: 1 colonne, padding réduit
- **Tablet (768px+)**: 2 colonnes meta, padding normal
- **Desktop (1024px+)**: 3 colonnes meta, padding large

### Hover Effects
- Élévation de 4px au survol
- Changement d'ombre
- Élargissement de la bordure gauche (4px → 6px)

---

## 🏷️ Badges de Statut

### Badge Statut Projet
```html
<!-- Planifié -->
<span class="badge-status planifie">
    <i class="fas fa-circle"></i>
    Planifié
</span>

<!-- En Cours (avec animation pulse) -->
<span class="badge-status en-cours">
    <i class="fas fa-circle"></i>
    En Cours
</span>

<!-- Terminé -->
<span class="badge-status termine">
    <i class="fas fa-circle"></i>
    Terminé
</span>

<!-- Suspendu -->
<span class="badge-status suspendu">
    <i class="fas fa-circle"></i>
    Suspendu
</span>

<!-- Annulé -->
<span class="badge-status annule">
    <i class="fas fa-circle"></i>
    Annulé
</span>
```

### Badge Type de Projet
```html
<span class="badge-type">
    <i class="fas fa-tag"></i>
    Rénovation
</span>
```

### Badge Priorité
```html
<!-- Haute -->
<span class="badge-priority haute">Haute</span>

<!-- Moyenne -->
<span class="badge-priority moyenne">Moyenne</span>

<!-- Basse -->
<span class="badge-priority basse">Basse</span>
```

---

## 📊 Barres de Progression

### Barre Standard
```html
<div class="progress-wrapper">
    <div class="progress-header">
        <span class="progress-label">Avancement</span>
        <span class="progress-percentage">75%</span>
    </div>
    
    <div class="progress-bar-custom">
        <div class="progress-bar-fill" style="width: 75%">
            <span class="progress-bar-text">75%</span>
        </div>
    </div>
</div>
```

### Variantes de Couleur
```html
<!-- Success (vert) -->
<div class="progress-bar-fill success" style="width: 100%"></div>

<!-- Warning (orange) -->
<div class="progress-bar-fill warning" style="width: 50%"></div>

<!-- Danger (rouge) -->
<div class="progress-bar-fill danger" style="width: 25%"></div>
```

### Tailles
```html
<!-- Petite (12px) -->
<div class="progress-bar-custom small"></div>

<!-- Normale (20px) -->
<div class="progress-bar-custom"></div>

<!-- Grande (32px) -->
<div class="progress-bar-custom large"></div>
```

### Animation
- Effet shimmer automatique sur la barre de progression
- Transition smooth de 0.5s lors du changement de largeur

---

## 📅 Timeline Visuelle

### Structure Complète
```html
<div class="timeline">
    <div class="timeline-item">
        <div class="timeline-marker"></div>
        <div class="timeline-content">
            <div class="timeline-header">
                <h6 class="timeline-title">Événement</h6>
                <span class="timeline-date">01/01/2024</span>
            </div>
            <p class="timeline-description">
                Description de l'événement...
            </p>
        </div>
    </div>
    
    <!-- Autres items... -->
</div>
```

### Variantes de Marqueurs
```html
<!-- Default (bleu) -->
<div class="timeline-marker"></div>

<!-- Success (vert) -->
<div class="timeline-marker success"></div>

<!-- Warning (orange) -->
<div class="timeline-marker warning"></div>

<!-- Danger (rouge) -->
<div class="timeline-marker danger"></div>

<!-- Muted (gris) -->
<div class="timeline-marker muted"></div>
```

### Responsive
- **Mobile**: Marqueur 16px, padding réduit
- **Desktop**: Marqueur 20px, padding normal

### Hover Effects
- Scale 1.2 sur le marqueur
- Ombre plus prononcée sur le contenu

---

## 💰 Graphiques Budget

### Structure Budget Chart
```html
<div class="budget-chart">
    <div class="budget-chart-header">
        <h5 class="budget-chart-title">
            <i class="fas fa-chart-pie"></i>
            Budget du Projet
        </h5>
        <p class="budget-chart-subtitle">
            Répartition des financements
        </p>
    </div>
    
    <div class="budget-row">
        <div class="budget-row-header">
            <span class="budget-row-label">
                <i class="fas fa-wallet"></i>
                Budget Prévu
            </span>
            <span class="budget-row-amount">
                50,000
                <span class="currency">TND</span>
            </span>
        </div>
        
        <div class="budget-bar">
            <div class="budget-bar-segment prevu" style="width: 100%">
                <span class="budget-bar-segment-text">50,000 TND</span>
            </div>
        </div>
    </div>
    
    <!-- Stats Grid -->
    <div class="budget-stats">
        <div class="budget-stat-card">
            <div class="budget-stat-label">Objectif</div>
            <div class="budget-stat-value">
                50,000
                <span class="budget-stat-currency">TND</span>
            </div>
        </div>
        <!-- Autres stats... -->
    </div>
</div>
```

### Segments de Barre
```html
<!-- Budget Prévu (bleu) -->
<div class="budget-bar-segment prevu" style="width: 100%"></div>

<!-- Budget Reçu (vert) -->
<div class="budget-bar-segment recu" style="width: 75%"></div>

<!-- Budget Restant (orange) -->
<div class="budget-bar-segment restant" style="width: 25%"></div>
```

### Responsive Stats Grid
- **Mobile**: 1 colonne
- **Tablet+**: 3 colonnes

---

## 🎯 Boutons d'Action

### Structure de Base
```html
<button class="btn-project primary">
    <i class="fas fa-plus"></i>
    Nouveau Projet
</button>
```

### Variantes de Couleur
```html
<!-- Primary (bleu gradient) -->
<button class="btn-project primary">Primary</button>

<!-- Success (vert gradient) -->
<button class="btn-project success">Success</button>

<!-- Warning (orange gradient) -->
<button class="btn-project warning">Warning</button>

<!-- Danger (rouge gradient) -->
<button class="btn-project danger">Danger</button>

<!-- Outline -->
<button class="btn-project outline">Outline</button>

<!-- Ghost -->
<button class="btn-project ghost">Ghost</button>
```

### Tailles
```html
<!-- Small -->
<button class="btn-project small primary">Small</button>

<!-- Normal (défaut) -->
<button class="btn-project primary">Normal</button>

<!-- Large -->
<button class="btn-project large primary">Large</button>

<!-- Icon Only -->
<button class="btn-project icon-only primary">
    <i class="fas fa-trash"></i>
</button>
```

### Hover Effects
- Élévation de 2px
- Ombre plus prononcée
- Changement de gradient au survol

---

## 🛠️ Classes Utilitaires

### Couleurs de Texte
```html
<span class="text-navy">Navy</span>
<span class="text-ocean">Ocean</span>
<span class="text-aqua">Aqua</span>
<span class="text-success">Success</span>
<span class="text-warning">Warning</span>
<span class="text-danger">Danger</span>
<span class="text-muted">Muted</span>
```

### Backgrounds
```html
<div class="bg-navy">Navy Background</div>
<div class="bg-gradient-primary">Gradient Primary</div>
<div class="bg-gradient-aqua">Gradient Aqua</div>
<div class="bg-gradient-success">Gradient Success</div>
```

### Hover Effects
```html
<!-- Lift Effect -->
<div class="hover-lift">Élévation au survol</div>

<!-- Scale Effect -->
<div class="hover-scale">Agrandissement au survol</div>

<!-- Glow Effect -->
<div class="hover-glow">Lueur au survol</div>
```

### Dividers
```html
<!-- Simple Line -->
<div class="divider"></div>

<!-- Gradient Line -->
<div class="divider-gradient"></div>
```

### Empty States
```html
<div class="empty-state">
    <div class="empty-state-icon">
        <i class="fas fa-inbox"></i>
    </div>
    <h3 class="empty-state-title">Aucun projet trouvé</h3>
    <p class="empty-state-description">
        Commencez par créer votre premier projet
    </p>
    <button class="btn-project primary">
        <i class="fas fa-plus"></i>
        Créer un Projet
    </button>
</div>
```

### Loading States
```html
<!-- Skeleton Loader -->
<div class="loading-skeleton" style="height: 100px; width: 100%;"></div>
```

### Responsive Utilities
```html
<!-- Caché sur mobile -->
<div class="hide-mobile">Desktop only</div>

<!-- Caché sur tablette et + -->
<div class="hide-tablet-up">Mobile only</div>

<!-- Caché sur desktop -->
<div class="hide-desktop">Mobile/Tablet only</div>
```

---

## 📱 Breakpoints Responsive

```css
/* Mobile First (défaut) */
< 768px

/* Tablet */
@media (min-width: 768px)

/* Desktop */
@media (min-width: 1024px)
```

---

## 🎨 Animations Incluses

### Pulse (badge en-cours)
```css
animation: pulse-green 2s infinite;
```

### Shimmer (progress bar)
```css
animation: shimmer 2s infinite;
```

### Loading Pulse (skeleton)
```css
animation: loading-pulse 1.5s infinite;
```

---

## 💡 Conseils d'Utilisation

1. **Mobile First**: Toujours commencer par le design mobile
2. **Cohérence**: Utiliser les variables CSS pour les couleurs
3. **Performance**: Utiliser `will-change` pour les animations fréquentes
4. **Accessibilité**: Toujours inclure des labels ARIA
5. **Transitions**: Utiliser les variables de transition (fast, normal, slow)

---

## 🔧 Personnalisation

Pour personnaliser les couleurs, modifier les variables CSS dans `:root`:

```css
:root {
    --navy: #votre-couleur;
    --ocean: #votre-couleur;
    /* etc. */
}
```

---

## 📚 Exemples Complets

Consultez les vues suivantes pour des exemples d'utilisation complète:
- `resources/views/project/admin/projects/index.blade.php`
- `resources/views/project/front/index.blade.php`
- `resources/views/project/front/show.blade.php`

---

**Version**: 1.0  
**Dernière mise à jour**: {{ date('Y-m-d') }}  
**Auteur**: AquaSecure Development Team
