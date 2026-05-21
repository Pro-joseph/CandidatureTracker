<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use App\Http\Requests\StoreEntretienRequest;
use App\Http\Requests\UpdateEntretienRequest;

class EntretienController extends Controller
{
    /**
     * Ajoute un entretien à une candidature.
     */
    public function store(StoreEntretienRequest $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $candidature->entretiens()->create($request->validated());

        return back();
    }

    /**
     * Met à jour un entretien existant.
     */
    public function update(UpdateEntretienRequest $request, Entretien $entretien)
    {
        $this->authorize('update', $entretien->candidature);

        $entretien->update($request->validated());

        return back();
    }

    /**
     * Supprime un entretien.
     */
    public function destroy(Entretien $entretien)
    {
        $this->authorize('update', $entretien->candidature);

        $entretien->delete();

        return back();
    }
}