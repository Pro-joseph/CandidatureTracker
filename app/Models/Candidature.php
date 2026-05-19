<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidature extends Model
{
    use SoftDeletes;

    public const STATUTS = [
        'to_review'          => 'À réviser',
        'interview_scheduled' => 'Entretien prévu',
        'offer_received'     => 'Offre reçue',
        'rejected'           => 'Refusée',
        'abandoned'          => 'Abandonnée',
    ];

    public const PRIORITES = [
        'high'   => 'Haute',
        'medium' => 'Moyenne',
        'low'    => 'Basse',
    ];

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

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['statut'] ?? null, fn($q, $v) => $q->where('statut', $v))
            ->when($filters['priorite'] ?? null, fn($q, $v) => $q->where('priorite', $v));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }
}
