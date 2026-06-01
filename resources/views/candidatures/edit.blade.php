@extends('layouts.app')
@section('title', 'Modifier — ' . $candidature->entreprise)
@section('breadcrumb', 'Candidatures / Modifier')

@section('content')

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">Modifier la candidature</h1>
        <p class="page-subtitle">{{ $candidature->entreprise }} — {{ $candidature->poste }}</p>
    </div>
    <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-secondary">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
</div>

<div class="card animate-in stagger-1" style="max-width:760px;">
    <div class="card-header">
        <span class="card-title">Informations</span>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('candidatures.update', $candidature) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="entreprise">Entreprise <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="entreprise" name="entreprise"
                           class="form-control"
                           value="{{ old('entreprise', $candidature->entreprise) }}"
                           required>
                    @error('entreprise')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="poste">Poste visé <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="poste" name="poste"
                           class="form-control"
                           value="{{ old('poste', $candidature->poste) }}"
                           required>
                    @error('poste')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="url">URL de l'offre</label>
                <input type="url" id="url" name="url"
                       class="form-control"
                       value="{{ old('url', $candidature->url) }}"
                       placeholder="https://…">
                @error('url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="statut">Statut <span style="color:var(--danger)">*</span></label>
                    <select id="statut" name="statut" class="form-select" required>
                        @foreach(\App\Models\Candidature::STATUTS as $value => $label)
                            <option value="{{ $value }}" {{ old('statut', $candidature->statut) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('statut')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="priorite">Priorité <span style="color:var(--danger)">*</span></label>
                    <select id="priorite" name="priorite" class="form-select" required>
                        @foreach(\App\Models\Candidature::PRIORITES as $value => $label)
                            <option value="{{ $value }}" {{ old('priorite', $candidature->priorite) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('priorite')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="date_candidature">Date de candidature <span style="color:var(--danger)">*</span></label>
                <input type="date" id="date_candidature" name="date_candidature"
                       class="form-control"
                       value="{{ old('date_candidature', $candidature->date_candidature) }}"
                       required>
                @error('date_candidature')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes libres</label>
                <textarea id="notes" name="notes" class="form-textarea"
                          placeholder="Notes…">{{ old('notes', $candidature->notes) }}</textarea>
                @error('notes')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:4px;">
                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
