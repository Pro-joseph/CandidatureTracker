<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
        return $this->belongsTo(User::class);
}

public function entretiens()
{
    return $this->hasMany(Entretien::class);
}
