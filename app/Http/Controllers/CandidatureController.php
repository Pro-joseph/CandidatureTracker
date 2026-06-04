<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;

class CandidatureController extends Controller
{
    /**
     * Liste paginée des candidatures de l'utilisateur connecté, avec filtrage.
     */
   public function index()
{
    $candidatures = Candidature::where('user_id', auth()->id())
        ->filter(request()->only(['statut', 'priorite']))
        ->with('entretiens:id,candidature_id,date_heure')
        ->withCount('entretiens')
        ->latest()
        ->paginate(15);

    return view('candidatures.index', compact('candidatures'));
}

// public function index() { 
//     $candidatures = Candidature::where('user_id', auth()->id()) 
//     ->filter(request()->only('statut', 'priorite')) 
//     ->withCount('entretiens') ->latest() 
//     ->paginate(15); return view('candidatures.index',
//      compact('candidatures')); 
//      }

    /**
     * Affiche le formulaire de création d'une candidature.
     */
    public function create()
    {
        return view('candidatures.create');
    }

    /**
     * Enregistre une nouvelle candidature.
     */
    public function store(StoreCandidatureRequest $request)
    {
        Candidature::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('candidatures.index');
    }

    /**
     * Affiche le détail d'une candidature avec ses entretiens.
     */
    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);

        $candidature->load('entretiens');

        return view('candidatures.show', compact('candidature'));
    }

    /**
     * Affiche le formulaire d'édition d'une candidature.
     */
    public function edit(Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        return view('candidatures.edit', compact('candidature'));
    }

    /**
     * Met à jour une candidature existante.
     */
    public function update(UpdateCandidatureRequest $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $candidature->update($request->validated());

        return redirect()->route('candidatures.show', $candidature);
    }

    /**
     * Supprime (soft delete) une candidature.
     */
    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);

        $candidature->delete();

        return redirect()->route('candidatures.index');
    }

    /**
     * Archive une candidature (soft delete).
     */
    public function archive(Candidature $candidature)
    {
        $this->authorize('archive', $candidature);

        $candidature->delete();

        return redirect()->route('candidatures.index');
    }

    /**
     * Liste les candidatures archivées (soft deleted).
     */
    public function archives()
    {
        $candidatures = Candidature::onlyTrashed()
            ->where('user_id', auth()->id())
            ->get();

        return view('candidatures.archives', compact('candidatures'));
    }

    /**
     * Restaure une candidature depuis les archives.
     */
    public function restore(int $id)
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $candidature);

        $candidature->restore();

        return redirect()->route('archives.index');
    }

    /**
     * Supprime définitivement une candidature archivée.
     */
    public function forceDelete(int $id)
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $candidature);

        $candidature->forceDelete();

        return redirect()->route('archives.index');
    }
}