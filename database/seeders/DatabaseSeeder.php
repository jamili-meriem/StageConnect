<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Offre;
use App\Models\Candidature;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========== CRÉER LES UTILISATEURS ==========

        // Créer un admin
        // User::create() : insère un enregistrement dans la table users
        $admin = User::create([
            'name'     => 'Admin StageConnect',
            'email'    => 'admin@stageconnect.com',
            // bcrypt() : hash le mot de passe avant de le stocker
            // on ne stocke JAMAIS un mot de passe en clair
            'password' => bcrypt('password'),
            'role'     => 'admin',
        ]);

        // Créer 3 entreprises
        $entreprise1 = User::create([
            'name'     => 'TechMaroc SARL',
            'email'    => 'tech@maroc.com',
            'password' => bcrypt('password'),
            'role'     => 'entreprise',
        ]);

        $entreprise2 = User::create([
            'name'     => 'DigitalAgency Casablanca',
            'email'    => 'digital@agency.com',
            'password' => bcrypt('password'),
            'role'     => 'entreprise',
        ]);

        $entreprise3 = User::create([
            'name'     => 'StartupHub Rabat',
            'email'    => 'startup@hub.com',
            'password' => bcrypt('password'),
            'role'     => 'entreprise',
        ]);

        // Créer 3 étudiants
        $etudiant1 = User::create([
            'name'     => 'Meriem Benali',
            'email'    => 'meriem@etudiant.com',
            'password' => bcrypt('password'),
            'role'     => 'etudiant',
        ]);

        $etudiant2 = User::create([
            'name'     => 'Youssef Alami',
            'email'    => 'youssef@etudiant.com',
            'password' => bcrypt('password'),
            'role'     => 'etudiant',
        ]);

        $etudiant3 = User::create([
            'name'     => 'Sara Idrissi',
            'email'    => 'sara@etudiant.com',
            'password' => bcrypt('password'),
            'role'     => 'etudiant',
        ]);

        // ========== CRÉER LES OFFRES ==========

        // Offres de TechMaroc
        $offre1 = Offre::create([
            'user_id'     => $entreprise1->id,
            'titre'       => 'Développeur Laravel Junior',
            'domaine'     => 'informatique',
            'lieu'        => 'Casablanca',
            'description' => 'Nous recherchons un stagiaire développeur Laravel pour rejoindre notre équipe tech. Vous travaillerez sur des projets web innovants avec une stack moderne PHP/Laravel/MySQL. Bonne maîtrise de PHP requise.',
            'duree'       => '3 mois',
            'date_limite' => '2026-06-30',
            'is_active'   => true,
        ]);

        $offre2 = Offre::create([
            'user_id'     => $entreprise1->id,
            'titre'       => 'Développeur Frontend Vue.js',
            'domaine'     => 'informatique',
            'lieu'        => 'Casablanca',
            'description' => 'Stage frontend avec Vue.js et Tailwind CSS. Vous participerez au développement de nos interfaces utilisateurs modernes et responsives. Connaissance de JavaScript ES6+ requise.',
            'duree'       => '2 mois',
            'date_limite' => '2026-07-15',
            'is_active'   => true,
        ]);

        // Offres de DigitalAgency
        $offre3 = Offre::create([
            'user_id'     => $entreprise2->id,
            'titre'       => 'Stage Marketing Digital',
            'domaine'     => 'marketing',
            'lieu'        => 'Rabat',
            'description' => 'Rejoignez notre équipe marketing pour apprendre les métiers du digital : SEO, réseaux sociaux, email marketing et analytics. Vous gérerez des campagnes pour nos clients.',
            'duree'       => '3 mois',
            'date_limite' => '2026-05-30',
            'is_active'   => true,
        ]);

        $offre4 = Offre::create([
            'user_id'     => $entreprise2->id,
            'titre'       => 'Designer UI/UX',
            'domaine'     => 'design',
            'lieu'        => 'Rabat',
            'description' => 'Stage design UI/UX pour créer des interfaces modernes et intuitives. Maîtrise de Figma requise. Vous travaillerez en étroite collaboration avec les développeurs.',
            'duree'       => '4 mois',
            'date_limite' => '2026-08-01',
            'is_active'   => true,
        ]);

        // Offres de StartupHub
        $offre5 = Offre::create([
            'user_id'     => $entreprise3->id,
            'titre'       => 'Stage Finance et Comptabilité',
            'domaine'     => 'finance',
            'lieu'        => 'Fès',
            'description' => 'Stage en finance pour participer à la gestion comptable et financière de notre startup en pleine croissance. Connaissance d Excel et des bases de la comptabilité requises.',
            'duree'       => '2 mois',
            'date_limite' => '2026-06-15',
            'is_active'   => true,
        ]);

        $offre6 = Offre::create([
            'user_id'     => $entreprise3->id,
            'titre'       => 'Assistant Ressources Humaines',
            'domaine'     => 'rh',
            'lieu'        => 'Fès',
            'description' => 'Stage RH pour participer au recrutement, à la gestion administrative du personnel et au développement de la marque employeur. Bon relationnel et discrétion requis.',
            'duree'       => '3 mois',
            'date_limite' => '2026-07-01',
            'is_active'   => true,
        ]);

        // ========== CRÉER LES CANDIDATURES ==========

        // Meriem postule à 2 offres
        Candidature::create([
            'user_id'    => $etudiant1->id,
            'offre_id'   => $offre1->id,
            'motivation' => 'Je suis passionnée par le développement web et Laravel. J ai déjà réalisé plusieurs projets PHP durant ma formation en génie informatique. Je suis motivée à apprendre et à contribuer à votre équipe technique.',
            // Pour les tests, on met un chemin fictif
            // en production ce sera le vrai chemin du fichier uploadé
            'cv_path'    => 'cvs/meriem_cv.pdf',
            'statut'     => 'en_attente',
        ]);

        Candidature::create([
            'user_id'    => $etudiant1->id,
            'offre_id'   => $offre3->id,
            'motivation' => 'Le marketing digital m intéresse beaucoup. J ai suivi des formations en ligne sur le SEO et les réseaux sociaux. Je suis prête à mettre mes compétences au service de votre agence.',
            'cv_path'    => 'cvs/meriem_cv.pdf',
            'statut'     => 'acceptee',
        ]);

        // Youssef postule à 1 offre
        Candidature::create([
            'user_id'    => $etudiant2->id,
            'offre_id'   => $offre2->id,
            'motivation' => 'Passionné par le frontend et les nouvelles technologies, je maîtrise Vue.js et React. J ai développé plusieurs applications web dans le cadre de mes projets universitaires.',
            'cv_path'    => 'cvs/youssef_cv.pdf',
            'statut'     => 'refusee',
        ]);

        // Sara postule à 2 offres
        Candidature::create([
            'user_id'    => $etudiant3->id,
            'offre_id'   => $offre4->id,
            'motivation' => 'Étudiante en design graphique, je maîtrise Figma et Adobe XD. J ai réalisé plusieurs projets UI/UX pour des clients réels. Je souhaite rejoindre votre équipe créative.',
            'cv_path'    => 'cvs/sara_cv.pdf',
            'statut'     => 'en_attente',
        ]);

        Candidature::create([
            'user_id'    => $etudiant3->id,
            'offre_id'   => $offre5->id,
            'motivation' => 'Étudiante en finance, j ai de bonnes bases en comptabilité et maîtrise Excel avancé. Je suis rigoureuse et organisée, qualités essentielles pour ce poste.',
            'cv_path'    => 'cvs/sara_cv.pdf',
            'statut'     => 'en_attente',
        ]);
    }
}