<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Candidature;

class StoreCandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // auth middleware already protects
    }

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