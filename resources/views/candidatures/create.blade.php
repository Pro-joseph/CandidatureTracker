@extends('layouts.app')
@section('title', 'Nouvelle candidature')
@section('breadcrumb', 'Candidatures / Nouvelle')

@section('content')

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">Nouvelle candidature</h1>
        <p class="page-subtitle">Enregistrez une nouvelle opportunité d'emploi.</p>
    </div>
    <a href="{{ route('candidatures.index') }}" class="btn btn-secondary">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
</div>

<div class="card animate-in stagger-1" style="max-width:760px;">
    <div class="card-header">
        <span class="card-title">Informations de la candidature</span>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('candidatures.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="entreprise">Entreprise <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="entreprise" name="entreprise"
                           class="form-control"
                           value="{{ old('entreprise') }}"
                           placeholder="Ex : Google, BNP Paribas…"
                           required>
                    @error('entreprise')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="poste">Poste visé <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="poste" name="poste"
                           class="form-control"
                           value="{{ old('poste') }}"
                           placeholder="Ex : Développeur Full Stack"
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
                       value="{{ old('url') }}"
                       placeholder="https://www.linkedin.com/jobs/…">
                <p class="form-hint">Optionnel — lien vers l'annonce originale</p>
                @error('url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="statut">Statut <span style="color:var(--danger)">*</span></label>
                    <select id="statut" name="statut" class="form-select" required>
                        <option value="" disabled {{ old('statut') ? '' : 'selected' }}>Choisir un statut</option>
                        @foreach(\App\Models\Candidature::STATUTS as $value => $label)
                            <option value="{{ $value }}" {{ old('statut') === $value ? 'selected' : '' }}>
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
                        <option value="" disabled {{ old('priorite') ? '' : 'selected' }}>Choisir une priorité</option>
                        @foreach(\App\Models\Candidature::PRIORITES as $value => $label)
                            <option value="{{ $value }}" {{ old('priorite') === $value ? 'selected' : '' }}>
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
                       value="{{ old('date_candidature', now()->format('Y-m-d')) }}"
                       required>
                @error('date_candidature')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="notes">Notes libres</label>
                <textarea id="notes" name="notes" class="form-textarea"
                          placeholder="Contact RH, contexte de l'annonce, points clés…">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:4px;">
                <a href="{{ route('candidatures.index') }}" class="btn btn-secondary">Annuler</a>
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
