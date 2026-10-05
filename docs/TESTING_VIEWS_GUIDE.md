# Guide de Test des Vues - Module Gestion 5

## 🧪 Objectif

Ce guide vous aide à tester toutes les vues créées pour le module Gestion 5 de manière systématique.

---

## 🚀 Préparation

### 1. Vérifier que les données existent en base

```bash
# Exécuter les seeders si ce n'est pas déjà fait
php artisan db:seed --class=InfrastructureModuleSeeder
php artisan db:seed --class=ProjectModuleSeeder
```

### 2. Créer un utilisateur admin (si nécessaire)

```bash
php artisan tinker
```

```php
use App\Models\User;
use App\Enums\UserRole;

$admin = User::create([
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => UserRole::ADMIN->value,
    'email_verified_at' => now(),
]);
```

### 3. Créer un utilisateur citoyen

```php
$citoyen = User::create([
    'name' => 'Citoyen Test',
    'email' => 'citoyen@test.com',
    'password' => bcrypt('password'),
    'role' => UserRole::CITOYEN->value,
    'email_verified_at' => now(),
]);
```

### 4. Lancer le serveur de développement

```bash
php artisan serve
```

---

## 🔐 Tests Administration (Back Office)

### Se connecter en tant qu'admin
1. Aller sur `http://127.0.0.1:8000/login`
2. Email: `admin@test.com`
3. Mot de passe: `password`
4. Cliquer sur "Se connecter"

### ✅ Test 1: Liste des Projets

**URL:** `http://127.0.0.1:8000/admin/projects`

**Checklist:**
- [ ] La page se charge sans erreur
- [ ] Les statistiques s'affichent (4 cartes en haut)
- [ ] Le tableau contient des projets
- [ ] Les badges de statut sont colorés correctement
- [ ] Les barres de progression sont visibles
- [ ] Le bouton "Nouveau Projet" est présent
- [ ] Les filtres fonctionnent (recherche, type, statut)
- [ ] La pagination fonctionne (si > 10 projets)
- [ ] Les actions (Voir, Modifier, Supprimer) sont cliquables

**Test des filtres:**
```
1. Taper "Rénovation" dans la recherche → Filtrer
2. Sélectionner "En cours" dans statut → Filtrer
3. Cliquer sur "Réinitialiser"
```

### ✅ Test 2: Créer un Projet

**URL:** `http://127.0.0.1:8000/admin/projects/create`

**Checklist:**
- [ ] Le formulaire s'affiche en 2 colonnes
- [ ] Tous les champs sont présents
- [ ] Les listes déroulantes sont remplies (zones, infrastructures, responsables)
- [ ] Le filtrage des infrastructures par zone fonctionne (JavaScript)
- [ ] La validation inline fonctionne (essayer de soumettre à vide)
- [ ] Remplir le formulaire et cliquer sur "Créer le projet"
- [ ] Redirection vers la page de détails du projet
- [ ] Message flash "Projet créé avec succès"

**Données de test:**
```
Titre: Test Projet Nouveau
Type: Modernisation
Description: Ceci est un projet de test
Budget prévu: 150000
Date début: 2026-11-01
Date fin: 2027-06-30
Zone: Sélectionner une zone
Infrastructure: Sélectionner une infrastructure (filtrée par zone)
Responsable: Sélectionner un admin
Statut: Planifié
Avancement: 0
```

### ✅ Test 3: Modifier un Projet

1. Depuis la liste des projets, cliquer sur l'icône "Modifier" (crayon)
2. **URL:** `http://127.0.0.1:8000/admin/projects/{id}/edit`

**Checklist:**
- [ ] Le formulaire est pré-rempli avec les données existantes
- [ ] Modifier le titre (ajouter " - Modifié")
- [ ] Changer l'avancement à 25%
- [ ] La barre de progression se met à jour en temps réel
- [ ] Cliquer sur "Enregistrer les modifications"
- [ ] Redirection vers la page de détails
- [ ] Message flash "Projet modifié avec succès"
- [ ] Les modifications sont visibles

### ✅ Test 4: Détails d'un Projet

1. Depuis la liste, cliquer sur l'icône "Voir" (œil)
2. **URL:** `http://127.0.0.1:8000/admin/projects/{id}`

**Checklist:**
- [ ] Toutes les informations du projet sont affichées
- [ ] Les badges de statut et type sont présents
- [ ] Les 3 cartes de budget sont visibles (prévu, obtenu, restant)
- [ ] Le calcul des jours restants fonctionne
- [ ] **Section Phases:**
  - [ ] Le bouton "Ajouter une phase" est présent
  - [ ] Les phases existantes s'affichent en tableau
  - [ ] Le total des coûts est calculé
  - [ ] Les actions (Modifier, Supprimer) fonctionnent
- [ ] **Section Financements:**
  - [ ] Le bouton "Ajouter un financement" est présent
  - [ ] Les financements s'affichent avec leurs statuts
  - [ ] Les boutons Approuver/Refuser sont visibles (si statut en_attente)
  - [ ] Le total est calculé
- [ ] **Section Documents:**
  - [ ] Le bouton "Ajouter un document" est présent
  - [ ] Les documents s'affichent en grille
  - [ ] Le bouton "Télécharger" fonctionne

### ✅ Test 5: Supprimer un Projet

1. Depuis la liste des projets, cliquer sur l'icône "Supprimer" (poubelle)
2. Confirmer la suppression dans la popup JavaScript
3. **Checklist:**
   - [ ] Popup de confirmation s'affiche
   - [ ] Après confirmation, redirection vers la liste
   - [ ] Message flash "Projet supprimé avec succès"
   - [ ] Le projet n'apparaît plus dans la liste

### ✅ Test 6: Liste des Contractants

**URL:** `http://127.0.0.1:8000/admin/contractors`

**Checklist:**
- [ ] La page se charge sans erreur
- [ ] Les statistiques s'affichent (4 cartes)
- [ ] Le tableau contient des contractants
- [ ] Les contacts (téléphone, email) sont affichés avec icônes
- [ ] Les spécialités sont affichées en badges
- [ ] Le compteur de phases actives fonctionne
- [ ] Les filtres fonctionnent (nom, spécialité)
- [ ] Le bouton "Nouveau Contractant" est présent

---

## 🌐 Tests Front Office (Citoyens)

### Se déconnecter et reconnecter en tant que citoyen
1. Cliquer sur "Déconnexion"
2. Se reconnecter avec `citoyen@test.com` / `password`

### ✅ Test 7: Liste des Projets (Public)

**URL:** `http://127.0.0.1:8000/projets`

**Checklist:**
- [ ] La page se charge sans erreur
- [ ] Le hero est affiché avec titre et sous-titre
- [ ] Les 4 statistiques globales sont visibles
- [ ] Les projets s'affichent en grille de cartes (3 colonnes)
- [ ] Chaque carte affiche:
  - [ ] Badges (statut + type)
  - [ ] Titre et description
  - [ ] Zone et date
  - [ ] Budget et % financé
  - [ ] Barre d'avancement
  - [ ] Bouton "Voir les détails"
  - [ ] Bouton "Faire un don" (si connecté)
- [ ] Les filtres fonctionnent
- [ ] La pagination fonctionne
- [ ] La section CTA "Soutenez les projets" est visible en bas

### ✅ Test 8: Détails d'un Projet (Public)

1. Depuis la liste, cliquer sur "Voir les détails"
2. **URL:** `http://127.0.0.1:8000/projets/{id}`

**Checklist:**
- [ ] Layout 2/3 + 1/3 s'affiche correctement
- [ ] **Colonne principale:**
  - [ ] Détails du projet complets
  - [ ] Calendrier avec jours restants
  - [ ] Timeline des phases (design vertical)
  - [ ] Documents téléchargeables
- [ ] **Colonne latérale (sticky):**
  - [ ] Budget (3 items)
  - [ ] Bouton "Faire un don" est présent
  - [ ] Liste des sources de financement
  - [ ] Bouton "Retour à la liste"

### ✅ Test 9: Faire un Don

1. Depuis la page de détails, cliquer sur "Faire un don"
2. **URL:** `http://127.0.0.1:8000/projets/{id}/faire-un-don`

**Checklist:**
- [ ] Le formulaire de don s'affiche
- [ ] Les 4 montants suggérés sont cliquables
- [ ] Cliquer sur un montant pré-défini (ex: 100€)
  - [ ] Le montant apparaît dans le champ
  - [ ] Le bouton devient actif visuellement
- [ ] Champ montant personnalisé fonctionne
- [ ] Le message optionnel est présent
- [ ] La checkbox "Rester anonyme" fonctionne
- [ ] La checkbox d'accord est obligatoire
- [ ] La section "Impact du don" est visible (4 cartes)
- [ ] Le résumé du projet (colonne droite) est sticky

**Soumettre un don:**
```
Montant: 100
Message: "Je soutiens ce projet important !"
Accord: coché
Cliquer sur "Confirmer mon don"
```

**Vérifications:**
- [ ] Redirection vers la page "Mes dons"
- [ ] Message flash "Votre don a été enregistré avec succès"
- [ ] Le don apparaît dans la liste avec statut "En attente"

### ✅ Test 10: Mes Dons

**URL:** `http://127.0.0.1:8000/mes-dons`

**Checklist:**
- [ ] Les 4 statistiques personnelles s'affichent
- [ ] Le don créé précédemment est visible
- [ ] Les informations sont correctes:
  - [ ] Titre du projet (cliquable)
  - [ ] Date et heure
  - [ ] Montant (100 €)
  - [ ] Message affiché avec style italique
  - [ ] Badge "En attente" (orange)
  - [ ] Alert info "en cours de vérification"
- [ ] Le bouton "Voir le projet" fonctionne
- [ ] Le filtre par statut fonctionne

### ✅ Test 11: Approbation d'un Don (Admin)

1. Se déconnecter et reconnecter en tant qu'admin
2. Aller sur la page de détails d'un projet qui a le don en attente
3. Dans la section Financements, trouver le don avec statut "En attente"
4. Cliquer sur le bouton "Approuver" (check vert)

**Checklist:**
- [ ] Le statut passe à "Confirmé"
- [ ] Le badge devient vert
- [ ] Les boutons Approuver/Refuser disparaissent
- [ ] Le total des financements est mis à jour

5. Se reconnecter en tant que citoyen
6. Retourner sur "Mes dons"

**Checklist:**
- [ ] Le don a maintenant le statut "Confirmé"
- [ ] Le badge "Reçu fiscal disponible" est visible
- [ ] La barre d'avancement du projet est affichée
- [ ] L'alert info a disparu

---

## 📱 Tests Responsive

### Desktop (1920x1080)
- [ ] Tous les layouts s'affichent correctement
- [ ] Les grilles sont en 3 ou 4 colonnes
- [ ] Le sidebar admin est visible
- [ ] Les cartes sticky fonctionnent

### Tablet (768x1024)
- [ ] Les grilles passent en 2 colonnes
- [ ] Le sidebar admin devient un hamburger menu
- [ ] Les formulaires s'adaptent
- [ ] Les tableaux deviennent scrollables

### Mobile (375x667)
- [ ] Les grilles passent en 1 colonne
- [ ] Le menu est en hamburger
- [ ] Les tableaux sont scrollables horizontalement
- [ ] Les boutons sont en pleine largeur
- [ ] Les formulaires sont empilés verticalement

**Comment tester:**
```
Dans Chrome/Firefox:
1. Ouvrir les DevTools (F12)
2. Cliquer sur l'icône "Toggle device toolbar" (Ctrl+Shift+M)
3. Sélectionner différents devices: iPhone, iPad, etc.
4. Tester toutes les pages
```

---

## 🎨 Tests Visuels

### Couleurs
- [ ] Navy (#0b2545) pour titres et texte important
- [ ] Ocean (#1565c0) pour boutons primaires
- [ ] Aqua (#00b8d9) pour accents et badges info
- [ ] Success (#2e9e5b) pour badges succès
- [ ] Warning (#f59e0b) pour badges avertissement
- [ ] Danger (#d93b3b) pour badges danger

### Typographie
- [ ] Titres h1, h2, h3 ont la bonne hiérarchie
- [ ] Texte lisible (line-height: 1.6)
- [ ] Contraste suffisant (WCAG AA)

### Espacements
- [ ] Pas de chevauchement d'éléments
- [ ] Marges cohérentes (multiples de 4px)
- [ ] Padding suffisant dans les cards

### Animations
- [ ] Transitions smooth sur hover (boutons, liens)
- [ ] Pas d'animations saccadées
- [ ] Les progress bars se remplissent correctement

---

## ⚠️ Tests d'Erreurs

### Validation de formulaires

**Test 1: Créer un projet sans remplir les champs**
1. Aller sur `/admin/projects/create`
2. Cliquer sur "Créer le projet" sans remplir
3. **Vérifier:**
   - [ ] Messages d'erreur s'affichent en rouge sous chaque champ
   - [ ] Les champs requis sont marqués avec bordure rouge
   - [ ] La page ne se recharge pas (erreurs inline)

**Test 2: Montant de don invalide**
1. Aller sur `/projets/{id}/faire-un-don`
2. Essayer de soumettre avec montant = 5 (inférieur au minimum)
3. **Vérifier:**
   - [ ] Message d'erreur s'affiche
   - [ ] Le formulaire n'est pas soumis

**Test 3: Supprimer un projet avec des dépendances**
1. Essayer de supprimer un projet qui a des phases/financements
2. **Vérifier:**
   - [ ] Message d'erreur s'affiche (contrainte foreign key)
   - [ ] Le projet n'est pas supprimé
   - [ ] Suggestion de supprimer d'abord les dépendances

### Tests 404

**Test 1: Projet inexistant**
- URL: `http://127.0.0.1:8000/projets/99999`
- **Vérifier:** Page 404 s'affiche

**Test 2: Route invalide**
- URL: `http://127.0.0.1:8000/admin/invalid-route`
- **Vérifier:** Page 404 s'affiche

### Tests de permissions

**Test 1: Citoyen essaie d'accéder à l'admin**
1. Se connecter en tant que citoyen
2. Essayer d'aller sur `http://127.0.0.1:8000/admin/projects`
3. **Vérifier:**
   - [ ] Redirection vers une page d'erreur ou la page d'accueil
   - [ ] Message "Accès non autorisé"

**Test 2: Utilisateur non connecté essaie de faire un don**
1. Se déconnecter
2. Aller sur un projet et cliquer sur "Faire un don"
3. **Vérifier:**
   - [ ] Redirection vers la page de connexion
   - [ ] Message "Vous devez être connecté"

---

## 🔍 Checklist Accessibilité

### Clavier
- [ ] Tab permet de naviguer entre tous les éléments interactifs
- [ ] Enter/Space activent les boutons
- [ ] Escape ferme les modales/dropdowns
- [ ] Pas de piège au clavier

### Screen readers
- [ ] Tous les boutons ont des labels
- [ ] Les images ont du texte alternatif
- [ ] Les formulaires ont des labels associés
- [ ] Les messages d'erreur sont annoncés

### Contraste
- [ ] Texte noir/gris foncé sur fond blanc: ratio ≥ 4.5:1
- [ ] Texte blanc sur fond bleu: ratio ≥ 4.5:1
- [ ] Boutons ont un contraste suffisant

### Focus
- [ ] Tous les éléments interactifs ont un état :focus visible
- [ ] L'ordre de tabulation est logique

---

## 📊 Résultat Attendu

### Si tous les tests passent ✅
- Toutes les vues sont fonctionnelles
- Le design est cohérent et responsive
- La navigation est intuitive
- Les formulaires valident correctement
- Les messages flash s'affichent
- Le workflow complet (citoyen fait un don → admin approuve) fonctionne

### Si certains tests échouent ❌
1. Noter les erreurs précises (URL, action, message d'erreur)
2. Vérifier les logs Laravel: `storage/logs/laravel.log`
3. Vérifier la console du navigateur (F12 → Console)
4. Consulter la documentation des vues: `docs/VIEWS_DOCUMENTATION.md`

---

## 🛠️ Commandes Utiles

```bash
# Voir les routes
php artisan route:list --path=admin
php artisan route:list --path=projets

# Clear les caches
php artisan view:clear
php artisan route:clear
php artisan config:clear

# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Recréer la base de données
php artisan migrate:fresh --seed
```

---

## 📝 Rapport de Test (Template)

```markdown
# Rapport de Test - Module Gestion 5

**Date:** 2026-10-05
**Testeur:** [Votre nom]
**Environnement:** Local / Dev / Staging

## Tests Administration
- [ ] Liste des projets: ✅ / ❌
- [ ] Créer un projet: ✅ / ❌
- [ ] Modifier un projet: ✅ / ❌
- [ ] Détails d'un projet: ✅ / ❌
- [ ] Supprimer un projet: ✅ / ❌
- [ ] Liste des contractants: ✅ / ❌

## Tests Front Office
- [ ] Liste des projets (public): ✅ / ❌
- [ ] Détails d'un projet (public): ✅ / ❌
- [ ] Faire un don: ✅ / ❌
- [ ] Mes dons: ✅ / ❌
- [ ] Approbation d'un don: ✅ / ❌

## Tests Responsive
- [ ] Desktop (1920x1080): ✅ / ❌
- [ ] Tablet (768x1024): ✅ / ❌
- [ ] Mobile (375x667): ✅ / ❌

## Tests Visuels
- [ ] Couleurs cohérentes: ✅ / ❌
- [ ] Typographie: ✅ / ❌
- [ ] Espacements: ✅ / ❌
- [ ] Animations: ✅ / ❌

## Tests d'Erreurs
- [ ] Validation formulaires: ✅ / ❌
- [ ] Pages 404: ✅ / ❌
- [ ] Tests de permissions: ✅ / ❌

## Tests Accessibilité
- [ ] Navigation clavier: ✅ / ❌
- [ ] Screen readers: ✅ / ❌
- [ ] Contraste: ✅ / ❌
- [ ] Focus: ✅ / ❌

## Bugs identifiés
1. [Description du bug]
   - Gravité: Critique / Majeure / Mineure
   - Étapes pour reproduire:
   - Solution proposée:

## Améliorations suggérées
1. [Suggestion]

## Conclusion
✅ Tous les tests passent - Prêt pour production
❌ Bugs à corriger avant production
```

---

**Version:** 1.0  
**Dernière mise à jour:** 2026-10-05  
**Créé par:** Kiro AI Agent
