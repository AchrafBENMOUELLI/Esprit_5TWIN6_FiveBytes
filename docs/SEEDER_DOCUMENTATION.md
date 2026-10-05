# Documentation du Seeder - Module Gestion 5

## ProjectModuleSeeder

Le `ProjectModuleSeeder` génère un jeu de données complet et cohérent pour le module "Gestion 5 : Projets de Rénovation et Financement".

---

## 📊 Données Générées

### 1. Contractors (15)
- 15 prestataires avec des noms d'entreprises réalistes
- Spécialités variées du secteur eau potable
- Coordonnées complètes (email, téléphone, adresse)

### 2. Projects (30)
Répartis selon la distribution suivante :
- **20% planifié** (6 projets) - Projets à venir
- **~47% en_cours** (14 projets) - Projets actifs
- **20% terminé** (6 projets) - Projets complétés
- **13% suspendu/annulé** (4 projets) - Aléatoire

**Caractéristiques :**
- Répartis sur toutes les zones disponibles
- 60% ont une infrastructure liée
- Budget entre 20K€ et 500K€ selon le type
- Dates cohérentes
- Responsable assigné (gestionnaire)

### 3. Project Phases (2-4 par projet)
Pour chaque projet, création de 2 à 4 phases :
- **Contractors différents** pour chaque phase
- **Noms de phases** : Phase 1 - Études et préparation, Phase 2 - Travaux préparatoires, etc.
- **Dates** : Dans la plage du projet parent, séquentielles
- **Coût** : 80-120% du budget moyen par phase
- **Avancement** : Cohérent avec le statut du projet
  - Planifié : 0%
  - En cours : Variable selon la phase
  - Terminé : 100%
  - Suspendu : 20-60%
  - Annulé : 0-50%

**Budget total des phases :** 80-120% du budget prévu du projet

### 4. Fundings (1-5 par projet)
Sources de financement variées :
- **Municipal** : Toujours présent si ≥2 financements
- **Régional, Fédéral, Européen, Privé** : Sélection variée
- **Don** : Inclus aléatoirement, avec donateur (citoyen)

**Montants :**
- **Total des financements** : 95-105% du budget prévu
- **Répartition** : Proportionnelle entre les sources
- **Dons** : Limités à 100-5000€

**Dates de versement :** Entre 6 mois avant le début et la fin du projet

### 5. Project Documents (2-6 par projet)
Types de documents :
- **rapport** : Rapports d'étude, d'avancement
- **photo** : Photos avant/pendant/après travaux
- **facture** : Factures de matériaux et prestations
- **contrat** : Contrats avec prestataires
- **plan** : Plans techniques
- **autre** : Documents administratifs

**Évite les doublons** quand possible dans un même projet.

---

## ✅ Garanties de Cohérence

### Dates
✅ Toutes les phases sont dans la période du projet  
✅ Les phases sont séquentielles (pas de chevauchement)  
✅ Les dates de versement des financements sont logiques

### Budget
✅ Coût total des phases : 80-120% du budget prévu  
✅ Total des financements : 95-105% du budget prévu  
✅ Chaque phase a un coût proportionnel

### Relations
✅ Chaque phase a un contractor différent (quand possible)  
✅ Les dons ont toujours un donateur (citoyen)  
✅ Les projets sont répartis sur toutes les zones  
✅ 60% des projets ont une infrastructure liée

### Avancement
✅ Avancement cohérent avec le statut du projet  
✅ Projets terminés : 100%  
✅ Projets planifiés : 0-10%  
✅ Projets en cours : variable selon les phases

---

## 🚀 Utilisation

### Seeding complet
```bash
php artisan migrate:fresh --seed
```

### Seeding du module uniquement
```bash
php artisan db:seed --class=ProjectModuleSeeder
```

**Note :** Le ProjectModuleSeeder nécessite que les zones et infrastructures soient déjà créées (Gestion 1).

---

## 📋 Statistiques Réelles (Exemple d'Exécution)

```
✓ Contractors: 15
✓ Projects: 30
✓ Project Phases: 87 (moyenne: 2.9 par projet)
✓ Fundings: 88 (moyenne: 2.9 par projet)
✓ Documents: 119 (moyenne: 4 par projet)

Projects by status:
  • planifié: 7 (23.3%)
  • en_cours: 17 (56.7%)
  • terminé: 6 (20%)

Projects by type:
  • rénovation: 6 (20%)
  • décontamination: 6 (20%)
  • extension: 13 (43.3%)
  • modernisation: 5 (16.7%)

Projects with infrastructure:
  • With: 16 (53.3%)
  • Without: 14 (46.7%)

Financial data:
  • Total budget: 6,899,649.63 €
  • Average budget: 229,988.32 €

Fundings by source:
  • municipal: 25 financements, 2,099,536.22 € total
  • régional: 11 financements, 585,549.95 € total
  • fédéral: 17 financements, 2,041,521.64 € total
  • européen: 12 financements, 661,957.86 € total
  • privé: 11 financements, 807,860.76 € total
  • don: 12 financements, 32,311.00 € total

✓ Tous les dons ont un donateur
```

---

## 🔍 Vérification de Cohérence

Un script de vérification est disponible :
```bash
php tests/verify_seeding.php
```

Ce script vérifie :
- ✅ Nombre d'entités créées
- ✅ Cohérence des dates (phases dans le projet)
- ✅ Cohérence des budgets (phases vs budget prévu)
- ✅ Cohérence des financements (total vs budget)
- ✅ Relations correctes (dons avec donateurs)
- ✅ Distribution des statuts et types

---

## 📝 Exemple de Projet Généré

```
📋 Projet: Extension réseau nouveaux quartiers - East Theastad
-----------------------------------
Type: extension
Statut: terminé
Budget prévu: 183,766.44 €
Avancement: 100%
Dates: 2024-10-31 → 2026-04-16

📦 Phases (4):
  ✓ Phase 1 - Études et préparation: 38,025.87 € (100%)
  ✓ Phase 2 - Travaux préparatoires: 35,981.47 € (100%)
  ✓ Phase 3 - Travaux principaux: 33,528.19 € (100%)
  ✓ Phase 4 - Finitions: 38,434.75 € (100%)
  Total: 145,970.28 € (79.4% du budget)

💰 Financements (3):
  • municipal: 72,698.00 €
  • régional: 17,346.08 €
  • don: 4,907.00 € (Donateur: User #9)
  Total: 94,951.08 € (51.7% du budget)

📄 Documents (3):
  • contrat: 1
  • facture: 1
  • autre: 1

🔗 Relations:
  ✓ Zone: Zone Rurale
  ✓ Infrastructure: Aucune
  ✓ Responsable: Mrs. Marian Lakin MD
```

---

## 🎯 Intégration dans DatabaseSeeder

Le seeder est intégré dans `DatabaseSeeder.php` :

```php
// Ordre d'exécution :
1. Users (admin, gestionnaires, citoyens)
2. InfrastructureModuleSeeder (zones et infrastructures)
3. ProjectModuleSeeder (contractors, projects, phases, fundings, documents)
```

**Credentials par défaut :**
- Admin: `admin@aquasecure.com` / `password123`
- Gestionnaire: `gestionnaire@aquasecure.com` / `password123`
- Citoyen: `citoyen@aquasecure.com` / `password123`

---

## ⚙️ Personnalisation

Pour modifier la quantité de données générées, éditer `ProjectModuleSeeder.php` :

```php
// Ligne 25 : Nombre de contractors
$contractors = Contractor::factory()->count(15)->create();

// Ligne 45 : Distribution des projets
$projectsData = [
    ['state' => 'planifie', 'count' => 6],
    ['state' => 'enCours', 'count' => 14],
    ['state' => 'termine', 'count' => 6],
    ['state' => null, 'count' => 4],
];

// Ligne 95 : Nombre de phases par projet
$numberOfPhases = rand(2, 4);

// Ligne 137 : Nombre de financements par projet
$numberOfFundings = rand(1, 5);

// Ligne 192 : Nombre de documents par projet
$numberOfDocuments = rand(2, 6);
```

---

**Date de création :** 2026-10-05  
**Module :** Gestion 5 - Projets de Rénovation et Financement  
**Statut :** ✅ Seeder complet et testé
