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

        <form method="POST" action="{{ route('candidatures.store') }}" enctype="multipart/form-data">
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
                <label class="form-label" for="url_offre">URL de l'offre</label>
                <input type="url" id="url_offre" name="url_offre"
                       class="form-control"
                       value="{{ old('url_offre') }}"
                       placeholder="https://www.linkedin.com/jobs/…">
                <p class="form-hint">Optionnel — lien vers l'annonce originale</p>
                @error('url_offre')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="statut">Statut <span style="color:var(--danger)">*</span></label>
                    <select id="statut" name="statut" class="form-select" required>
                        <option value="" disabled {{ old('statut') ? '' : 'selected' }}>Choisir un statut</option>
                        <option value="candidature_envoyee" {{ old('statut') === 'candidature_envoyee' ? 'selected' : '' }}>Candidature envoyée</option>
                        <option value="relance"             {{ old('statut') === 'relance'             ? 'selected' : '' }}>Relance</option>
                        <option value="entretien_planifie"  {{ old('statut') === 'entretien_planifie'  ? 'selected' : '' }}>Entretien planifié</option>
                        <option value="offre_recue"         {{ old('statut') === 'offre_recue'         ? 'selected' : '' }}>Offre reçue</option>
                        <option value="refus"               {{ old('statut') === 'refus'               ? 'selected' : '' }}>Refus</option>
                        <option value="accepte"             {{ old('statut') === 'accepte'             ? 'selected' : '' }}>Accepté</option>
                    </select>
                    @error('statut')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="priorite">Priorité <span style="color:var(--danger)">*</span></label>
                    <select id="priorite" name="priorite" class="form-select" required>
                        <option value="" disabled {{ old('priorite') ? '' : 'selected' }}>Choisir une priorité</option>
                        <option value="haute"   {{ old('priorite') === 'haute'   ? 'selected' : '' }}>Haute</option>
                        <option value="moyenne" {{ old('priorite') === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="basse"   {{ old('priorite') === 'basse'   ? 'selected' : '' }}>Basse</option>
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

            <div class="divider"></div>

            {{-- File attachment (Bonus) --}}
            <div class="form-group">
                <label class="form-label">Pièce jointe</label>
                <label for="fichier" class="file-drop" style="cursor:pointer;">
                    <span>📎</span>
                    <p>Glissez un fichier ou <strong style="color:var(--accent);">parcourez</strong></p>
                    <p style="font-size:12px;margin-top:4px;">CV, lettre de motivation, autre document — max 5 Mo</p>
                    <input type="file" id="fichier" name="fichier"
                           style="display:none;"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           onchange="document.getElementById('file-name').textContent = this.files[0]?.name ?? ''">
                </label>
                <p id="file-name" style="font-size:13px;color:var(--accent);margin-top:6px;"></p>
                @error('fichier')
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
