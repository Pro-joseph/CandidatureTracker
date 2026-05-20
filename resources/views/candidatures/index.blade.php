@extends('layouts.app')
@section('title', 'Mes candidatures')
@section('breadcrumb', 'Candidatures')

@section('content')

    <div class="page-header animate-in">
        <div>
            <h1 class="page-title">Mes candidatures</h1>
            <p class="page-subtitle">{{ $candidatures->total() }} candidature(s) active(s)</p>
        </div>
        <a href="{{ route('candidatures.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle candidature
        </a>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('candidatures.index') }}" class="filter-bar animate-in stagger-1">
        <label>Filtrer par :</label>

        <select name="statut" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les statuts</option>
            @foreach (\App\Models\Candidature::STATUTS as $value => $label)
                <option value="{{ $value }}" {{ request('statut') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <select name="priorite" class="form-select" onchange="this.form.submit()">
            <option value="">Toutes les priorités</option>
            @foreach (\App\Models\Candidature::PRIORITES as $value => $label)
                <option value="{{ $value }}" {{ request('priorite') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @if (request('statut') || request('priorite'))
            <a href="{{ route('candidatures.index') }}" class="btn btn-secondary btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Réinitialiser
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="card animate-in stagger-2">
        @forelse($candidatures as $candidature)
            @if ($loop->first)
                <div class="table-wrapper" style="border:none;border-radius:0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Entreprise / Poste</th>
                                <th>Statut</th>
                                <th>Priorité</th>
                                <th>Date</th>
                                <th>Entretiens</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

            <tr>
                <td>
                    <div class="td-primary">{{ $candidature->entreprise }}</div>
                    <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">{{ $candidature->poste }}</div>
                </td>
                <td>@include('components.badge-statut', ['statut' => $candidature->statut])</td>
                <td>@include('components.badge-priorite', ['priorite' => $candidature->priorite])</td>
                <td style="white-space:nowrap;">
                    {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</td>
                <td>
                    <span style="font-family:'Syne',sans-serif;font-weight:600;color:var(--text-primary);">
                        {{ $candidature->entretiens_count }}
                    </span>
                    <span style="font-size:12px;color:var(--text-muted);"> entretien(s)</span>
                </td>
                <td style="white-space:nowrap;">
                    <div style="display:flex;align-items:center;gap:6px;">
                        <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-secondary btn-sm btn-icon"
                            title="Voir">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('candidatures.edit', $candidature) }}" class="btn btn-secondary btn-sm btn-icon"
                            title="Modifier">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        {{-- Archive --}}
                        <form method="POST" action="{{ route('candidatures.archive', $candidature) }}"
                            onsubmit="return confirm('Archiver cette candidature ?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-sm btn-icon" title="Archiver">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            @if ($loop->last)
                </tbody>
                </table>
    </div>
    @endif
@empty
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <div class="empty-title">Aucune candidature trouvée</div>
        <div class="empty-desc">
            @if (request('statut') || request('priorite'))
                Aucun résultat pour ces filtres. Essayez d'autres critères.
            @else
                Commencez dès maintenant en ajoutant votre première candidature.
            @endif
        </div>
        @if (!request('statut') && !request('priorite'))
            <a href="{{ route('candidatures.create') }}" class="btn btn-primary">
                Ajouter une candidature
            </a>
        @endif
    </div>
    @endforelse
    </div>

    {{-- Pagination --}}
    @if ($candidatures->hasPages())
        <div style="margin-top:20px;display:flex;justify-content:center;">
            {{ $candidatures->withQueryString()->links() }}
        </div>
    @endif

@endsection
