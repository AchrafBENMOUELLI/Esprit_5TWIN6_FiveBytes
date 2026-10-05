# Module Quality - Documentation

## Vue d'ensemble

Le module Quality gère la qualité de l'eau à travers des échantillons, des paramètres analysés, des seuils de conformité et des alertes.

## Architecture

### Modèles

#### WaterSample (Échantillon d'eau)
- **Zone** : Zone géographique du prélèvement (requis)
- **Infrastructure** : Infrastructure liée (optionnel)
- **Préleveur** : Utilisateur ayant effectué le prélèvement
- **Date de prélèvement** : Date/heure du prélèvement
- **Résultat global** : Conforme ou Non conforme
- **Résumé IA** : Analyse générée par IA (optionnel)

**Relations :**
- `belongsTo` Zone
- `belongsTo` Infrastructure
- `belongsTo` User (preleveur)
- `hasMany` WaterParameter
- `hasMany` QualityAlert

#### WaterParameter (Paramètre analysé)
- **Échantillon** : Référence à WaterSample
- **Seuil** : Référence à Threshold
- **Valeur** : Valeur mesurée (decimal 10,3)
- **Dépasse seuil** : Booléen indiquant le dépassement

**Relations :**
- `belongsTo` WaterSample
- `belongsTo` Threshold

#### Threshold (Seuil de conformité)
- **Paramètre** : Type de paramètre (enum)
- **Unité** : Unité de mesure (mg/L, pH, etc.)
- **Valeur min** : Seuil minimum (optionnel)
- **Valeur max** : Seuil maximum (optionnel)
- **Niveau d'alerte** : Niveau de gravité si dépassement

**Relations :**
- `hasMany` WaterParameter

#### QualityAlert (Alerte qualité)
- **Échantillon** : Référence à WaterSample
- **Niveau** : Niveau de gravité (Faible, Moyen, Élevé, Critique)
- **Message** : Description de l'alerte
- **Publiée** : Booléen pour publication publique
- **Date résolution** : Date de résolution (null si active)

**Relations :**
- `belongsTo` WaterSample

### Enums

#### QualityParameter
Types de paramètres analysés :
- `pH` - pH (pH)
- `Turbidite` - Turbidité (NTU)
- `ChlorLibre` - Chlore libre (mg/L)
- `Temperature` - Température (°C)
- `Nitrates` - Nitrates (mg/L)
- `Nitrites` - Nitrites (mg/L)
- `Ammonium` - Ammonium (mg/L)
- `Conductivite` - Conductivité (µS/cm)
- `ColiformesTotaux` - Coliformes totaux (UFC/100mL)
- `EscherichiaColi` - Escherichia coli (UFC/100mL)
- `Plomb` - Plomb (µg/L)
- `Cuivre` - Cuivre (µg/L)
- `Fer` - Fer (µg/L)
- `Manganese` - Manganèse (µg/L)

#### AlertLevel
Niveaux d'alerte :
- `Faible` - Vigilance simple
- `Moyen` - Attention requise
- `Eleve` - Intervention recommandée
- `Critique` - Action immédiate nécessaire

#### ResultatGlobal
Résultat global de l'analyse :
- `Conforme` - Tous les paramètres dans les seuils
- `NonConforme` - Au moins un paramètre hors seuil

## Contrôleurs

### WaterSampleController
CRUD complet pour les échantillons d'eau :
- `index()` - Liste paginée
- `create()` - Formulaire de création
- `store()` - Enregistrement
- `show()` - Détails d'un échantillon
- `edit()` - Formulaire d'édition
- `update()` - Mise à jour
- `destroy()` - Suppression

### ThresholdController
CRUD complet pour les seuils :
- `index()` - Liste des seuils
- `create()` - Création de seuil
- `store()` - Enregistrement
- `show()` - Détails + paramètres liés
- `edit()` - Édition
- `update()` - Mise à jour
- `destroy()` - Suppression (bloquée si utilisé)

### QualityAlertController
Gestion des alertes :
- `index()` - Liste des alertes actives
- `show()` - Détails d'une alerte
- `update()` - Mise à jour
- `resolve()` - Marquer comme résolue
- `publish()` - Publier publiquement
- `destroy()` - Suppression

### WaterParameterController
Consultation des paramètres :
- `index()` - Liste des paramètres d'un échantillon
- `show()` - Détails d'un paramètre

## Services

### WaterSampleService
- `store(array $data, int $userId)` : Création d'échantillon avec traitement automatique
  - Crée l'échantillon
  - Analyse les paramètres vs seuils
  - Génère les alertes si dépassement
  - Calcule le résultat global
  
- `update(WaterSample $sample, array $data)` : Mise à jour
  - Met à jour l'échantillon
  - Supprime anciens paramètres/alertes
  - Re-traite les nouveaux paramètres

### ThresholdService
- `store(array $data)` : Création de seuil
- `update(Threshold $threshold, array $data)` : Mise à jour de seuil

### QualityAlertService
- `update(QualityAlert $alert, array $data)` : Mise à jour d'alerte
- `resolve(QualityAlert $alert)` : Résolution d'alerte
- `publish(QualityAlert $alert)` : Publication d'alerte

## Requests

### WaterSampleRequest
Validation pour échantillons :
```php
[
    'zone_id' => ['required', 'exists:zones,id'],
    'infrastructure_id' => ['nullable', 'exists:infrastructures,id'],
    'date_prelevement' => ['required', 'date', 'before_or_equal:now'],
    'parameters' => ['required', 'array', 'min:1'],
    'parameters.*.threshold_id' => ['required', 'distinct', 'exists:thresholds,id'],
    'parameters.*.valeur' => ['required', 'numeric'],
]
```

### ThresholdRequest
Validation pour seuils :
```php
[
    'parametre' => ['required', Rule::enum(QualityParameter::class)],
    'unite' => ['required', 'string', 'max:20'],
    'valeur_min' => ['nullable', 'numeric', 'min:0'],
    'valeur_max' => ['nullable', 'numeric', 'min:0', 'gt:valeur_min'],
    'niveau_alerte' => ['required', Rule::enum(AlertLevel::class)],
]
```

### QualityAlertRequest
Validation pour alertes :
```php
[
    'message' => ['sometimes', 'string', 'max:1000'],
    'publiee' => ['sometimes', 'boolean'],
]
```

## Routes suggérées

Voir le fichier `routes/quality_routes_suggestion.php` pour l'implémentation complète.

Préfixes suggérés :
- `/admin/quality/samples` - Échantillons
- `/admin/quality/thresholds` - Seuils
- `/admin/quality/alerts` - Alertes
- `/admin/quality/parameters` - Paramètres

## Migrations

Ordre de création :
1. `thresholds` - Seuils de référence
2. `water_samples` - Échantillons
3. `water_parameters` - Paramètres analysés
4. `quality_alerts` - Alertes générées

## Seeding

```bash
php artisan db:seed --class=Database\\Seeders\\Quality\\ThresholdSeeder
php artisan db:seed --class=Database\\Seeders\\Quality\\QualitySeeder
```

Le `ThresholdSeeder` crée 10 seuils standards pour l'eau potable.
Le `QualitySeeder` crée 20 échantillons avec paramètres et alertes.

## Factories

Disponibles pour tous les modèles avec des états :

**WaterSampleFactory** :
- `conforme()` - Échantillon conforme
- `nonConforme()` - Échantillon non conforme
- `recent()` - Prélèvement récent (7 jours)

**WaterParameterFactory** :
- `withinThreshold()` - Valeur dans les seuils
- `exceeded()` - Valeur hors seuils

**QualityAlertFactory** :
- `active()` - Alerte non résolue
- `resolved()` - Alerte résolue
- `published()` - Alerte publiée
- `critical()` - Alerte critique

**ThresholdFactory** :
- `ph()` - Seuil pH standard
- `chlore()` - Seuil chlore standard
- `turbidite()` - Seuil turbidité standard

## Workflow typique

1. **Configuration initiale** : Créer les seuils via ThresholdController
2. **Prélèvement** : Créer un échantillon via WaterSampleController
3. **Analyse** : Le service calcule automatiquement :
   - Si chaque paramètre dépasse son seuil
   - Le résultat global (conforme/non conforme)
   - Les alertes à générer
4. **Suivi** : Consulter les alertes actives via QualityAlertController
5. **Résolution** : Marquer les alertes comme résolues une fois traitées

## Permissions suggérées

- `quality.view` - Voir les données qualité
- `quality.samples.create` - Créer des échantillons
- `quality.samples.edit` - Modifier des échantillons
- `quality.samples.delete` - Supprimer des échantillons
- `quality.thresholds.manage` - Gérer les seuils
- `quality.alerts.publish` - Publier les alertes
- `quality.alerts.resolve` - Résoudre les alertes
