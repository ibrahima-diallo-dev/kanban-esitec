<div align="center">

  <!-- Logo / Titre Animé -->
  <img src="https://readme-typing-svg.herokuapp.com/?lines=KanbanEsitec+%F0%9F%93%8B;Gestion+de+Projets+Collaboratifs;Laravel+Kanban+Board&font=Fira%20Code&center=true&width=600&height=100&duration=4000&pause=1000">

  <!-- Badges Principaux -->
  <img src="https://img.shields.io/badge/Laravel-11-DD0031?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Laravel_Breeze-10B981?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Breeze" />
  <img src="https://img.shields.io/badge/Blade-DD0031?style=for-the-badge&logoColor=white" alt="Blade" />

</div>

---

## 🌟 À propos du projet

> **"L'art de la gestion de projet, simplifié par le code."**

**Projet universitaire réalisé dans le cadre du cours _Projets Laravel - L2 Génie Logiciel_**  
📍 **ESITEC — Année académique 2025-2026**

**KanbanEsitec** est une application web moderne de gestion de projets de type Kanban. Développée avec le framework robuste **Laravel**, elle permet aux équipes de collaborer efficacement, d'assigner des tâches intelligemment et de visualiser l'avancement du travail en temps réel.

---

## ⚡ Fonctionnalités Clés

Voici ce que notre application a dans le ventre :

### 🔐 Authentification & Sécurité
- ✅ Inscription et Connexion fluides (propulsé par **Laravel Breeze**)
- ✅ Gestion stricte des rôles : **Admin** vs **Membre**
- ✅ Protection des routes via Middleware

### 📁 Gestion de Projet
- ✅ **CRUD** complet : Créer, Lire, Mettre à jour, Supprimer des projets
- ✅ Collaboration : Association de plusieurs membres à un projet (Relation *Many-to-Many*)
- ✅ Navigation aisée avec pagination

### ✅ Gestion des Tâches (Le cœur du Kanban)
- ✅ Cycle de vie complet des tâches
- ✅ Assignation précise des tâches aux membres
- ✅ Workflow visuel : **À faire** ➡️ **En cours** ➡️ **Terminé**
- ✅ Filtrage dynamique par statut (Laravel Scopes)
- ✅ Archivage intelligent (Soft Delete)

### 💬 Communication
- ✅ Système de commentaires par tâche
- ✅ Historique des discussions

### ⚙️ Panneau d'Administration
- ✅ Vue d'ensemble pour les administrateurs
- ✅ Contrôle total sur les projets, tâches et utilisateurs

---

## 🛠️ Stack Technique

Nous avons utilisé les meilleures technologies du marché pour garantir performance et stabilité.

<div align="center">
  <br>
  <img src="https://skillicons.dev/icons?i=laravel,php,mysql,tailwind,git&perline=5" />
  <br>
  <br>
  <sub>Built with ❤️ using Open Source technologies</sub>
</div>

---

## 👥 L'Équipe

Une synergie de talents pour un résultat optimal.

| Membre | Role | Expertise |
| :--- | :---: | :--- |
| **Ibrahima Saidou Diallo** | 👑 Chef de Projet | Contrôleurs & Logique Métier |
| **Abdoulaye Diallo** | 🛠️ Développeur Backend | Modèles, Migrations & Seeders |
| **Ange Okouaka** | 🎨 Développeur Frontend | Vues Blade & UX/UI |

---

## 🚀 Guide d'Installation

Prêt à lancer le projet ? Suivez ces étapes simples :

```bash
# 1. Cloner le dépôt
git clone https://github.com/ibrahima-diallo-dev/kanban-esitec.git
cd kanban-esitec

# 2. Installer les dépendances PHP
composer install

# 3. Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer votre base de données dans le fichier .env
# (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 5. Lancer les migrations et remplir la base de données
php artisan migrate --seed

# 6. Installer les assets frontend (JS & CSS)
npm install && npm run dev

# 7. Démarrer le serveur local
php artisan serve
