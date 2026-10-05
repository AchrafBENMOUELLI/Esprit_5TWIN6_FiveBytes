# Référence Rapide - Module 5

## 🎯 Contrôleurs

### Admin (5)
1. `ProjectController` - CRUD projets
2. `ContractorController` - CRUD entrepreneurs
3. `ProjectPhaseController` - Gestion phases
4. `FundingController` - Gestion financements
5. `ProjectDocumentController` - Upload/gestion documents

### Front (2)
1. `ProjectController` - Liste et détails projets publics
2. `FundingController` - Dons citoyens

---

## 🛣️ Routes Principales

### Front (5 routes)
```
GET   /projets                     Liste projets
GET   /projets/{id}                Détails projet
GET   /projets/{id}/faire-un-don   Formulaire don (auth)
POST  /projets/don                 Enregistrer don (auth)
GET   /mes-dons                    Mes dons (auth)
```

### Admin (33 routes)
```
/admin/projects                    CRUD projets (7 routes)
/admin/contractors                 CRUD entrepreneurs (7 routes)
/admin/projects/{id}/phases        Gestion phases (6 routes)
/admin/projects/{id}/fundings      Gestion financements (6 routes)
/admin/projects/{id}/documents     Gestion documents (7 routes)
```

---

## 📊 Colonnes Importantes

### Projects
- `budget_prevu` (NOT budget_estime)
- `type` (NOT type_projet)
- `statut` (planifié, en_cours, terminé, suspendu, annulé)

### ProjectPhases
- `cout` (NOT budget_alloue)
- `avancement` (0-100)
- NO `statut` column
- NO `description` column

### Fundings
- `source` (don, subvention_publique, emprunt, fonds_propres)
- `statut` (en_attente, approuve, rejete)
- `donateur_id` (nullable, required if source='don')

---

## 🔗 Relations

```php
$project->zone
$project->infrastructure
$project->responsable
$project->projectPhases        // NOT phases
$project->fundings
$project->projectDocuments     // NOT documents

$phase->project
$phase->contractor

$funding->project
$funding->donateur

$document->project

$contractor->projectPhases
```

---

## 💰 Calculs Budgétaires

```php
$project->budgetTotal()        // Somme coûts phases
$project->fundingTotal()       // Somme financements approuvés
$project->budgetRemaining()    // fundingTotal - budgetTotal
```

---

## ✅ Checklist Rapide

**Fait:**
- [x] 7 contrôleurs créés
- [x] 38 routes enregistrées
- [x] Migrations (5 tables)
- [x] Models avec relations
- [x] Factories
- [x] Seeders
- [x] Form Requests (6)
- [x] Vues front (index, show)
- [x] Documentation

**À faire:**
- [ ] Vues admin (index, create, edit, show)
- [ ] Vues front (donate, my-donations)
- [ ] Middleware CheckRole
- [ ] Tests
- [ ] Git commits

---

## 🔒 Sécurité

**Front:**
- Projets annulés masqués
- Financements non approuvés masqués
- Dons en statut "en_attente" par défaut

**Admin:**
- Middleware `auth` sur toutes les routes
- TODO: ajouter middleware `role:gestionnaire,admin`

---

## 📝 Commandes Utiles

```bash
# Routes
php artisan route:list --path=admin
php artisan route:list --path=projets

# Caches
php artisan route:clear
php artisan view:clear

# Storage
php artisan storage:link

# Database
php artisan migrate:fresh --seed
```

---

## 📄 Documentation

1. `DATABASE_SCHEMA_REFERENCE.md` - Colonnes et relations
2. `ADMIN_CONTROLLERS_DOCUMENTATION.md` - Détails admin
3. `FRONT_CONTROLLERS_DOCUMENTATION.md` - Détails front
4. `CONTROLLERS_COMPLETE_SUMMARY.md` - Vue complète
5. `QUICK_REFERENCE.md` - Ce fichier
