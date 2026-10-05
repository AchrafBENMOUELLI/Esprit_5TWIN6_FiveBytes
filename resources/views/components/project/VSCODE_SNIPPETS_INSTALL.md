# Installation des Snippets VSCode - Module Project

## 📦 Qu'est-ce que c'est ?

Les snippets VSCode sont des raccourcis qui vous permettent de générer rapidement du code HTML avec les classes CSS du module Project.

Par exemple, taper `aq-project-card` + Tab génère automatiquement une card complète !

## 🚀 Installation

### Méthode 1 : Installation Globale (Recommandée)

1. **Ouvrir VSCode**

2. **Accéder aux Snippets Utilisateur** :
   - Windows/Linux : `Ctrl + Shift + P` → "Preferences: Configure User Snippets"
   - Mac : `Cmd + Shift + P` → "Preferences: Configure User Snippets"

3. **Sélectionner "html.json"** (ou créer si inexistant)

4. **Copier le contenu** de `vscode-snippets.json` et le coller dans `html.json`

5. **Sauvegarder** et redémarrer VSCode

### Méthode 2 : Installation Workspace (Projet uniquement)

1. Créer le dossier `.vscode` à la racine du projet (s'il n'existe pas)

2. Créer le fichier `.vscode/html.json`

3. Copier le contenu de `vscode-snippets.json` dans ce fichier

4. Les snippets seront disponibles uniquement pour ce projet

## 📝 Snippets Disponibles

### Composants Principaux

| Prefix | Description |
|--------|-------------|
| `aq-project-card` | Card de projet complète |
| `aq-badge-status` | Badge de statut (planifié, en cours, etc.) |
| `aq-badge-priority` | Badge de priorité (haute, moyenne, basse) |
| `aq-progress-bar` | Barre de progression personnalisée |
| `aq-timeline` | Timeline complète |
| `aq-timeline-item` | Item de timeline seul |
| `aq-budget-chart` | Graphique budget complet |
| `aq-budget-stats` | Grille de statistiques budget |
| `aq-btn` | Bouton d'action |
| `aq-empty-state` | État vide avec icône |

### Utilitaires

| Prefix | Description |
|--------|-------------|
| `aq-meta-item` | Item de métadonnées |
| `aq-divider` | Ligne de séparation |
| `aq-skeleton` | Skeleton loader |
| `aq-hover` | Classe d'effet hover |
| `aq-text-color` | Classe de couleur de texte |
| `aq-bg-gradient` | Classe de fond dégradé |

## 💡 Utilisation

### Exemple 1 : Créer une Card

1. Dans un fichier `.blade.php`, tapez : `aq-project-card`
2. Appuyez sur `Tab`
3. La card complète est générée !
4. Utilisez `Tab` pour naviguer entre les champs à remplir

```html
<!-- Résultat après avoir tapé "aq-project-card" + Tab -->
<div class="project-card">
    <div class="project-card-header">
        <div class="project-card-icon">
            <i class="fas fa-tools"></i> <!-- Curseur ici -->
        </div>
        <!-- ... reste du code -->
    </div>
</div>
```

### Exemple 2 : Ajouter un Badge

1. Tapez : `aq-badge-status`
2. `Tab`
3. Choisissez le statut dans le menu déroulant
4. `Tab` pour remplir le texte

```html
<!-- Résultat -->
<span class="badge-status en-cours">
    <i class="fas fa-circle"></i>
    En Cours
</span>
```

### Exemple 3 : Timeline Rapide

1. Tapez : `aq-timeline`
2. `Tab`
3. Remplissez le premier item
4. Pour ajouter plus d'items, tapez `aq-timeline-item` + `Tab`

## 🎯 Raccourcis Clavier Utiles

| Raccourci | Action |
|-----------|--------|
| `Ctrl/Cmd + Space` | Afficher les suggestions de snippets |
| `Tab` | Naviguer au prochain champ à remplir |
| `Shift + Tab` | Revenir au champ précédent |
| `Esc` | Annuler le snippet |

## 🔍 Auto-Complétion

VSCode affichera automatiquement les suggestions de snippets quand vous tapez `aq-`.

Pour forcer l'affichage des suggestions :
- Windows/Linux : `Ctrl + Space`
- Mac : `Cmd + Space`

## 📋 Liste Complète des Préfixes

Tous les snippets commencent par `aq-` (pour AquaSecure) :

```
aq-project-card      → Card de projet complète
aq-badge-status      → Badge de statut
aq-badge-priority    → Badge de priorité
aq-progress-bar      → Barre de progression
aq-timeline          → Timeline complète
aq-timeline-item     → Item de timeline
aq-budget-chart      → Graphique budget
aq-budget-stats      → Stats budget
aq-btn               → Bouton
aq-empty-state       → État vide
aq-meta-item         → Meta item
aq-divider           → Séparateur
aq-skeleton          → Skeleton
aq-hover             → Hover effect
aq-text-color        → Couleur texte
aq-bg-gradient       → Fond dégradé
```

## 🎨 Snippets avec Choix Multiples

Certains snippets proposent des choix via menu déroulant :

### `aq-badge-status`
Choix : `planifie`, `en-cours`, `termine`, `suspendu`, `annule`

### `aq-badge-priority`
Choix : `haute`, `moyenne`, `basse`

### `aq-progress-bar`
- Taille : vide (normal), `small`, `large`
- Couleur : vide (bleu), `success`, `warning`, `danger`

### `aq-btn`
- Variante : `primary`, `success`, `warning`, `danger`, `outline`, `ghost`
- Taille : vide (normal), `small`, `large`, `icon-only`

### `aq-timeline-marker`
Couleur : vide (bleu), `success`, `warning`, `danger`, `muted`

## 🔧 Personnalisation

Vous pouvez modifier les snippets selon vos besoins :

1. Ouvrez le fichier de snippets (`html.json`)
2. Modifiez le contenu du snippet
3. Sauvegardez

Exemple - Ajouter un snippet personnalisé :

```json
{
  "Mon Custom Snippet": {
    "prefix": "aq-custom",
    "body": [
      "<div class=\"ma-classe\">",
      "    ${1:Contenu}",
      "</div>"
    ],
    "description": "Mon snippet personnalisé"
  }
}
```

## ❓ Dépannage

### Les snippets ne s'affichent pas

**Solution 1** : Vérifier que le fichier est bien nommé `html.json`

**Solution 2** : Redémarrer VSCode

**Solution 3** : Vérifier les paramètres VSCode :
```json
{
  "editor.quickSuggestions": {
    "other": true,
    "comments": false,
    "strings": true
  }
}
```

### Les snippets s'affichent mais ne se complètent pas

**Solution** : Assurez-vous d'appuyer sur `Tab` (et non `Enter`)

### Conflit avec d'autres extensions

**Solution** : Désactiver temporairement les autres extensions de snippets HTML

## 📚 Ressources

- [Documentation VSCode Snippets](https://code.visualstudio.com/docs/editor/userdefinedsnippets)
- [Snippet Generator Online](https://snippet-generator.app/)
- [Guide CSS du Module](./PROJECT_CSS_GUIDE.md)

## 🎉 Productivité Maximale !

Avec ces snippets, vous pouvez créer des interfaces complètes en quelques secondes !

**Exemple de workflow** :
1. `aq-project-card` + Tab → Card complète en 3 secondes
2. `aq-progress-bar` + Tab → Progress bar en 2 secondes  
3. `aq-btn` + Tab → Bouton stylisé en 1 seconde

**Gain de temps estimé** : 70-80% sur le développement HTML/CSS !

---

**Questions ?** Consultez la [documentation CSS complète](./PROJECT_CSS_GUIDE.md)

**Version** : 1.0  
**Dernière mise à jour** : {{ date('Y-m-d') }}
