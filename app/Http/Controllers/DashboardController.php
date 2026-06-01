<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques de l'utilisateur.
     */
    public function index()
    {
        $userId = auth()->id();

        // Nombre total de candidatures actives (non archivées)
        $totalActives = Candidature::where('user_id', $userId)->count();

        // Nombre d'entretiens à venir (date_heure >= maintenant)
        $entretiensAVenir = Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $userId))
            ->where('date_heure', '>=', now())
            ->count();

        // Nombre de candidatures avec offre reçue
        $offresRecues = Candidature::where('user_id', $userId)
            ->where('statut', 'offer_received')
            ->count();

        // Nombre de candidatures archivées (soft deleted)
        $totalArchives = Candidature::onlyTrashed()
            ->where('user_id', $userId)
            ->count();

        // 5 dernières candidatures
        $recentCandidatures = Candidature::where('user_id', $userId)
            ->with('entretiens')
            ->latest()
            ->take(5)
            ->get();

        // 5 prochains entretiens à venir
        $prochainsEntretiens = Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $userId))
            ->with('candidature')
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->take(5)
            ->get();

        // Répartition des candidatures par statut (pour graphique)
        $repartitionStatuts = Candidature::where('user_id', $userId)
            ->select('statut', DB::raw('count(*) as count'))
            ->groupBy('statut')
            ->pluck('count', 'statut');

        return view('dashboard', compact(
            'totalActives',
            'entretiensAVenir',
            'offresRecues',
            'totalArchives',
            'recentCandidatures',
            'prochainsEntretiens',
            'repartitionStatuts',
        ));
    }
}
