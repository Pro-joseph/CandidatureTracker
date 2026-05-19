<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Entretien;

class UpdateEntretienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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