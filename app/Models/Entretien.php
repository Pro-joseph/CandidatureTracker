<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory;
    /** Types d'entretien possibles */
    public const TYPES = [
        'telephone' => 'Téléphone',
        'technique' => 'Technique',
        'rh'        => 'RH',
        'final'     => 'Final',
    ];

    /** Résultats possibles d'un entretien */
    public const RESULTATS = [
        'pending'  => 'En attente',
        'positive' => 'Positif',
        'negative' => 'Négatif',
    ];

    /** Champs assignables en masse */
    protected $fillable = [
        'candidature_id',
        'type',
        'date_heure',
        'notes',
        'resultat',
    ];

    /** Attributs ajoutés automatiquement à la sérialisation */
    protected $appends = ['type_label'];

    /** Relation : candidature associée à cet entretien */
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    /** Accesseur : libellé lisible du type d'entretien */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
