@extends('layouts.app')
@section('title', $candidature->entreprise . ' — ' . $candidature->poste)
@section('breadcrumb', 'Candidatures / ' . $candidature->entreprise)

@section('content')

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">{{ $candidature->entreprise }}</h1>
        <p class="page-subtitle">{{ $candidature->poste }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('candidatures.index') }}" class="btn btn-secondary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
        <a href="{{ route('candidatures.edit', $candidature) }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
        </a>
        <form method="POST" action="{{ route('candidatures.archive', $candidature) }}"
              onsubmit="return confirm('Archiver cette candidature ?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
                Archiver
            </button>
        </form>
    </div>
</div>

{{-- Meta Card --}}
<div class="card animate-in stagger-1">
    <div class="card-body">
        <div class="meta-grid">
            <div class="meta-item">
                <span class="meta-label">Statut</span>
                <div class="meta-value">
                    @include('components.badge-statut', ['statut' => $candidature->statut])
                </div>
            </div>
            <div class="meta-item">
                <span class="meta-label">Priorité</span>
                <div class="meta-value">
                    @include('components.badge-priorite', ['priorite' => $candidature->priorite])
                </div>
            </div>
            <div class="meta-item">
                <span class="meta-label">Date de candidature</span>
                <div class="meta-value">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</div>
            </div>
            @if($candidature->url)
                <div class="meta-item">
                    <span class="meta-label">Lien offre</span>
                    <div class="meta-value">
                        <a href="{{ $candidature->url }}" target="_blank" style="color:var(--accent);">Voir l'annonce &nearr;</a>
                    </div>
                </div>
            @endif
        </div>

        @if($candidature->notes)
            <div class="divider"></div>
            <div>
                <span class="meta-label" style="display:block;margin-bottom:8px;">Notes</span>
                <div style="font-size:14px;color:var(--text-secondary);line-height:1.7;white-space:pre-wrap;">{{ $candidature->notes }}</div>
            </div>
        @endif
    </div>
</div>

{{-- Entretiens --}}
<div class="card animate-in stagger-2" style="margin-top:20px;">
    <div class="card-header">
        <span class="card-title">Entretiens ({{ $candidature->entretiens->count() }})</span>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('new-entretien').classList.toggle('hidden')">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter
        </button>
    </div>

    <div id="new-entretien" class="hidden" style="padding:20px 24px;border-bottom:1px solid var(--border);">
        <form method="POST" action="{{ route('entretiens.store', $candidature) }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="type">Type</label>
                    <select name="type" class="form-select" required>
                        @foreach(\App\Models\Entretien::TYPES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="date_heure">Date & heure</label>
                    <input type="datetime-local" name="date_heure" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" class="form-textarea" placeholder="Infos sur l'entretien…"></textarea>
            </div>
            <input type="hidden" name="resultat" value="pending">
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>

    @forelse($candidature->entretiens as $entretien)
        <div style="padding:16px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;">
            <div>
                <div style="font-size:14px;font-weight:500;color:var(--text-primary);">
                    {{ $entretien->type_label }}
                </div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">
                    {{ \Carbon\Carbon::parse($entretien->date_heure)->format('d/m/Y à H:i') }}
                </div>
                @if($entretien->notes)
                    <div style="font-size:13px;color:var(--text-secondary);margin-top:4px;">{{ $entretien->notes }}</div>
                @endif
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                @php
                    $resultatMap = ['pending' => ['badge-neutre', 'En attente'], 'positive' => ['badge-offre', 'Positif'], 'negative' => ['badge-refus', 'Négatif']];
                    $r = $resultatMap[$entretien->resultat] ?? ['badge-neutre', $entretien->resultat];
                @endphp
                <span class="badge {{ $r[0] }}">{{ $r[1] }}</span>
                <form method="POST" action="{{ route('entretiens.destroy', $entretien) }}"
                      onsubmit="return confirm('Supprimer cet entretien ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Supprimer">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div style="padding:40px;text-align:center;">
            <div style="font-size:24px;opacity:.3;">🗓️</div>
            <div style="font-size:14px;color:var(--text-muted);margin-top:8px;">Aucun entretien pour le moment</div>
        </div>
    @endforelse
</div>

<style>
    .hidden { display: none; }
</style>

@endsection
