@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('breadcrumb', 'Tableau de bord')

@section('content')

{{-- Stats Row --}}
<div class="stats-grid animate-in">
    <div class="stat-card stagger-1 animate-in">
        <span class="stat-label">Total actives</span>
        <span class="stat-value">{{ $totalActives }}</span>
        <span class="stat-sub">candidatures en cours</span>
    </div>
    <div class="stat-card stagger-2 animate-in">
        <span class="stat-label">Entretiens planifiés</span>
        <span class="stat-value" style="color:var(--warning);">{{ $entretiensAVenir }}</span>
        <span class="stat-sub">à venir</span>
    </div>
    <div class="stat-card stagger-3 animate-in">
        <span class="stat-label">Offres reçues</span>
        <span class="stat-value" style="color:var(--success);">{{ $offresRecues }}</span>
        <span class="stat-sub">propositions</span>
    </div>
    <div class="stat-card stagger-4 animate-in">
        <span class="stat-label">Archivées</span>
        <span class="stat-value" style="color:var(--text-muted);">{{ $totalArchives }}</span>
        <span class="stat-sub">candidatures terminées</span>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

    {{-- Recent Candidatures --}}
    <div class="card animate-in stagger-2">
        <div class="card-header">
            <span class="card-title">Candidatures récentes</span>
            <a href="{{ route('candidatures.index') }}" class="btn btn-secondary btn-sm">Voir tout</a>
        </div>

        @forelse($recentCandidatures as $candidature)
            <div style="padding:14px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:14px;transition:background .15s;"
                 onmouseover="this.style.background='var(--bg-raised)'" onmouseout="this.style.background='transparent'">
                <div style="width:40px;height:40px;border-radius:10px;background:var(--bg-overlay);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                    🏢
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:500;color:var(--text-primary);font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $candidature->entreprise }}
                    </div>
                    <div style="font-size:13px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $candidature->poste }}
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
                    @include('components.badge-statut', ['statut' => $candidature->statut])
                    <a href="{{ route('candidatures.show', $candidature) }}" style="color:var(--text-muted);transition:color .15s;"
                       onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-muted)'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <div class="empty-title">Aucune candidature</div>
                <div class="empty-desc">Commencez par ajouter votre première candidature.</div>
                <a href="{{ route('candidatures.create') }}" class="btn btn-primary">Ajouter une candidature</a>
            </div>
        @endforelse
    </div>

    {{-- Sidebar widgets --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Upcoming interviews --}}
        <div class="card animate-in stagger-3">
            <div class="card-header">
                <span class="card-title">Entretiens à venir</span>
            </div>
            @forelse($prochainsEntretiens as $entretien)
                <div style="padding:14px 20px;border-bottom:1px solid var(--border);">
                    <div style="font-size:13px;font-weight:500;color:var(--text-primary);">
                        {{ $entretien->candidature->entreprise }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                        {{ $entretien->type_label }} — {{ \Carbon\Carbon::parse($entretien->date_heure)->format('d/m/Y à H:i') }}
                    </div>
                </div>
            @empty
                <div style="padding:24px;text-align:center;">
                    <div style="font-size:24px;opacity:.3;margin-bottom:8px;">🗓️</div>
                    <div style="font-size:13px;color:var(--text-muted);">Aucun entretien planifié</div>
                </div>
            @endforelse
        </div>

        {{-- Status breakdown --}}
        <div class="card animate-in stagger-4">
            <div class="card-header">
                <span class="card-title">Répartition</span>
            </div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                @foreach($repartitionStatuts as $statut => $count)
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                        @include('components.badge-statut', ['statut' => $statut])
                        <span style="font-family:'Syne',sans-serif;font-weight:600;font-size:14px;color:var(--text-primary);">
                            {{ $count }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection
