<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offre_id',
        'motivation',
        'cv_path',
        'statut',
    ];

    // ========== RELATIONS ==========

    // Une candidature appartient à un étudiant (user)
    // Plusieurs candidatures → un seul étudiant
    public function etudiant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Une candidature appartient à une offre
    // Plusieurs candidatures → une seule offre
    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    // ========== MÉTHODES UTILES ==========

    // isEnAttente() : retourne true si la candidature est en attente
    // utilisé dans les vues : @if($candidature->isEnAttente())
    public function isEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    public function isAcceptee(): bool
    {
        return $this->statut === 'acceptee';
    }

    public function isRefusee(): bool
    {
        return $this->statut === 'refusee';
    }
}