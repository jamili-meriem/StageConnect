<?php

namespace App\Helpers;

use App\Models\NotificationApp;

class NotificationHelper
{
    // Envoie une notification à un utilisateur
    public static function envoyer(
        int $userId,
        string $titre,
        string $message,
        string $type = 'info',
        string $lien = null
    ): void {
        NotificationApp::create([
            'user_id' => $userId,
            'titre'   => $titre,
            'message' => $message,
            'type'    => $type,
            'lien'    => $lien,
        ]);
    }

    // Notifie l'étudiant que sa candidature a été acceptée
    public static function candidatureAcceptee(int $etudiantId, string $titreOffre): void
    {
        self::envoyer(
            userId:  $etudiantId,
            titre:   'Candidature acceptée ! 🎉',
            message: "Félicitations ! Votre candidature pour \"{$titreOffre}\" a été acceptée.",
            type:    'success',
            lien:    '/etudiant/dashboard'
        );
    }

    // Notifie l'étudiant que sa candidature a été refusée
    public static function candidatureRefusee(int $etudiantId, string $titreOffre): void
    {
        self::envoyer(
            userId:  $etudiantId,
            titre:   'Candidature non retenue',
            message: "Votre candidature pour \"{$titreOffre}\" n'a pas été retenue. Ne vous découragez pas !",
            type:    'warning',
            lien:    '/etudiant/offres'
        );
    }

    // Notifie l'entreprise d'une nouvelle candidature
    public static function nouvelleCandidature(int $entrepriseId, string $etudiantName, string $titreOffre): void
    {
        self::envoyer(
            userId:  $entrepriseId,
            titre:   'Nouvelle candidature reçue',
            message: "{$etudiantName} a postulé à votre offre \"{$titreOffre}\".",
            type:    'info',
            lien:    '/entreprise/dashboard'
        );
    }
}