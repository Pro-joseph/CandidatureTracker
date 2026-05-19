<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    public const TYPES = [
        'telephone' => 'Téléphone',
        'technique' => 'Technique',
        'rh'        => 'RH',
        'final'     => 'Final',
    ];

    public const RESULTATS = [
        'pending'  => 'En attente',
        'positive' => 'Positif',
        'negative' => 'Négatif',
    ];

    protected $fillable = [
        'candidature_id',
        'type',
        'date_heure',
        'notes',
        'resultat',
    ];

    protected $appends = ['type_label'];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
