<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Candidature;

class UpdateCandidatureRequest extends FormRequest
{
    /** Autorise toujours la requête (la protection est assurée par les policies) */
    public function authorize(): bool
    {
        return true;
    }

    /** Règles de validation pour la modification d'une candidature */
    public function rules(): array
    {
        return [
            'entreprise' => ['required', 'string', 'max:255'],
            'poste' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url'],
            'statut' => ['required', 'in:' . implode(',', array_keys(Candidature::STATUTS))],
            'priorite' => ['required', 'in:' . implode(',', array_keys(Candidature::PRIORITES))],
            'notes' => ['nullable', 'string'],
            'date_candidature' => ['required', 'date'],
        ];
    }
}