<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use App\Http\Requests\StoreEntretienRequest;
use App\Http\Requests\UpdateEntretienRequest;

class EntretienController extends Controller
{
    public function store(StoreEntretienRequest $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $candidature->entretiens()->create($request->validated());

        return back();
    }

    public function update(UpdateEntretienRequest $request, Entretien $entretien)
    {
        $this->authorize('update', $entretien->candidature);

        $entretien->update($request->validated());

        return back();
    }

    public function destroy(Entretien $entretien)
    {
        $this->authorize('update', $entretien->candidature);

        $entretien->delete();

        return back();
    }
}