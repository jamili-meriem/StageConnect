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
seed


👥 Comptes de test
Email	Mot de passe	Rôle
admin@stageconnect.com	password	Admin
tech@maroc.com	password	Entreprise
digital@agency.com	password	Entreprise
startup@hub.com	password	Entreprise
design@studio.com	password	Entreprise
meriem@etudiant.com	password	Étudiant
youssef@etudiant.com	password	Étudiant
sara@etudiant.com	password	Étudiant
karim@etudiant.com	password	Étudiant
fatima@etudiant.com	password	Étudiant
💡 Astuce : Utilisez ces comptes pour tester toutes les fonctionnalités de la plateforme.

📊 Chiffres clés
40+ routes

12 migrations

10 modèles Eloquent

10+ vues Blade

4 contrôleurs métier + 1 IA

🔒 Sécurité
Middleware de rôles (étudiant/entreprise/admin)

Protection CSRF sur tous les formulaires

Hashage bcrypt des mots de passe

Rate limiting sur login (5 tentatives/minute)

Validation des fichiers (PDF max 2 Mo)

Pages d'erreur 403/404 personnalisées


👩‍💻 Auteur
Meriem Jamili — Étudiante en Génie Informatique

https://img.shields.io/badge/GitHub-jamili--meriem-black?style=flat&logo=github


