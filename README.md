# 🎓 StageConnect — Plateforme de Gestion de Stages

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge)
![Docker](https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=docker)
![Groq AI](https://img.shields.io/badge/Groq_AI-LLaMA_3.3-green?style=for-the-badge)

> **Application en ligne :** https://stageconnect-main-2zczbi.free.laravel.cloud

Plateforme complète de gestion de stages connectant étudiants et entreprises, avec IA intégrée pour la génération de lettres de motivation, chatbot conseiller et recommandations personnalisées.

---

## ✨ Fonctionnalités

### 🎓 Espace Étudiant
- Profil complet (université, filière, CV)
- Parcourir/filtrer offres de stage
- Postuler avec CV PDF et lettre
- **IA :** Génération de lettre de motivation
- **IA :** Chatbot conseiller 24/7
- **IA :** Recommandations personnalisées
- Favoris et suivi candidatures
- Notifications en temps réel

### 🏢 Espace Entreprise
- Profil complet (logo, secteur, Google Maps)
- CRUD offres enrichies (salaire, télétravail, compétences)
- Gestion des candidatures (Accepter/Refuser)
- Évaluation des stagiaires ⭐

### ⚙️ Espace Admin
- Dashboard avec graphiques Chart.js
- Statistiques : offres, candidatures, inscriptions
- Gestion des utilisateurs et offres

---

## 🛠️ Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Blade, Tailwind CSS v4 |
| Base de données | MySQL 8 |
| IA | Groq API (LLaMA 3.3 70B) |
| Authentification | Laravel Breeze |
| Containerisation | Docker |
| CI/CD | GitHub Actions |
| Déploiement | Laravel Cloud |

---

## 🚀 Installation locale

```bash
# 1. Cloner
git clone https://github.com/jamili-meriem/StageConnect.git
cd StageConnect

# 2. Dépendances
composer install
npm install

# 3. Configuration
cp .env.example .env
php artisan key:generate

# 4. Base de données
php artisan migrate --seed

# 5. Stockage
php artisan storage:link

# 6. Lancer
php artisan serve
npm run dev
