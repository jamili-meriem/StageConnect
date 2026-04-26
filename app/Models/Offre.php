<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'titre', 'description', 'domaine',
        'lieu', 'duree', 'date_limite', 'is_active',
        'salaire_min', 'salaire_max', 'type_travail',
        'niveau_requis', 'competences_requises',
        'nombre_postes', 'vues',
    ];

    protected $casts = [
        'date_limite'          => 'date',
        'is_active'            => 'boolean',
        'competences_requises' => 'array',
        'salaire_min'          => 'integer',
        'salaire_max'          => 'integer',
        'vues'                 => 'integer',
    ];

    // ========== RELATIONS ==========

    public function entreprise()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function etudiantsFavoris()
    {
        return $this->belongsToMany(User::class, 'favoris')
                    ->withTimestamps();
    }

    // ========== SCOPES ==========

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParDomaine($query, string $domaine)
    {
        return $query->where('domaine', $domaine);
    }

    public function scopeParVille($query, string $ville)
    {
        return $query->where('lieu', 'like', "%{$ville}%");
    }

    // ========== MÉTHODES UTILES ==========

    // Formate le salaire pour l'affichage
    public function getSalaireFormatAttribute(): string
    {
        if (!$this->salaire_min && !$this->salaire_max) {
            return 'Non rémunéré';
        }
        if ($this->salaire_min && $this->salaire_max) {
            return number_format($this->salaire_min) . ' - ' .
                   number_format($this->salaire_max) . ' MAD';
        }
        return 'À partir de ' . number_format($this->salaire_min) . ' MAD';
    }

    // Badge couleur pour le type de travail
    public function getTypeTravailBadgeAttribute(): array
    {
        return match($this->type_travail) {
            'remote'    => ['label' => 'Remote', 'color' => 'green'],
            'hybride'   => ['label' => 'Hybride', 'color' => 'amber'],
            default     => ['label' => 'Présentiel', 'color' => 'blue'],
        };
    }

    // Incrémente le compteur de vues
    public function incrementerVues(): void
    {
        $this->increment('vues');
    }
}