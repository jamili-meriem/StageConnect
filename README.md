# 🎓 StageConnect — Plateforme de Gestion de Stages

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=docker&logoColor=white)
![Groq AI](https://img.shields.io/badge/Groq_AI-LLaMA_3.3-green?style=for-the-badge)

> Plateforme complète de gestion de stages connectant étudiants et entreprises, avec IA intégrée pour la génération de lettres de motivation, chatbot conseiller et recommandations personnalisées.

---

## ✨ Fonctionnalités principales

### 🎓 Espace Étudiant
- Inscription et connexion sécurisée
- Profil complet (université, filière, niveau, CV)
- Parcourir et filtrer les offres de stage
- Postuler avec CV (PDF) et lettre de motivation
- **IA : Génération automatique de lettre de motivation** avec Groq (LLaMA 3.3)
- **IA : Chatbot conseiller** de stage personnel
- **IA : Recommandations d'offres** personnalisées selon le profil
- Système de favoris ❤️
- Suivi des candidatures en temps réel
- Notifications (acceptée / refusée)
- Voir les évaluations reçues

### 🏢 Espace Entreprise
- Profil entreprise complet (logo, secteur, taille, Google Maps)
- Publication et gestion des offres de stage
- Offres enrichies : salaire, type de travail, compétences requises
- Gestion des candidatures reçues
- Accepter / refuser les candidatures
- Évaluation des stagiaires (système de notes ⭐)
- Notifications automatiques aux étudiants

### ⚙️ Espace Admin
- Dashboard avec statistiques globales
- Graphiques interactifs (Chart.js) : candidatures, offres, inscriptions
- Gestion des utilisateurs
- Gestion de toutes les offres
- Vue d'ensemble de la plateforme

---

## 🤖 Intelligence Artificielle (Groq API)

| Fonctionnalité | Description |
|---|---|
| **Génération lettre** | Génère une lettre de motivation personnalisée en 1 clic |
| **Chatbot conseiller** | Assistant IA pour conseiller les étudiants |
| **Recommandations** | Suggère les meilleures offres selon le profil |

Modèle utilisé : **LLaMA 3.3 70B Versatile** via l'API Groq

---

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Blade, Tailwind CSS v4 |
| Base de données | MySQL 8 |
| IA | Groq API (LLaMA 3.3) |
| Authentification | Laravel Breeze |
| Containerisation | Docker + Docker Compose |
| Versionning | Git + GitHub |

---

## 🚀 Installation et lancement

### Prérequis
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8
- Docker (optionnel)

### Installation locale

```bash
# 1. Cloner le projet
git clone https://github.com/jamili-meriem/StageConnect.git
cd StageConnect

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stageconnect
DB_USERNAME=root
DB_PASSWORD=

# 7. Lancer les migrations et les seeders
php artisan migrate --seed

# 8. Créer le lien symbolique pour le stockage
php artisan storage:link

# 9. Lancer le serveur
php artisan serve

# 10. Compiler les assets (dans un autre terminal)
npm run dev
```

### Avec Docker

```bash
# Construire et lancer les conteneurs
docker-compose up --build

# Lancer les migrations
docker exec stageconnect_app php artisan migrate --seed
```

L'application sera accessible sur `http://localhost:8080`

---

## 👥 Comptes de test

| Email | Mot de passe | Rôle |
|---|---|---|
| `admin@stageconnect.com` | `password` | Admin |
| `tech@maroc.com` | `password` | Entreprise |
| `digital@agency.com` | `password` | Entreprise |
| `meriem@etudiant.com` | `password` | Étudiant |
| `youssef@etudiant.com` | `password` | Étudiant |

---

## 📁 Structure du projet
StageConnect/
├── app/
│   ├── Http/Controllers/     # Contrôleurs (Étudiant, Entreprise, Admin, IA...)
│   ├── Models/               # Modèles Eloquent (User, Offre, Candidature...)
│   ├── Services/             # Service IA Groq
│   ├── Helpers/              # Helper Notifications
│   └── Http/Middleware/      # Middleware des rôles
├── database/
│   ├── migrations/           # Migrations des tables
│   └── seeders/              # Données de test
├── resources/
│   ├── views/                # Templates Blade
│   │   ├── etudiant/         # Vues espace étudiant
│   │   ├── entreprise/       # Vues espace entreprise
│   │   ├── admin/            # Vues espace admin
│   │   └── layouts/          # Layout principal + navbar
│   └── css/                  # Tailwind CSS v4
├── routes/
│   └── web.php               # 40+ routes organisées par rôle
├── Dockerfile                # Image Docker
└── docker-compose.yml        # Configuration Docker
---

## 🔒 Sécurité

- Authentification avec Laravel Breeze
- Hashage bcrypt des mots de passe
- Protection CSRF sur tous les formulaires
- Middleware de rôles (étudiant / entreprise / admin)
- Validation des fichiers uploadés (PDF uniquement, max 2Mo)
- Rate limiting sur les tentatives de connexion
- Pages d'erreur 403 et 404 personnalisées

---

## 📸 Captures d'écran

> *Captures d'écran à ajouter*

---

## 👩‍💻 Développé par

**Meriem Jamili** — Étudiante en Génie Informatique

[![GitHub](https://img.shields.io/badge/GitHub-jamili--meriem-black?style=flat&logo=github)](https://github.com/jamili-meriem)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Meriem_Jamili-blue?style=flat&logo=linkedin)](https://linkedin.com/in/meriem-jamili)

---

## 📄 Licence

Ce projet est développé dans le cadre d'un projet académique.