# Carte Visuelle des Routes - Module 5

## 🗺️ Architecture des Routes

```
┌──────────────────────────────────────────────────────────────────┐
│                    MODULE 5 - ROUTES                              │
│          Projets de Rénovation et Financement                     │
└──────────────────────────────────────────────────────────────────┘
                              │
                ┌─────────────┴──────────────┐
                │                            │
        ┌───────▼──────┐            ┌───────▼──────┐
        │ FRONT OFFICE │            │ BACK OFFICE  │
        │  (Citoyens)  │            │   (Admin)    │
        └──────┬───────┘            └──────┬───────┘
               │                           │
        ┌──────┴──────┐            ┌───────┴────────┐
        │   PUBLIC    │            │  AUTHENTICATED │
        │  (no auth)  │            │  (auth + role) │
        └──────┬──────┘            └───────┬────────┘
               │                           │
     ┌─────────┴─────────┐         ┌──────┴──────────────┐
     │                   │         │                     │
  ┌──▼──┐          ┌────▼────┐  ┌─▼──────┐    ┌────────▼────────┐
  │Index│          │  Show   │  │Projects│    │   Contractors   │
  └─────┘          └─────────┘  └────┬───┘    └─────────────────┘
                                      │
                   ┌──────────────────┼──────────────────┐
                   │                  │                  │
              ┌────▼─────┐      ┌────▼────┐      ┌─────▼──────┐
              │  Phases  │      │Fundings │      │ Documents  │
              └──────────┘      └─────────┘      └────────────┘
```

---

## 🌐 Front Office - Arborescence

```
/projets
├── GET    /                                → Liste projets (PUBLIC)
├── GET    /{id}                            → Détails projet (PUBLIC)
│
├── AUTH REQUIRED ─────────────────────────
│
├── GET    /{id}/faire-un-don               → Formulaire don
├── GET    /{id}/confirmer-don              → Confirmation don
└── POST   /don                             → Enregistrer don

/mes-dons (AUTH REQUIRED)
├── GET    /                                → Liste mes dons
├── GET    /{id}                            → Détails d'un don
└── DELETE /{id}/cancel                     → Annuler don

/statistiques (PUBLIC)
├── GET    /projets                         → Stats projets
└── GET    /dons                            → Stats dons
```

---

## 🔐 Back Office - Arborescence

### Projects

```
/admin/projects
├── GET    /                                → Liste projets
├── GET    /create                          → Formulaire création
├── POST   /                                → Enregistrer
├── GET    /{id}                            → Détails
├── GET    /{id}/edit                       → Formulaire édition
├── PUT    /{id}                            → Mettre à jour
├── DELETE /{id}                            → Supprimer
│
├── ACTIONS SPÉCIALES ──────────────────────
│
├── PATCH  /{id}/archive                    → Archiver
├── PATCH  /{id}/restore                    → Restaurer
├── PATCH  /{id}/status                     → Changer statut
├── POST   /{id}/duplicate                  → Dupliquer
└── GET    /{id}/export                     → Exporter PDF/Excel
```

### Contractors

```
/admin/contractors
├── GET    /                                → Liste entrepreneurs
├── GET    /create                          → Formulaire création
├── POST   /                                → Enregistrer
├── GET    /{id}                            → Détails
├── GET    /{id}/edit                       → Formulaire édition
├── PUT    /{id}                            → Mettre à jour
└── DELETE /{id}                            → Supprimer
```

### Phases (Nested)

```
/admin/projects/{projectId}/phases
├── GET    /                                → Liste phases du projet
├── GET    /create                          → Formulaire création
└── POST   /                                → Enregistrer phase

/admin/phases
├── GET    /{id}                            → Détails phase
├── GET    /{id}/edit                       → Formulaire édition
├── PUT    /{id}                            → Mettre à jour
└── DELETE /{id}                            → Supprimer
```

### Fundings (Nested)

```
/admin/projects/{projectId}/fundings
├── GET    /                                → Liste financements du projet
├── GET    /create                          → Formulaire création
└── POST   /                                → Enregistrer financement

/admin/fundings
├── GET    /{id}                            → Détails financement
├── GET    /{id}/edit                       → Formulaire édition
├── PUT    /{id}                            → Mettre à jour
├── DELETE /{id}                            → Supprimer
│
├── APPROBATION DONS ───────────────────────
│
├── PATCH  /{id}/approve                    → Approuver don
└── PATCH  /{id}/reject                     → Rejeter don
```

### Documents (Nested)

```
/admin/projects/{projectId}/documents
├── GET    /                                → Liste documents du projet
├── GET    /create                          → Formulaire upload
└── POST   /                                → Upload document

/admin/documents
├── GET    /{id}                            → Détails document
├── GET    /{id}/edit                       → Formulaire édition
├── PUT    /{id}                            → Mettre à jour métadonnées
├── DELETE /{id}                            → Supprimer
│
├── ACTIONS FICHIERS ───────────────────────
│
├── GET    /{id}/download                   → Télécharger
└── GET    /{id}/preview                    → Prévisualiser
```

---

## 📊 Flux de Navigation

### Citoyen - Parcours de Don

```
┌─────────────┐
│   Accueil   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│Liste Projets│ ◄───── Filtres (zone, type, statut)
└──────┬──────┘
       │ clic
       ▼
┌─────────────┐
│Détails      │ ◄───── Transparence budgétaire
│Projet       │        Phases, Financements, Docs
└──────┬──────┘
       │ clic "Faire un don"
       ▼
┌─────────────┐
│  Login ?    │───Non──► Redirection login
└──────┬──────┘
       │ Oui
       ▼
┌─────────────┐
│Formulaire   │ ◄───── Budget prévu/obtenu/restant
│de Don       │        Montant (1€ - 1M€)
└──────┬──────┘
       │ submit
       ▼
┌─────────────┐
│Confirmation │ (optionnel)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│Enregistré   │ ◄───── Statut: "en_attente"
│Don créé     │        Message succès
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Mes Dons    │ ◄───── Historique personnel
│             │        Statut de chaque don
└─────────────┘
```

### Admin - Gestion Projet

```
┌─────────────┐
│  Dashboard  │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│Liste Projets│ ◄───── Recherche, Filtres
└──────┬──────┘
       │
       ├─ Créer ──► Formulaire ──► Enregistrer
       │
       ├─ Modifier ──► Formulaire ──► Mettre à jour
       │
       ├─ Voir ──┐
       │         │
       │         ▼
       │    ┌─────────────┐
       │    │Détails      │
       │    │Projet       │
       │    └──────┬──────┘
       │           │
       │    ┌──────┴──────────────┬──────────────┐
       │    │                     │              │
       │    ▼                     ▼              ▼
       │ ┌──────┐          ┌──────────┐   ┌──────────┐
       │ │Phases│          │Fundings  │   │Documents │
       │ └──┬───┘          └────┬─────┘   └────┬─────┘
       │    │                   │              │
       │    ├─ Ajouter         ├─ Ajouter     ├─ Upload
       │    ├─ Modifier         ├─ Approuver   ├─ Télécharger
       │    └─ Supprimer        └─ Rejeter     └─ Supprimer
       │
       └─ Supprimer ──► Vérif dépendances ──► Confirmer
```

---

## 🎨 Hiérarchie Visuelle

### Relations Parent-Enfant

```
┌───────────────────────────────────────────────────────┐
│                    PROJECT (Parent)                    │
│                                                        │
│  ID: 1                                                 │
│  Titre: "Rénovation réseau Tunis"                     │
│  Budget: 500,000 €                                     │
└─────────┬─────────────┬─────────────┬────────────────┘
          │             │             │
    ┌─────▼─────┐ ┌────▼─────┐ ┌────▼─────┐
    │  PHASES   │ │ FUNDINGS │ │DOCUMENTS │
    │ (Enfants) │ │(Enfants) │ │(Enfants) │
    └───────────┘ └──────────┘ └──────────┘
         │             │             │
    ┌────┴────┐   ┌────┴────┐  ┌────┴────┐
    │Phase 1  │   │Subvent. │  │ Cahier  │
    │Phase 2  │   │Don 1    │  │ Plans   │
    │Phase 3  │   │Don 2    │  │ Photos  │
    └─────────┘   └─────────┘  └─────────┘
```

### URLs Imbriquées

```
/admin/projects/1                    ← Projet parent
              │
              ├─ /phases             ← Enfants: phases
              │    ├─ /              (liste)
              │    ├─ /create        (créer)
              │    └─ /5/edit        (modifier phase #5)
              │
              ├─ /fundings           ← Enfants: financements
              │    ├─ /              (liste)
              │    ├─ /create        (créer)
              │    └─ /12/approve    (approuver #12)
              │
              └─ /documents          ← Enfants: documents
                   ├─ /              (liste)
                   ├─ /create        (upload)
                   └─ /8/download    (télécharger #8)
```

---

## 🔄 Flux de Données

### Création Projet Complet

```
1. Créer PROJET
   POST /admin/projects
   ↓
   Projet #1 créé
   
2. Ajouter PHASES
   POST /admin/projects/1/phases  (Phase 1)
   POST /admin/projects/1/phases  (Phase 2)
   POST /admin/projects/1/phases  (Phase 3)
   ↓
   3 phases créées
   
3. Ajouter FINANCEMENTS
   POST /admin/projects/1/fundings  (Subvention)
   POST /admin/projects/1/fundings  (Don)
   ↓
   2 financements créés
   
4. Upload DOCUMENTS
   POST /admin/projects/1/documents  (Cahier charges)
   POST /admin/projects/1/documents  (Plans)
   ↓
   2 documents uploadés
   
5. Projet COMPLET
   GET /admin/projects/1
   ↓
   Affichage avec toutes les relations
```

### Don Citoyen - Workflow Complet

```
1. CITOYEN consulte projet
   GET /projets/1
   ↓
   Voit budget, phases, financements approuvés
   
2. CITOYEN clique "Faire un don"
   GET /projets/1/faire-un-don
   ↓
   Formulaire avec montant suggéré
   
3. CITOYEN soumet don
   POST /projets/don
   {project_id: 1, montant: 500, description: "..."}
   ↓
   Don créé avec statut "en_attente"
   
4. CITOYEN vérifie
   GET /mes-dons
   ↓
   Voit don avec statut "en_attente"
   
5. ADMIN examine don
   GET /admin/fundings/15
   ↓
   Voit détails du don citoyen
   
6a. ADMIN approuve
    PATCH /admin/fundings/15/approve
    ↓
    Statut → "approuve"
    Don visible sur page publique du projet
    
6b. ADMIN rejette
    PATCH /admin/fundings/15/reject
    ↓
    Statut → "rejete"
    Citoyen voit rejet dans "Mes dons"
```

---

## 📍 Points d'Entrée Principaux

### Pour Visiteurs Non Connectés

```
1. Page d'accueil: /
2. Liste projets: /projets
3. Détails projet: /projets/{id}
```

### Pour Citoyens Authentifiés

```
1. Tous les points visiteurs +
2. Faire un don: /projets/{id}/faire-un-don
3. Mes dons: /mes-dons
```

### Pour Gestionnaires/Admins

```
1. Dashboard: /dashboard
2. Gestion projets: /admin/projects
3. Gestion entrepreneurs: /admin/contractors
4. Phases d'un projet: /admin/projects/{id}/phases
5. Financements d'un projet: /admin/projects/{id}/fundings
6. Documents d'un projet: /admin/projects/{id}/documents
```

---

## 🎯 Conventions RESTful Respectées

### Méthodes HTTP

| Action | Méthode | Route | Nom |
|--------|---------|-------|-----|
| Afficher liste | GET | `/admin/projects` | `index` |
| Afficher formulaire création | GET | `/admin/projects/create` | `create` |
| Enregistrer | POST | `/admin/projects` | `store` |
| Afficher détails | GET | `/admin/projects/{id}` | `show` |
| Afficher formulaire édition | GET | `/admin/projects/{id}/edit` | `edit` |
| Mettre à jour | PUT/PATCH | `/admin/projects/{id}` | `update` |
| Supprimer | DELETE | `/admin/projects/{id}` | `destroy` |

### Verbes HTTP Sémantiques

- **GET**: Récupérer des données (safe, idempotent)
- **POST**: Créer une nouvelle ressource
- **PUT**: Remplacer complètement une ressource
- **PATCH**: Modifier partiellement une ressource
- **DELETE**: Supprimer une ressource

---

## ✅ Checklist de Vérification

### Routes Configurées
- [x] Projects CRUD (7 routes)
- [x] Projects actions spéciales (5 routes)
- [x] Contractors CRUD (7 routes)
- [x] Phases imbriquées (7 routes)
- [x] Fundings imbriquées (9 routes)
- [x] Documents imbriquées (9 routes)
- [x] Front projets publics (2 routes)
- [x] Front dons (5 routes)
- [x] Front statistiques (2 routes optionnelles)

### Conventions
- [x] Nommage cohérent (`admin.resource.action`)
- [x] Préfixes clairs (`/admin/`, `/projets/`)
- [x] RESTful (GET, POST, PUT, DELETE)
- [x] Routes imbriquées pour relations parent-enfant
- [x] Middleware appropriés (auth, role)

---

**Total Routes Configurées**: 53+ routes ✅

**Documentation Complète**: Tous les endpoints documentés avec exemples ✅
