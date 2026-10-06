# 🌊 Gestion 4 - Test Complet

## ⚡ Démarrage Rapide

### 1️⃣ Lancez le serveur Laravel
```bash
php artisan serve
```
Accédez à : **http://localhost:8000**

---

### 2️⃣ Créez un compte test
1. Allez à : http://localhost:8000/register
2. Remplissez le formulaire :
   - **Nom** : Test User
   - **Email** : test@example.com
   - **Mot de passe** : password

---

### 3️⃣ Connectez-vous et accédez à Gestion 4
1. Allez à : http://localhost:8000/login
2. Connectez-vous avec vos identifiants
3. Cliquez sur **🌊 Gestion 4** dans la navbar

---

## 🎯 Tests à Effectuer

### ✅ TEST 1 : Interface Accessible
- [ ] La page d'accueil Gestion 4 s'affiche
- [ ] Les boutons sont visibles
- [ ] Le rôle utilisateur s'affiche (Citoyen)

### ✅ TEST 2 : CRUD Restrictions (Gestionnaire)

**Avant de tester, changez votre rôle à gestionnaire :**
```sql
UPDATE users SET role = 'gestionnaire' WHERE email = 'test@example.com';
```

Puis reconnectez-vous.

#### Créer une Restriction
1. Cliquez sur **📋 Gérer les Restrictions**
2. Cliquez sur **+ Créer**
3. Remplissez le formulaire :
   - **Titre** : Restriction d'été 2026
   - **Zone** : Sélectionnez une zone
   - **Niveau** : Alerte (🟠)
   - **Description** : Test restriction
   - **Début** : Aujourd'hui à 10:00
   - **Fin** : Demain à 18:00
4. Cliquez **✅ Créer**
5. **✓ Vérifiez** : La restriction apparaît dans la liste

#### Éditer la Restriction
1. Dans la liste, cliquez sur **✏️ Éditer**
2. Modifiez le titre : "Restriction TEST MODIFIÉ"
3. Cliquez **💾 Mettre à jour**
4. **✓ Vérifiez** : Le titre est modifié

#### Supprimer la Restriction
1. Dans la liste, cliquez sur **🗑️ Supprimer**
2. Confirmez la suppression
3. **✓ Vérifiez** : La restriction disparaît

---

### ✅ TEST 3 : Validation des Champs

1. Allez à **📋 Gérer les Restrictions** → **+ Créer**
2. Laissez les champs vides et soumettez
3. **✓ Vérifiez** : Les messages d'erreur s'affichent
4. Remplissez le titre, puis laissez les autres vides
5. **✓ Vérifiez** : Les erreurs s'affichent pour les champs manquants
6. Modifiez le formulaire avec des valeurs valides
7. **✓ Vérifiez** : Aucune erreur, la restriction est créée

---

### ✅ TEST 4 : Affichage old() (Conservation des saisies)

1. Allez à **+ Créer une Restriction**
2. Remplissez certains champs (titre, description)
3. Laissez la zone vide et soumettez
4. **✓ Vérifiez** : Les champs remplis restent remplis (old())
5. Les messages d'erreur s'affichent

---

### ✅ TEST 5 : Relations Eloquent

1. Créez 2-3 restrictions dans des zones différentes
2. Allez à **📋 Gérer les Restrictions**
3. **✓ Vérifiez** : Chaque restriction affiche sa zone correctement
4. Les noms de zones s'affichent (relation Zone → Restriction)

---

### ✅ TEST 6 : Niveaux d'Eau (Bonus)

1. Cliquez sur **💧 Niveaux d'Eau**
2. Cliquez sur **+ Enregistrer un niveau**
3. Remplissez :
   - **Zone** : Sélectionnez une zone
   - **Source** : Réservoir
   - **Niveau** : 75 (%)
   - **Volume** : 250000 (m³)
   - **Date** : Aujourd'hui
4. Cliquez **✅ Enregistrer**
5. **✓ Vérifiez** : Le niveau s'affiche dans la liste

---

### ✅ TEST 7 : Pagination

1. Créez 15+ restrictions
2. Allez à **📋 Gérer les Restrictions**
3. **✓ Vérifiez** : La pagination s'affiche (Page 1, 2, etc.)
4. Naviguez entre les pages

---

### ✅ TEST 8 : Interface Citoyen

1. Changez votre rôle à citoyen :
```sql
UPDATE users SET role = 'citoyen' WHERE email = 'test@example.com';
```

2. Reconnectez-vous
3. Allez à **🌊 Gestion 4**
4. **✓ Vérifiez** : Vous voyez **👥 Interface Citoyen** au lieu de **📊 Interface Gestionnaire**
5. Testez les boutons :
   - **📊 Tableau de Bord** : Affiche les zones avec alertes
   - **📅 Calendrier** : Affiche les coupures
   - **🔔 Mes Alertes** : Gestion des abonnements

---

## 🔧 Commandes Utiles

```bash
# Voir les données en BDD
php artisan tinker
>>> App\Models\Drought\Restriction::count()
>>> App\Models\Drought\Restriction::all()

# Refaire les migrations et seeders
php artisan migrate:refresh --seed --class=DroughtSeeder

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Vérifier les commits
git log --oneline -20
```

---

## 📋 Checklist Finale

- [ ] Serveur démarre sans erreur
- [ ] Connexion fonctionne
- [ ] Gestion 4 est accessible via navbar
- [ ] Interface Gestionnaire affiche 4 boutons
- [ ] CRUD Restrictions complet (C-R-U-D)
- [ ] Validation des champs fonctionnelle
- [ ] old() conserve les anciennes valeurs
- [ ] Relations Eloquent affichent les zones
- [ ] Pagination fonctionne
- [ ] Interface Citoyen s'affiche correctement
- [ ] 16 commits visibles dans git

---

## ✨ Notes

- **Gestionnaire** : Peut gérer les restrictions, niveaux d'eau, consommation et coupures
- **Citoyen** : Peut consulter les alertes et s'abonner aux notifications
- **Validation** : Tous les champs obligatoires sont validés
- **Design** : Cohérent avec le reste de l'application (couleurs, badges, etc.)

Bon test ! 🚀
