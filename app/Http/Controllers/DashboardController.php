<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalActives = Candidature::where('user_id', $userId)->count();
        $entretiensAVenir = Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $userId))
            ->where('date_heure', '>=', now())
            ->count();
        $offresRecues = Candidature::where('user_id', $userId)
            ->where('statut', 'offer_received')
            ->count();
        $totalArchives = Candidature::onlyTrashed()
            ->where('user_id', $userId)
            ->count();

        $recentCandidatures = Candidature::where('user_id', $userId)
            ->with('entretiens')
            ->latest()
            ->take(5)
            ->get();

        $prochainsEntretiens = Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $userId))
            ->with('candidature')
            ->where('date_heure', '>=', now())
            ->orderBy('date_heure')
            ->take(5)
            ->get();

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
