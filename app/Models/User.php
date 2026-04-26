<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'bio', 'avatar',
        'secteur', 'taille_entreprise', 'site_web',
        'adresse', 'ville', 'latitude', 'longitude',
        'universite', 'filiere', 'niveau',
        'cv_path', 'linkedin',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'latitude'          => 'float',
            'longitude'         => 'float',
        ];
    }

    // ========== RÔLES ==========

    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    public function isEntreprise(): bool
    {
        return $this->role === 'entreprise';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ========== RELATIONS ==========

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function offresFavoris()
    {
        // Relation many-to-many via la table favoris
        return $this->belongsToMany(Offre::class, 'favoris')
                    ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(NotificationApp::class);
    }

    public function evaluationsRecues()
    {
        return $this->hasMany(Evaluation::class, 'evalue_id');
    }

    public function evaluationsDonnees()
    {
        return $this->hasMany(Evaluation::class, 'evaluateur_id');
    }

    // ========== MÉTHODES UTILES ==========

    // Retourne l'URL de l'avatar ou une image par défaut
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Génère un avatar avec les initiales
        $initiales = strtoupper(substr($this->name, 0, 2));
        return "https://ui-avatars.com/api/?name={$initiales}&background=1e40af&color=fff&size=128";
    }

    // Retourne la note moyenne de l'utilisateur
    public function getNoteMoyenneAttribute(): float
    {
        return $this->evaluationsRecues()->avg('note') ?? 0;
    }

    // Vérifie si l'offre est en favori
    public function aEnFavori(int $offreId): bool
    {
        return $this->favoris()->where('offre_id', $offreId)->exists();
    }
}