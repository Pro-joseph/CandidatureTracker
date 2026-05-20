<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::where('user_id', auth()->id())
            ->filter(request()->only('statut', 'priorite'))
            ->withCount('entretiens')
            ->latest()
            ->paginate(15);

        return view('candidatures.index', compact('candidatures'));
    }

    public function create()
    {
        return view('candidatures.create');
    }

    public function store(StoreCandidatureRequest $request)
    {
        Candidature::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('candidatures.index');
    }

    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);

        $candidature->load('entretiens');

        return view('candidatures.show', compact('candidature'));
    }

    public function edit(Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        return view('candidatures.edit', compact('candidature'));
    }

    public function update(UpdateCandidatureRequest $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $candidature->update($request->validated());

        return redirect()->route('candidatures.show', $candidature);
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);

        $candidature->delete(); // soft delete

        return redirect()->route('candidatures.index');
    }
    
        public function archive(Candidature $candidature)
    {
        $this->authorize('archive', $candidature);

        $candidature->delete();

        return redirect()->route('candidatures.index');
    }

    public function archives()
    {
        $candidatures = Candidature::onlyTrashed()
            ->where('user_id', auth()->id())
            ->get();

        return view('candidatures.archives', compact('candidatures'));
    }

    public function restore($id)
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $candidature);

        $candidature->restore();

        return redirect()->route('archives.index');
    }

    public function forceDelete($id)
    {
        $candidature = Candidature::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $candidature);

        $candidature->forceDelete();

        return redirect()->route('archives.index');
    }
}