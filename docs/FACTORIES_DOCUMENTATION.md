# Documentation des Factories - Gestion 5 : Projets de Rénovation et Financement

## 📦 Factories Créées

Toutes les factories ont été créées avec des données réalistes en français, adaptées au contexte de gestion de l'eau potable.

---

### 1. **ContractorFactory** ✅

**Données générées :**
- ✅ **Noms d'entreprises réalistes** : Aquatech Solutions, HydroServices France, Canalisations du Nord, etc.
- ✅ **Spécialités** : Rénovation canalisations, Décontamination, Pose de compteurs, Travaux de forage, Électromécanique, etc.
- ✅ **Emails professionnels** : Format `entrepriseslug@domain.fr` (automatiquement en minuscules)
- ✅ **Téléphones français** : Format `+33 X ## ## ## ##`
- ✅ **Adresses françaises** : Avec villes réelles (Lyon, Marseille, Toulouse, Nice, etc.)

**Exemple de sortie :**
```
Travaux Hydrauliques Martin
Spécialité: Pose de compteurs
Email: travauxhydrauliquesmartin@entreprise.fr
Téléphone: +33 9 89 79 94 62
Adresse: 45 avenue Jean Jaurès, 69000 Lyon
```

**Utilisation :**
```php
// Créer un contractor
$contractor = Contractor::factory()->create();

// Créer plusieurs
$contractors = Contractor::factory()->count(10)->create();

// Créer sans persister
$contractor = Contractor::factory()->make();
```

---

### 2. **ProjectFactory** ✅

**Données générées :**
- ✅ **Titres réalistes** : "Remplacement canalisation principale", "Décontamination réservoir Est", etc.
- ✅ **Types** : rénovation, décontamination, extension, modernisation (aléatoire)
- ✅ **Budget** : Entre 10,000€ et 500,000€ selon le type
- ✅ **Dates cohérentes** : date_debut < date_fin_prevue
- ✅ **Statut** : Distribué avec probabilités réalistes (45% en_cours, 20% planifié, etc.)
- ✅ **Avancement cohérent** : Aligné avec le statut (planifié: 0-10%, en_cours: 20-80%, terminé: 100%)
- ✅ **Zone** : Récupère une zone existante
- ✅ **Infrastructure** : 50% de chance d'être lié à une infrastructure
- ✅ **Responsable** : User avec rôle Gestionnaire

**Descriptions générées selon le type :**
- **Rénovation** : "Rénovation complète des canalisations vétustes... Remplacement des tuyaux en fonte..."
- **Décontamination** : "Opération de décontamination et nettoyage approfondi... Élimination des dépôts..."
- **Extension** : "Extension du réseau d'eau potable... Pose de 2 km de canalisations..."
- **Modernisation** : "Modernisation du système de télégestion... Installation de compteurs intelligents..."

**States disponibles :**
```php
// Projet planifié (commence dans le futur)
$project = Project::factory()->planifie()->create();

// Projet en cours
$project = Project::factory()->enCours()->create();

// Projet terminé
$project = Project::factory()->termine()->create();
```

**Exemple de sortie :**
```
Titre: Rénovation réservoir d'eau communal - Port Rodgerland
Type: extension
Statut: en_cours
Budget: 316,255.19 €
Avancement: 22%
Dates: 2024-12-22 → 2025-09-21
```

---

### 3. **ProjectPhaseFactory** ✅

**Données générées :**
- ✅ **Noms de phases** : "Phase 1 - Préparation", "Travaux principaux", "Tests d'étanchéité", etc.
- ✅ **Dates dans la plage du projet parent** : Respect automatique des dates du projet
- ✅ **Coût proportionnel** : Entre 10% et 40% du budget du projet
- ✅ **Avancement aléatoire** : Cohérent avec le statut du projet parent
- ✅ **Contractor assigné** : Prestataire aléatoire

**Logique intelligente :**
- Calcule la durée du projet parent
- Génère des dates de phase dans la plage du projet
- S'assure que la phase ne dépasse pas la date de fin du projet
- Coût proportionnel au budget total

**Utilisation :**
```php
// Phase pour un projet spécifique
$phase = ProjectPhase::factory()
    ->forProject($project)
    ->create();

// Phase avec contractor spécifique
$phase = ProjectPhase::factory()->create([
    'project_id' => $project->id,
    'contractor_id' => $contractor->id,
]);
```

**Exemple de sortie :**
```
Phase: Soudure et assemblage
Coût: 35,188.76 €
Avancement: 80%
Dates: 2024-03-15 → 2024-06-20
```

---

### 4. **FundingFactory** ✅

**Données générées :**
- ✅ **Sources variées** : municipal (35%), régional (25%), fédéral (15%), européen (10%), privé (10%), don (5%)
- ✅ **Donateur si source='don'** : User avec rôle Citoyen
- ✅ **Montants cohérents** : Proportionnels au budget du projet selon la source
- ✅ **Dates de versement** : Entre 6 mois avant le début du projet et la fin du projet

**Montants selon la source :**
- **Municipal** : 20-50% du budget projet
- **Régional** : 15-40% du budget projet
- **Fédéral** : 10-35% du budget projet
- **Européen** : 5-25% du budget projet
- **Privé** : 5-20% du budget projet
- **Don** : 100€ - 5,000€

**States disponibles :**
```php
// Financement municipal
$funding = Funding::factory()->municipal()->create();

// Don d'un citoyen
$funding = Funding::factory()->don()->create();

// Pour un projet spécifique
$funding = Funding::factory()
    ->forProject($project)
    ->create();
```

**Exemple de sortie :**
```
Source: municipal
Montant: 19,674.51 €
Donateur: N/A
Date de versement: 2024-10-15
```

---

### 5. **ProjectDocumentFactory** ✅

**Données générées :**
- ✅ **Titres réalistes par type** : "Rapport d'étude technique", "Photos avant travaux", "Facture matériaux Phase 1", etc.
- ✅ **Chemins de fichiers** : `storage/projects/{project_id}/documents/{filename}`
- ✅ **Types variés** : rapport, photo, facture, contrat, plan, autre
- ✅ **Extensions cohérentes** : PDF pour rapports, JPG pour photos, XLSX pour factures, etc.

**Titres par type :**
- **Rapport** : Rapport d'étude technique, Rapport d'avancement mensuel, Étude de faisabilité
- **Photo** : Photos avant travaux, Photos pendant chantier, Vue aérienne du site
- **Facture** : Facture matériaux Phase 1, Facture prestation Phase 2
- **Contrat** : Contrat prestataire principal, Convention de financement
- **Plan** : Plans techniques détaillés, Schémas de réseau, Plans de récolement
- **Autre** : Documents administratifs, Autorisations de travaux

**States disponibles :**
```php
// Document rapport
$doc = ProjectDocument::factory()->rapport()->create();

// Document photo
$doc = ProjectDocument::factory()->photo()->create();

// Document facture
$doc = ProjectDocument::factory()->facture()->create();

// Pour un projet spécifique
$doc = ProjectDocument::factory()
    ->forProject($project)
    ->create();
```

**Exemple de sortie :**
```
Document: Contrat sous-traitance
Type: contrat
Fichier: projects/1/documents/2026-10-05_contrat_sous-traitance_9857.pdf
Extension: pdf
```

---

## 🔗 Utilisation avec Relations

### Créer un projet complet avec toutes ses relations

```php
// Créer un projet
$project = Project::factory()->create();

// Ajouter des phases
$phases = ProjectPhase::factory()
    ->count(3)
    ->forProject($project)
    ->create();

// Ajouter des financements
$fundings = Funding::factory()
    ->count(2)
    ->forProject($project)
    ->create();

// Ajouter un don
$donation = Funding::factory()
    ->don()
    ->forProject($project)
    ->create();

// Ajouter des documents
$documents = ProjectDocument::factory()
    ->count(5)
    ->forProject($project)
    ->create();
```

### Créer avec états spécifiques

```php
// Projet en cours avec phases actives
$project = Project::factory()->enCours()->create();

ProjectPhase::factory()
    ->count(3)
    ->forProject($project)
    ->create();

// Projet terminé (avancement 100%)
$project = Project::factory()->termine()->create();
```

---

## ✅ Tests Effectués

Tous les tests sont passés avec succès :

```
✓ ContractorFactory: OK
  - Email automatiquement en minuscules: YES
  - Téléphone format français: +33 X ## ## ## ##
  
✓ ProjectFactory: OK
  - Titre réaliste généré
  - Budget entre 10K€ et 500K€
  - Avancement cohérent avec statut
  - Dates date_debut < date_fin_prevue
  
✓ ProjectPhaseFactory: OK
  - Dates dans la plage du projet
  - Coût proportionnel au budget
  - Avancement cohérent
  
✓ FundingFactory: OK
  - Source variée
  - donateur_id si source='don'
  - Montants réalistes
  
✓ ProjectDocumentFactory: OK
  - Titre réaliste par type
  - Extension cohérente
  - Chemin fichier structuré
```

---

## 📊 Distribution Réaliste

### Statuts de projets
- 45% **en_cours** (en cours de réalisation)
- 20% **planifié** (à venir)
- 20% **terminé** (complétés)
- 10% **suspendu** (temporairement arrêtés)
- 5% **annulé** (abandonnés)

### Sources de financement
- 35% **municipal** (municipalité)
- 25% **régional** (région)
- 15% **fédéral** (état)
- 10% **européen** (UE)
- 10% **privé** (entreprises)
- 5% **don** (citoyens)

---

## 🎯 Prochaine Étape

Les factories sont prêtes ! Vous pouvez maintenant passer à l'**Étape 5 : Création des Seeders**.

**Git Commands :**
```bash
git add database/factories/
git add tests/test_factories.php
git add docs/FACTORIES_DOCUMENTATION.md
git commit -m "feat(gestion-5): add factories with realistic French data for testing"
```

---

**Date de création :** 2026-10-05  
**Module :** Gestion 5 - Projets de Rénovation et Financement  
**Statut :** ✅ Factories complètes et testées
