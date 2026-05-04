# KanbanEsitec Typing Header Placeholder (use service like readme-typing-svg)

<p align=\"center\">
  <img src=\"https://readme-typing-svg.herokuapp.com/?lines=KanbanEsitec+%F0%9F%93%8B;Gestion+de+Projets+Collaboratifs;Laravel+Kanban+Board&font=Fira%20Code&pause=1000&center=true&width=600&height=100\" alt=\"Typing SVG\" />
</p>

<p align=\"center\">
  <img src=\"https://img.shields.io/badge/Laravel-11-DD0031?style=for-the-badge&logo=laravel&logoColor=white\" alt=\"Laravel 11\" />
  <img src=\"https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white\" alt=\"Tailwind CSS\" />
  <img src=\"https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white\" alt=\"MySQL\" />
  <img src=\"https://img.shields.io/badge/Laravel_Breeze-10B981?style=for-the-badge&logo=laravel&logoColor=white\" alt=\"Laravel Breeze\" />
  <img src=\"https://img.shields.io/badge/Blade-DD0031?style=for-the-badge&logoColor=white\" alt=\"Blade\" />
</p>

# 📋 **KanbanEsitec** — Gestion de Projets Collaboratifs

**Projet réalisé dans le cadre du cours _Projets Laravel - L2 Génie Informatique_**  
**ESITEC — Année académique 2025-2026**

---

## 📝 **Description**

Application web de gestion de projets de type **KanbanEsitec** développée avec **Laravel**.  
Elle permet à des membres de collaborer sur des projets, d'assigner des tâches et de suivre leur avancement à travers différents statuts.

---

## ✅ **Fonctionnalités implémentées**

### 🔐 **Authentification & Rôles**

- ✅ Inscription et connexion (Laravel Breeze)
- ✅ Distinction **Admin / Membre**
- ✅ Middleware de protection des routes

### 📁 **Gestion des Projets**

- ✅ Créer, modifier, supprimer un projet
- ✅ Associer des membres à un projet (**many-to-many**)
- ✅ Lister les projets avec pagination

### ✅ **Gestion des Tâches**

- ✅ Créer, modifier, supprimer une tâche
- ✅ Assigner une tâche à un membre
- ✅ Statuts : **À faire** / **En cours** / **Terminé**
- ✅ Filtrage par statut (**scopes Laravel**)
- ✅ Soft delete des tâches archivées

### 💬 **Commentaires**

- ✅ Ajouter des commentaires sur une tâche
- ✅ Afficher les commentaires par tâche

### ⚙️ **Administration**

- ✅ Panel admin pour gérer les projets, tâches et membres
- ✅ CRUD complet sur toutes les entités principales

---

## 🛠️ **Technologies utilisées**

<div align=\"center\">
<img src=\"https://skillicons.dev/icons?i=laravel,tailwind,mysql,php&perline=5\">
</div>

---

## 👥 **Membres du groupe**

| Nom complet                | Rôle dans le projet                               |
| -------------------------- | ------------------------------------------------- |
| **Ibrahima Saidou Diallo** | Chef de projet — Contrôleurs &amp; Logique métier |
| **Abdoulaye Diallo**       | Modèles, Migrations &amp; Seeders                 |
| **Ange Okouaka**           | Vues Blade &amp; Interface utilisateur            |

---

## 🚀 **Installation**

```bash
# Cloner le repo
git clone https://github.com/TON_USERNAME/kanban-esitec.git
cd kanban-esitec

# Installer les dépendances PHP
composer install

# Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la DB dans .env (DB_DATABASE, etc.)

# Migrer et seeder
php artisan migrate --seed

# Installer assets JS/CSS
npm install &amp;&amp; npm run dev

# Lancer le serveur
php artisan serve
```

**URL par défaut :** `http://127.0.0.1:8000`

---

<div align=\"center\">

> **Projet réalisé en groupe de 3** — **ESITEC 2025-2026** 🏆

<img src=\"https://img.shields.io/badge/ESITEC-2025%202026-007ACC?style=for-the-badge&logoColor=white\" alt=\"ESITEC\" />

</div>
