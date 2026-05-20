@extends('layouts.app')
@section('title', 'Archives')
@section('breadcrumb', 'Archives')

@section('content')

<div class="page-header animate-in">
    <div>
        <h1 class="page-title">Archives</h1>
        <p class="page-subtitle">{{ $candidatures->count() }} candidature(s) archivée(s)</p>
    </div>
    <a href="{{ route('candidatures.index') }}" class="btn btn-secondary">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Candidatures actives
    </a>
</div>

<div class="card animate-in stagger-1">
    @forelse($candidatures as $candidature)
        @if($loop->first)
            <div class="table-wrapper" style="border:none;border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Entreprise / Poste</th>
                            <th>Statut</th>
                            <th>Archivée le</th>
                            <th></th>
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
                            <td style="white-space:nowrap;">
                                {{ $candidature->deleted_at ? \Carbon\Carbon::parse($candidature->deleted_at)->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;">
                                <form method="POST" action="{{ route('candidatures.restore', $candidature->id) }}"
                                      onsubmit="return confirm('Restaurer cette candidature ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Restaurer
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('candidatures.force-delete', $candidature->id) }}"
                                      onsubmit="return confirm('Supprimer définitivement ? Cette action est irréversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>

        @if($loop->last)
                    </tbody>
                </table>
            </div>
        @endif
    @empty
        <div class="empty-state">
            <div class="empty-icon">🗂️</div>
            <div class="empty-title">Aucune archive</div>
            <div class="empty-desc">Les candidatures que vous archivez apparaîtront ici.</div>
        </div>
    @endforelse
</div>

@endsection
