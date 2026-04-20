<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    // Toutes les colonnes qu'on peut remplir en masse
    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'domaine',
        'lieu',
        'duree',
        'date_limite',
        'is_active',
    ];

    // casts : convertit automatiquement les types PHP
    protected $casts = [
        // date_limite sera un objet Carbon (gestion de dates)
        // ça permet de faire $offre->date_limite->format('d/m/Y')
        'date_limite' => 'date',

        // is_active sera un vrai boolean PHP (true/false)
        // pas juste 0 ou 1 comme en base de données
        'is_active' => 'boolean',
    ];

    // ========== RELATIONS ==========

    // Une offre appartient à un user (l'entreprise qui l'a créée)
    // belongsTo : relation "plusieurs à un"
    // Plusieurs offres → un seul user
    public function entreprise()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Une offre peut avoir plusieurs candidatures
    // Un offre → plusieurs candidatures
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    // ========== SCOPES ==========

    // scopeActive : filtre automatique pour n'avoir que les offres actives
    // utilisé comme : Offre::active()->get()
    // au lieu de : Offre::where('is_active', true)->get()
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}