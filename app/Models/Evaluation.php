<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'candidature_id', 'evaluateur_id',
        'evalue_id', 'note', 'commentaire', 'type'
    ];

    protected $casts = [
        'note' => 'integer',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    public function evalue()
    {
        return $this->belongsTo(User::class, 'evalue_id');
    }

    // Retourne les étoiles en HTML
    public function getEtoilesAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->note ? '★' : '☆';
        }
        return $html;
    }
}