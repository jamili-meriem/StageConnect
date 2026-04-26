<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationApp extends Model
{
    // On spécifie le nom de table car il ne suit pas la convention Laravel
    protected $table = 'notifications_stageconnect';

    protected $fillable = [
        'user_id', 'titre', 'message',
        'type', 'lien', 'lue_at'
    ];

    protected $casts = [
        'lue_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Vérifie si la notification est lue
    public function isLue(): bool
    {
        return $this->lue_at !== null;
    }

    // Marque comme lue
    public function marquerLue(): void
    {
        $this->update(['lue_at' => now()]);
    }

    // Scope pour les non lues
    public function scopeNonLues($query)
    {
        return $query->whereNull('lue_at');
    }

    // Couleur selon le type
    public function getCouleurAttribute(): string
    {
        return match($this->type) {
            'success' => 'green',
            'warning' => 'amber',
            'danger'  => 'red',
            default   => 'blue',
        };
    }
}