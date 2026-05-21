<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Entretien;

class StoreEntretienRequest extends FormRequest
{
    /** Autorise toujours la requête (la protection est assurée par les policies) */
    public function authorize(): bool
    {
        return true;
    }

    /** Règles de validation pour la création d'un entretien */
    public function rules(): array
    {
        return [
            'type' => ['required', 'in:' . implode(',', array_keys(Entretien::TYPES))],
            'date_heure' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'resultat' => ['required', 'in:' . implode(',', array_keys(Entretien::RESULTATS))],
        ];
    }
}