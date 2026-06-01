<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    /** Statuts possibles pour une candidature */
    public const STATUTS = [
        'to_review'          => 'À réviser',
        'interview_scheduled' => 'Entretien prévu',
        'offer_received'     => 'Offre reçue',
        'rejected'           => 'Refusée',
        'abandoned'          => 'Abandonnée',
    ];

    /** Niveaux de priorité */
    public const PRIORITES = [
        'high'   => 'Haute',
        'medium' => 'Moyenne',
        'low'    => 'Basse',
    ];

    /** Champs assignables en masse */
    protected $fillable = [
        'user_id',
        'entreprise',
        'poste',
        'url',
        'statut',
        'priorite',
        'notes',
        'date_candidature',
    ];

    /** Filtre les candidatures par statut et/ou priorité */
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['statut'] ?? null, fn($q, $v) => $q->where('statut', $v))
            ->when($filters['priorite'] ?? null, fn($q, $v) => $q->where('priorite', $v));
    }

    /** Relation : propriétaire de la candidature */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relation : entretiens liés à cette candidature */
    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }
}
