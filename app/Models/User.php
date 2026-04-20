<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // fillable : liste des colonnes qu'on peut remplir en masse
    // sans ça, Laravel refuse d'insérer les données par sécurité
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // on ajoute role ici
    ];

    // hidden : colonnes jamais affichées (ex: dans les réponses JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casts : convertit automatiquement les types
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // password est automatiquement hashé avec bcrypt
            'password' => 'hashed',
        ];
    }

    // ========== MÉTHODES DE RÔLE ==========

    // isEtudiant() : retourne true si l'utilisateur est étudiant
    // utilisé dans les vues : @if(auth()->user()->isEtudiant())
    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    // isEntreprise() : retourne true si l'utilisateur est une entreprise
    public function isEntreprise(): bool
    {
        return $this->role === 'entreprise';
    }

    // isAdmin() : retourne true si l'utilisateur est admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ========== RELATIONS ==========

    // Une entreprise (user) peut avoir plusieurs offres
    // hasMany : relation "un à plusieurs"
    // Un user → plusieurs offres
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    // Un étudiant (user) peut avoir plusieurs candidatures
    // Un user → plusieurs candidatures
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }
}