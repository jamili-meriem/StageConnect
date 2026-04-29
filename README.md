# 🎓 StageConnect — Plateforme de Gestion de Stages

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge)
![Docker](https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=docker)
![Groq AI](https://img.shields.io/badge/Groq_AI-LLaMA_3.3-green?style=for-the-badge)

> **Application en ligne :** https://stageconnect-main-2zczbi.free.laravel.cloud

Plateforme complète de gestion de stages connectant étudiants et entreprises, avec IA intégrée.

---

## ✨ Fonctionnalités

### 🎓 Espace Étudiant
- Profil complet (université, filière, CV, LinkedIn)
- Parcourir/filtrer offres (domaine, type travail)
- Système de favoris ❤️
- Candidature avec upload PDF
- **IA :** Génération automatique de lettre de motivation
- **IA :** Chatbot conseiller flottant
- **IA :** Recommandations d'offres personnalisées
- Suivi des candidatures + notifications
- Mode sombre/clair

### 🏢 Espace Entreprise
- Profil complet (logo, secteur, taille, Google Maps)
- CRUD offres enrichies (salaire, télétravail, compétences)
- Gestion des candidatures
- Accepter/Refuser
- Évaluation des stagiaires ⭐

### ⚙️ Espace Admin
- Dashboard avec 4 graphiques Chart.js
- Gestion utilisateurs + offres
- Statistiques globales

---

## 🛠️ Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Blade, Tailwind CSS v4 |
| Base de données | MySQL 8 |
| IA | Groq API (LLaMA 3.3) |
| Authentification | Laravel Breeze |
| Containerisation | Docker |
| CI/CD | GitHub Actions |
| Déploiement | Laravel Cloud |

---

## 🚀 Installation locale

```bash
git clone https://github.com/jamili-meriem/StageConnect.git
cd StageConnect
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
npm run dev
## 👥 Comptes de test
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
💡 Utilisez ces comptes pour tester toutes les fonctionnalités.

## 📊 Chiffres clés
40+ routes

12 migrations

10 modèles Eloquent

10+ vues Blade

4 contrôleurs + 1 IA

##🔒 Sécurité implémentée
Fonctionnalité	Description
Middleware de rôles	3 niveaux : étudiant, entreprise, admin
CSRF Protection	Tokens sur tous les formulaires POST
Hash bcrypt	Mots de passe jamais stockés en clair
Rate Limiting	5 tentatives de login/minute maximum
Validation fichiers	CV : PDF uniquement, max 2 Mo
Sanitization	Protection XSS sur toutes les entrées
Authentification	Laravel Breeze avec session sécurisée
Gates & Policies	Vérification des permissions par rôle
Stockage sécurisé	Fichiers CV dans storage protégé
##👩‍💻 Auteur
Meriem Jamili — Étudiante en Génie Informatique

https://img.shields.io/badge/GitHub-jamili--meriem-black?style=flat&logo=github


