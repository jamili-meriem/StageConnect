<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Offre;
use App\Models\Candidature;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========== UTILISATEURS ==========

        $admin = User::create([
            'name'     => 'Admin StageConnect',
            'email'    => 'admin@stageconnect.com',
            'password' => bcrypt('password'),
            'role'     => 'admin',
            'ville'    => 'Rabat',
        ]);

        $entreprise1 = User::create([
            'name'              => 'TechMaroc SARL',
            'email'             => 'tech@maroc.com',
            'password'          => bcrypt('password'),
            'role'              => 'entreprise',
            'secteur'           => 'Technologie',
            'taille_entreprise' => '51-200 employés',
            'ville'             => 'Casablanca',
            'adresse'           => '123 Boulevard Mohammed V',
            'site_web'          => 'https://techmaroc.ma',
            'phone'             => '+212 5 22 00 00 01',
            'bio'               => 'TechMaroc est une entreprise leader dans le développement de solutions digitales au Maroc. Nous accompagnons nos clients dans leur transformation numérique depuis 2010.',
            'latitude'          => 33.5731,
            'longitude'         => -7.5898,
        ]);

        $entreprise2 = User::create([
            'name'              => 'DigitalAgency Casablanca',
            'email'             => 'digital@agency.com',
            'password'          => bcrypt('password'),
            'role'              => 'entreprise',
            'secteur'           => 'Marketing Digital',
            'taille_entreprise' => '11-50 employés',
            'ville'             => 'Rabat',
            'adresse'           => '45 Avenue Hassan II',
            'site_web'          => 'https://digitalagency.ma',
            'phone'             => '+212 5 37 00 00 02',
            'bio'               => 'Agence digitale spécialisée dans le marketing en ligne, le SEO et la création de contenu. Nous aidons les marques à se développer sur le web.',
            'latitude'          => 33.9716,
            'longitude'         => -6.8498,
        ]);

        $entreprise3 = User::create([
            'name'              => 'StartupHub Maroc',
            'email'             => 'startup@hub.com',
            'password'          => bcrypt('password'),
            'role'              => 'entreprise',
            'secteur'           => 'Finance & Consulting',
            'taille_entreprise' => '1-10 employés',
            'ville'             => 'Fès',
            'adresse'           => '7 Rue Ibn Khaldoun',
            'site_web'          => 'https://startuphub.ma',
            'phone'             => '+212 5 35 00 00 03',
            'bio'               => 'Incubateur et accélérateur de startups marocaines. Nous accompagnons les jeunes entrepreneurs dans le développement de leurs projets innovants.',
            'latitude'          => 34.0181,
            'longitude'         => -5.0078,
        ]);

        $entreprise4 = User::create([
            'name'              => 'DesignStudio Marrakech',
            'email'             => 'design@studio.com',
            'password'          => bcrypt('password'),
            'role'              => 'entreprise',
            'secteur'           => 'Design & Créativité',
            'taille_entreprise' => '11-50 employés',
            'ville'             => 'Marrakech',
            'adresse'           => '22 Rue de la Liberté',
            'site_web'          => 'https://designstudio.ma',
            'phone'             => '+212 5 24 00 00 04',
            'bio'               => 'Studio de design créatif spécialisé en UI/UX, branding et communication visuelle. Nous créons des expériences visuelles mémorables.',
            'latitude'          => 31.6295,
            'longitude'         => -7.9811,
        ]);

        // Étudiants
        $etudiant1 = User::create([
            'name'       => 'Meriem Benali',
            'email'      => 'meriem@etudiant.com',
            'password'   => bcrypt('password'),
            'role'       => 'etudiant',
            'universite' => 'ENSIAS Rabat',
            'filiere'    => 'Génie Informatique',
            'niveau'     => 'Bac+5',
            'ville'      => 'Rabat',
            'phone'      => '+212 6 61 00 00 01',
            'linkedin'   => 'https://linkedin.com/in/meriem-benali',
            'bio'        => 'Étudiante passionnée par le développement web et l\'intelligence artificielle. Je cherche un stage pour mettre en pratique mes compétences en Laravel, React et Python.',
        ]);

        $etudiant2 = User::create([
            'name'       => 'Youssef Alami',
            'email'      => 'youssef@etudiant.com',
            'password'   => bcrypt('password'),
            'role'       => 'etudiant',
            'universite' => 'ENSA Casablanca',
            'filiere'    => 'Génie Logiciel',
            'niveau'     => 'Bac+3',
            'ville'      => 'Casablanca',
            'phone'      => '+212 6 62 00 00 02',
            'linkedin'   => 'https://linkedin.com/in/youssef-alami',
            'bio'        => 'Développeur frontend passionné par Vue.js et les interfaces modernes. Je cherche à rejoindre une équipe dynamique pour un stage enrichissant.',
        ]);

        $etudiant3 = User::create([
            'name'       => 'Sara Idrissi',
            'email'      => 'sara@etudiant.com',
            'password'   => bcrypt('password'),
            'role'       => 'etudiant',
            'universite' => 'ENCG Fès',
            'filiere'    => 'Marketing Digital',
            'niveau'     => 'Bac+4',
            'ville'      => 'Fès',
            'phone'      => '+212 6 63 00 00 03',
            'bio'        => 'Étudiante en marketing digital avec une passion pour les réseaux sociaux et le content marketing. Créative et organisée.',
        ]);

        $etudiant4 = User::create([
            'name'       => 'Karim Tahiri',
            'email'      => 'karim@etudiant.com',
            'password'   => bcrypt('password'),
            'role'       => 'etudiant',
            'universite' => 'ISCAE Casablanca',
            'filiere'    => 'Finance d\'entreprise',
            'niveau'     => 'Bac+5',
            'ville'      => 'Casablanca',
            'phone'      => '+212 6 64 00 00 04',
            'bio'        => 'Étudiant en finance avec de solides bases en comptabilité et analyse financière. Rigoureux et analytique.',
        ]);

        $etudiant5 = User::create([
            'name'       => 'Fatima Zahra Oulhaj',
            'email'      => 'fatima@etudiant.com',
            'password'   => bcrypt('password'),
            'role'       => 'etudiant',
            'universite' => 'ESAV Marrakech',
            'filiere'    => 'Design Graphique',
            'niveau'     => 'Bac+3',
            'ville'      => 'Marrakech',
            'phone'      => '+212 6 65 00 00 05',
            'linkedin'   => 'https://linkedin.com/in/fatima-oulhaj',
            'bio'        => 'Designer passionnée par l\'UI/UX et le branding. Maîtrise Figma, Adobe XD et la suite Adobe. Je cherche à créer des expériences visuelles impactantes.',
        ]);

        // ========== OFFRES ==========

        $offre1 = Offre::create([
            'user_id'              => $entreprise1->id,
            'titre'                => 'Développeur Laravel Full-Stack',
            'domaine'              => 'informatique',
            'lieu'                 => 'Casablanca',
            'description'          => 'Nous recherchons un stagiaire développeur Laravel pour rejoindre notre équipe tech. Vous travaillerez sur des projets web innovants avec une stack moderne PHP/Laravel/MySQL/Vue.js. Vous participerez au développement de nouvelles fonctionnalités et à la maintenance des applications existantes.',
            'duree'                => '3 mois',
            'date_limite'          => '2026-07-30',
            'salaire_min'          => 2000,
            'salaire_max'          => 3500,
            'type_travail'         => 'hybride',
            'niveau_requis'        => 'bac+3',
            'nombre_postes'        => 2,
            'competences_requises' => ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Git'],
            'is_active'            => true,
            'vues'                 => 45,
        ]);

        $offre2 = Offre::create([
            'user_id'              => $entreprise1->id,
            'titre'                => 'Développeur Frontend React.js',
            'domaine'              => 'informatique',
            'lieu'                 => 'Casablanca',
            'description'          => 'Stage frontend avec React.js et Tailwind CSS. Vous participerez au développement de nos interfaces utilisateurs modernes et responsives. Vous travaillerez en étroite collaboration avec notre équipe design et backend.',
            'duree'                => '2 mois',
            'date_limite'          => '2026-08-15',
            'salaire_min'          => 1500,
            'salaire_max'          => 2500,
            'type_travail'         => 'presentiel',
            'niveau_requis'        => 'bac+2',
            'nombre_postes'        => 1,
            'competences_requises' => ['React.js', 'JavaScript', 'Tailwind CSS', 'HTML/CSS'],
            'is_active'            => true,
            'vues'                 => 32,
        ]);

        $offre3 = Offre::create([
            'user_id'              => $entreprise2->id,
            'titre'                => 'Stage Marketing Digital & SEO',
            'domaine'              => 'marketing',
            'lieu'                 => 'Rabat',
            'description'          => 'Rejoignez notre équipe marketing pour apprendre les métiers du digital : SEO, réseaux sociaux, email marketing et analytics Google. Vous gérerez des campagnes pour nos clients et analyserez les performances.',
            'duree'                => '3 mois',
            'date_limite'          => '2026-06-30',
            'salaire_min'          => 1200,
            'salaire_max'          => 2000,
            'type_travail'         => 'hybride',
            'niveau_requis'        => 'bac+3',
            'nombre_postes'        => 2,
            'competences_requises' => ['SEO', 'Google Analytics', 'Réseaux sociaux', 'Canva'],
            'is_active'            => true,
            'vues'                 => 28,
        ]);

        $offre4 = Offre::create([
            'user_id'              => $entreprise4->id,
            'titre'                => 'Designer UI/UX',
            'domaine'              => 'design',
            'lieu'                 => 'Marrakech',
            'description'          => 'Stage design UI/UX pour créer des interfaces modernes et intuitives. Vous travaillerez sur des projets réels pour nos clients nationaux et internationaux. Maîtrise de Figma requise.',
            'duree'                => '4 mois',
            'date_limite'          => '2026-09-01',
            'salaire_min'          => 1500,
            'salaire_max'          => 2500,
            'type_travail'         => 'presentiel',
            'niveau_requis'        => 'bac+3',
            'nombre_postes'        => 1,
            'competences_requises' => ['Figma', 'Adobe XD', 'Illustrator', 'Photoshop'],
            'is_active'            => true,
            'vues'                 => 56,
        ]);

        $offre5 = Offre::create([
            'user_id'              => $entreprise3->id,
            'titre'                => 'Stage Finance & Analyse',
            'domaine'              => 'finance',
            'lieu'                 => 'Fès',
            'description'          => 'Stage en finance pour participer à la gestion comptable et financière. Vous analyserez les données financières, préparerez des rapports et assisterez dans la prise de décisions stratégiques.',
            'duree'                => '2 mois',
            'date_limite'          => '2026-07-15',
            'salaire_min'          => 1000,
            'salaire_max'          => 1800,
            'type_travail'         => 'presentiel',
            'niveau_requis'        => 'bac+4',
            'nombre_postes'        => 1,
            'competences_requises' => ['Excel avancé', 'Comptabilité', 'Analyse financière', 'Power BI'],
            'is_active'            => true,
            'vues'                 => 19,
        ]);

        $offre6 = Offre::create([
            'user_id'              => $entreprise2->id,
            'titre'                => 'Community Manager',
            'domaine'              => 'marketing',
            'lieu'                 => 'Rabat',
            'description'          => 'Stage en community management pour gérer les réseaux sociaux de nos clients. Vous créerez du contenu engageant, animerez les communautés et analyserez les performances des publications.',
            'duree'                => '3 mois',
            'date_limite'          => '2026-08-01',
            'salaire_min'          => 1000,
            'salaire_max'          => 1500,
            'type_travail'         => 'remote',
            'niveau_requis'        => 'bac+2',
            'nombre_postes'        => 2,
            'competences_requises' => ['Instagram', 'Facebook', 'TikTok', 'Canva', 'Copywriting'],
            'is_active'            => true,
            'vues'                 => 38,
        ]);

        $offre7 = Offre::create([
            'user_id'              => $entreprise1->id,
            'titre'                => 'DevOps & Cloud Engineer',
            'domaine'              => 'informatique',
            'lieu'                 => 'Casablanca',
            'description'          => 'Stage DevOps pour apprendre Docker, Kubernetes et les services cloud AWS. Vous participerez à l\'automatisation des déploiements et à l\'amélioration de notre infrastructure technique.',
            'duree'                => '4 mois',
            'date_limite'          => '2026-09-15',
            'salaire_min'          => 2500,
            'salaire_max'          => 4000,
            'type_travail'         => 'hybride',
            'niveau_requis'        => 'bac+5',
            'nombre_postes'        => 1,
            'competences_requises' => ['Docker', 'Linux', 'AWS', 'CI/CD', 'Python'],
            'is_active'            => true,
            'vues'                 => 67,
        ]);

        $offre8 = Offre::create([
            'user_id'              => $entreprise3->id,
            'titre'                => 'Assistant Ressources Humaines',
            'domaine'              => 'rh',
            'lieu'                 => 'Fès',
            'description'          => 'Stage RH pour participer au recrutement, à la gestion administrative du personnel et au développement de la marque employeur. Vous apprendrez les processus RH d\'une startup en croissance.',
            'duree'                => '3 mois',
            'date_limite'          => '2026-07-01',
            'salaire_min'          => 800,
            'salaire_max'          => 1200,
            'type_travail'         => 'presentiel',
            'niveau_requis'        => 'bac+3',
            'nombre_postes'        => 1,
            'competences_requises' => ['Communication', 'Recrutement', 'Excel', 'Discrétion'],
            'is_active'            => true,
            'vues'                 => 14,
        ]);

        // ========== CANDIDATURES ==========

        $cand1 = Candidature::create([
            'user_id'    => $etudiant1->id,
            'offre_id'   => $offre1->id,
            'motivation' => 'Je suis passionnée par le développement web et Laravel depuis 2 ans. J\'ai développé plusieurs projets PHP durant ma formation en génie informatique, dont une plateforme e-commerce complète avec authentification, panier et chatbot. Je maîtrise Laravel, MySQL et Vue.js et suis très motivée à contribuer à votre équipe technique et à monter en compétences sur des projets réels.',
            'cv_path'    => 'cvs/meriem_cv.pdf',
            'statut'     => 'acceptee',
        ]);

        $cand2 = Candidature::create([
            'user_id'    => $etudiant1->id,
            'offre_id'   => $offre3->id,
            'motivation' => 'Le marketing digital m\'intéresse énormément car il combine créativité et analyse de données. J\'ai suivi des formations en ligne sur le SEO et Google Analytics. Je suis prête à mettre mes compétences analytiques au service de votre agence et à apprendre les meilleures pratiques du secteur.',
            'cv_path'    => 'cvs/meriem_cv.pdf',
            'statut'     => 'en_attente',
        ]);

        $cand3 = Candidature::create([
            'user_id'    => $etudiant2->id,
            'offre_id'   => $offre2->id,
            'motivation' => 'Passionné par le frontend et les nouvelles technologies, je maîtrise React.js et Vue.js. J\'ai développé plusieurs applications web dans le cadre de mes projets universitaires et personnels. Je suis particulièrement intéressé par les interfaces modernes et l\'expérience utilisateur. Rejoindre TechMaroc serait une opportunité parfaite pour progresser.',
            'cv_path'    => 'cvs/youssef_cv.pdf',
            'statut'     => 'en_attente',
        ]);

        $cand4 = Candidature::create([
            'user_id'    => $etudiant2->id,
            'offre_id'   => $offre7->id,
            'motivation' => 'Le DevOps et le cloud m\'attirent énormément. J\'ai des bases solides en Linux et j\'ai commencé à apprendre Docker et les concepts CI/CD. Je suis convaincu que ce stage me permettrait d\'acquérir des compétences très recherchées sur le marché et de contribuer efficacement à votre infrastructure.',
            'cv_path'    => 'cvs/youssef_cv.pdf',
            'statut'     => 'refusee',
        ]);

        $cand5 = Candidature::create([
            'user_id'    => $etudiant3->id,
            'offre_id'   => $offre3->id,
            'motivation' => 'Étudiante en marketing digital, j\'ai une vraie passion pour les réseaux sociaux et le SEO. J\'ai géré les comptes Instagram et Facebook de plusieurs petites entreprises locales avec des résultats positifs. Je suis créative, organisée et j\'apprends très vite. Ce stage serait l\'opportunité idéale pour professionnaliser mes compétences.',
            'cv_path'    => 'cvs/sara_cv.pdf',
            'statut'     => 'acceptee',
        ]);

        $cand6 = Candidature::create([
            'user_id'    => $etudiant3->id,
            'offre_id'   => $offre6->id,
            'motivation' => 'La gestion de communautés en ligne est ma passion. Je crée du contenu quotidiennement sur mes propres réseaux et je comprends parfaitement les algorithmes et les tendances. Je maîtrise Canva pour la création visuelle et j\'ai une bonne plume pour le copywriting.',
            'cv_path'    => 'cvs/sara_cv.pdf',
            'statut'     => 'en_attente',
        ]);

        $cand7 = Candidature::create([
            'user_id'    => $etudiant4->id,
            'offre_id'   => $offre5->id,
            'motivation' => 'Étudiant en finance avec de solides bases en comptabilité et analyse financière. Je maîtrise Excel avancé et j\'ai commencé à apprendre Power BI. Je suis rigoureux, analytique et capable de travailler sur des données complexes. Ce stage en finance me permettrait de mettre en pratique mes connaissances théoriques.',
            'cv_path'    => 'cvs/karim_cv.pdf',
            'statut'     => 'acceptee',
        ]);

        $cand8 = Candidature::create([
            'user_id'    => $etudiant5->id,
            'offre_id'   => $offre4->id,
            'motivation' => 'Étudiante en design graphique, je maîtrise Figma, Adobe XD et toute la suite Adobe. J\'ai réalisé plusieurs projets UI/UX pour des clients réels dans le cadre de mes études. Je suis passionnée par l\'expérience utilisateur et la création d\'interfaces intuitives. Rejoindre DesignStudio serait une chance incroyable de travailler sur des projets variés.',
            'cv_path'    => 'cvs/fatima_cv.pdf',
            'statut'     => 'acceptee',
        ]);

        $cand9 = Candidature::create([
            'user_id'    => $etudiant5->id,
            'offre_id'   => $offre6->id,
            'motivation' => 'En plus du design, je crée du contenu visuel pour les réseaux sociaux. Je combine mes compétences en design et en community management pour créer des publications attrayantes et engageantes. Je serais un vrai atout pour votre équipe.',
            'cv_path'    => 'cvs/fatima_cv.pdf',
            'statut'     => 'refusee',
        ]);

        // ========== ÉVALUATIONS ==========

        Evaluation::create([
            'candidature_id' => $cand1->id,
            'evaluateur_id'  => $entreprise1->id,
            'evalue_id'      => $etudiant1->id,
            'note'           => 5,
            'commentaire'    => 'Excellente stagiaire ! Très compétente en Laravel, travailleuse et proactive. Elle a livré un travail de qualité bien au-delà de nos attentes. Je la recommande vivement.',
            'type'           => 'entreprise_evalue',
        ]);

        Evaluation::create([
            'candidature_id' => $cand5->id,
            'evaluateur_id'  => $entreprise2->id,
            'evalue_id'      => $etudiant3->id,
            'note'           => 4,
            'commentaire'    => 'Très bonne stagiaire, créative et organisée. A bien géré les réseaux sociaux de nos clients avec des résultats mesurables. Quelques progrès à faire sur l\'analyse de données.',
            'type'           => 'entreprise_evalue',
        ]);

        Evaluation::create([
            'candidature_id' => $cand7->id,
            'evaluateur_id'  => $entreprise3->id,
            'evalue_id'      => $etudiant4->id,
            'note'           => 4,
            'commentaire'    => 'Bon stagiaire en finance, rigoureux et ponctuel. A bien maîtrisé les outils comptables. À encourager à développer ses compétences en présentation.',
            'type'           => 'entreprise_evalue',
        ]);

        Evaluation::create([
            'candidature_id' => $cand8->id,
            'evaluateur_id'  => $entreprise4->id,
            'evalue_id'      => $etudiant5->id,
            'note'           => 5,
            'commentaire'    => 'Fatima est une designer exceptionnelle. Sa maîtrise de Figma et sa créativité ont impressionné toute l\'équipe. Elle a livré des maquettes professionnelles qui ont été adoptées directement par nos clients.',
            'type'           => 'entreprise_evalue',
        ]);
    }
}