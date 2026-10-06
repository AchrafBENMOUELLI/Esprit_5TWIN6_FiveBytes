# Plan d'implémentation : Historique automatique des changements de statut d'incident

## Contexte
Projet Laravel 12 avec modèles Incident et IncidentStatusHistory existants. Objectif : enregistrer automatiquement chaque changement de statut via un Observer et afficher l'historique dans une timeline verticale avec badges colorés.

---

## Plan d'implémentation

- [ ] 1. Créer l'Observer IncidentObserver dans app/Observers/IncidentObserver.php
      Implémenter les méthodes created() et updated() pour enregistrer automatiquement l'historique des statuts.
      - created() : crée une entrée IncidentStatusHistory avec ancien_statut=null, nouveau_statut=statut de l'incident, modifie_par=citoyen_id de l'incident, date_changement=now()
      - updated() : si isDirty('statut'), crée une entrée avec ancien_statut=getOriginal('statut'), nouveau_statut=statut actuel, modifie_par=auth()->id() ?? citoyen_id (fallback pour le seeder), date_changement=now()
      - Gérer date_resolution automatiquement : si nouveau statut = Resolu et date_resolution=null, mettre date_resolution=now() via saveQuietly() pour éviter la boucle. Si nouveau statut ≠ Resolu et date_resolution ≠ null, remettre date_resolution=null via saveQuietly()
      Fichiers : app/Observers/IncidentObserver.php
      Vérification : `php artisan tinker` puis tester la création d'un incident et le changement de statut, confirmer qu'une ligne est créée dans incident_status_history avec `\App\Models\Incident\IncidentStatusHistory::latest()->first()`

- [ ] 2. Enregistrer l'Observer dans AppServiceProvider
      Dans la méthode boot(), ajouter Incident::observe(IncidentObserver::class)
      Fichiers : app/Providers/AppServiceProvider.php
      Vérification : `php artisan tinker` puis `\App\Models\Incident\Incident::getObservableEvents()` doit confirmer que les events sont observés (créer un incident de test et vérifier l'historique)

- [ ] 3. Retirer la gestion de date_resolution du Admin\IncidentController::update()
      Supprimer les lignes qui gèrent date_resolution dans la méthode update() (lignes 94-102 actuelles), car cette logique est maintenant dans l'Observer.
      Le controller ne doit plus toucher date_resolution ; seul l'Observer le fait.
      Fichiers : app/Http/Controllers/Admin/IncidentController.php
      Vérification : `php artisan test` ou vérifier manuellement que la modification d'un statut via le controller admin déclenche bien l'Observer et met à jour date_resolution

- [ ] 4. Créer le composant Blade incident-history.blade.php
      Composant timeline verticale dans resources/views/shared/incident-history.blade.php acceptant les props : $history (collection IncidentStatusHistory avec modificateur chargé) et $showModificateur (bool, défaut true).
      Afficher chaque entrée : ancien statut (badge coloré avec $entry->ancien_statut?->color() et ->label() ou "Création" si null) → flèche → nouveau statut (badge coloré), nom de l'utilisateur si $showModificateur && $entry->modificateur existe, date formatée d/m/Y à H:i.
      Style : timeline verticale responsive avec ligne de connexion, icône pour chaque étape, badges Tailwind avec classes de l'enum IncidentStatut, inspiration du composant incident-comments.blade.php pour la structure et le style.
      Fichiers : resources/views/shared/incident-history.blade.php
      Vérification : Ouvrir la vue admin show d'un incident et confirmer que l'historique s'affiche correctement avec le style timeline

- [ ] 5. Intégrer le composant dans la vue admin show
      Dans resources/views/incident/admin/show.blade.php, ajouter une section "Historique des changements de statut" après la section "Informations principales" (après la ligne ~90, avant les commentaires).
      Charger statusHistory.modificateur avec $incident->load('statusHistory.modificateur') dans le controller Admin\IncidentController::show() (ligne ~148), puis passer $incident->statusHistory et $showModificateur=true au composant.
      Fichiers : app/Http/Controllers/Admin/IncidentController.php, resources/views/incident/admin/show.blade.php
      Vérification : Ouvrir http://localhost:8000/admin/incidents/{id} et confirmer que l'historique complet avec nom du technicien s'affiche

- [ ] 6. Intégrer le composant dans la vue front show
      Dans resources/views/front/incident/show.blade.php, ajouter une section "Historique de votre signalement" après la section "État de votre signalement" (après la ligne ~90, avant les commentaires).
      Charger statusHistory.modificateur avec $incident->load('statusHistory.modificateur') dans le controller Front\IncidentController::show() (ligne ~119), puis passer $incident->statusHistory et $showModificateur=false au composant.
      Fichiers : app/Http/Controllers/Front/IncidentController.php, resources/views/front/incident/show.blade.php
      Vérification : Ouvrir http://localhost:8000/front/incidents/{id} et confirmer que l'historique simplifié (sans nom du technicien) s'affiche

- [ ] 7. Compléter IncidentSeeder pour générer un historique cohérent
      Pour chaque incident créé dans le seeder, insérer manuellement les entrées IncidentStatusHistory correspondant aux transitions de statut.
      Stratégie : créer les incidents avec Incident::withoutEvents(function() { ... }) pour éviter de déclencher l'observer lors du seed, puis insérer manuellement les entrées d'historique avec IncidentStatusHistory::insert() pour chaque transition logique (ex: Nouveau→Assigne→EnCours pour un incident EnCours, Nouveau→Assigne→EnCours→Resolu pour un Resolu, etc.).
      Pour les incidents avec technicien_id, utiliser technicien_id comme modifie_par pour les transitions Assigne→EnCours→Resolu. Pour l'entrée initiale (création), utiliser citoyen_id.
      Les dates des transitions doivent être cohérentes : created_at pour la première entrée, puis espacées de quelques heures/jours selon le statut final.
      Fichiers : database/seeders/IncidentSeeder.php
      Vérification : `php artisan migrate:fresh --seed` puis ouvrir un incident de test dans tinker et vérifier avec `Incident::find(1)->statusHistory` que l'historique est cohérent et complet

- [ ] 8. Tester dans tinker le changement de statut et la création d'historique
      Lancer `php artisan tinker`, créer ou modifier un incident, changer son statut, et confirmer qu'une ligne est créée dans incident_status_history avec les bonnes valeurs.
      Tester aussi que date_resolution est automatiquement remplie quand le statut passe à Resolu, et remise à null quand le statut revient en arrière.
      Commandes : 
      ```
      $incident = \App\Models\Incident\Incident::first();
      $incident->statut = \App\Enums\IncidentStatut::Resolu;
      $incident->save();
      \App\Models\Incident\IncidentStatusHistory::where('incident_id', $incident->id)->get();
      $incident->refresh(); // Vérifier date_resolution
      ```
      Fichiers : Aucun (test manuel)
      Vérification : Confirmer dans tinker que l'historique est créé et date_resolution est correctement gérée

---

## Contraintes et considérations

### Eager loading N+1
- Toujours utiliser `->with('statusHistory.modificateur')` dans les controllers pour éviter les requêtes N+1
- L'Observer doit être silencieux lors des mises à jour de date_resolution (utiliser saveQuietly())

### Gestion date_resolution
- L'Observer est la source unique de vérité pour date_resolution
- Si statut = Resolu et date_resolution = null : mettre date_resolution = now()
- Si statut ≠ Resolu et date_resolution ≠ null : remettre date_resolution = null
- Utiliser saveQuietly() ou withoutEvents() pour éviter les boucles infinies

### Historique obligatoire
- AUCUN changement de statut ne peut se faire sans écriture de l'historique
- L'Observer garantit cette contrainte en étant déclenché automatiquement

### Seeder et Observer
- Utiliser Incident::withoutEvents() dans le seeder pour créer les incidents sans déclencher l'observer
- Insérer manuellement les entrées d'historique avec des dates et modifie_par cohérents

### Badges colorés
- Utiliser les méthodes $statut->color() et $statut->label() de l'enum IncidentStatut
- Classes Tailwind déjà définies : bg-{color}-100 text-{color}-800 border-{color}-200

### Timeline responsive
- Composant doit être responsive (desktop et mobile)
- Inspiration du style du composant incident-comments.blade.php
- Ligne verticale de connexion entre les étapes
- Icônes et badges pour chaque transition

### Lecture seule
- Pas de routes ni de controller pour l'historique : lecture seule uniquement
- Affiché dans les vues show admin et front uniquement

---

## Commandes de vérification

### Build
`php artisan config:clear && php artisan cache:clear && php artisan route:clear`

### Tests
- `php artisan tinker` : tester manuellement la création et modification d'incidents
- `php artisan migrate:fresh --seed` : vérifier que le seeder génère l'historique cohérent
- Ouvrir les pages show admin et front dans le navigateur

### Vérification spécifique
```php
// Dans tinker
$incident = \App\Models\Incident\Incident::first();
$incident->statut = \App\Enums\IncidentStatut::EnCours;
$incident->save();
\App\Models\Incident\IncidentStatusHistory::where('incident_id', $incident->id)->get();

// Vérifier date_resolution
$incident->statut = \App\Enums\IncidentStatut::Resolu;
$incident->save();
$incident->refresh();
$incident->date_resolution; // doit être remplie

$incident->statut = \App\Enums\IncidentStatut::EnCours;
$incident->save();
$incident->refresh();
$incident->date_resolution; // doit être null
```
