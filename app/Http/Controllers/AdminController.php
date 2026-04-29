<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use App\Models\Candidature;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $totalUsers        = User::count();
        $totalOffres       = Offre::count();
        $totalCandidatures = Candidature::count();
        $totalEtudiants    = User::where('role', 'etudiant')->count();
        $totalEntreprises  = User::where('role', 'entreprise')->count();
        $totalAdmins       = User::where('role', 'admin')->count();

        $derniersUsers    = User::latest()->take(5)->get();
        $dernieresOffres  = Offre::with('entreprise')->latest()->take(5)->get();

        // Candidatures par statut pour le graphique donut
        $candidaturesParStatut = Candidature::selectRaw('statut, count(*) as total')
                                             ->groupBy('statut')
                                             ->pluck('total', 'statut');

        // Offres par domaine pour le graphique bar
        $offresParDomaine = Offre::selectRaw('domaine, count(*) as total')
                                  ->groupBy('domaine')
                                  ->orderByDesc('total')
                                  ->get();

        // Inscriptions des 6 derniers mois — compatible MySQL ET PostgreSQL
        $isPostgres = config('database.default') === 'pgsql';

        if ($isPostgres) {
            $inscriptionsParMois = User::selectRaw("TO_CHAR(created_at, 'Mon YYYY') as mois, count(*) as total")
                                        ->where('created_at', '>=', now()->subMonths(6))
                                        ->groupByRaw("TO_CHAR(created_at, 'Mon YYYY')")
                                        ->orderBy('created_at')
                                        ->get();
        } else {
            $inscriptionsParMois = User::selectRaw('DATE_FORMAT(created_at, "%b %Y") as mois, count(*) as total')
                                        ->where('created_at', '>=', now()->subMonths(6))
                                        ->groupByRaw('DATE_FORMAT(created_at, "%b %Y")')
                                        ->orderBy('created_at')
                                        ->get();
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalOffres', 'totalCandidatures',
            'totalEtudiants', 'totalEntreprises', 'totalAdmins',
            'derniersUsers', 'dernieresOffres',
            'candidaturesParStatut', 'offresParDomaine',
            'inscriptionsParMois'
        ));
    }

    // Liste tous les utilisateurs
    public function users(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(15);

        return view('admin.users', compact('users', 'search'));
    }

    // Supprime un utilisateur
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors([
                'error' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ]);
        }

        $user->delete();

        return redirect()->route('admin.users')
                         ->with('success', 'Utilisateur supprimé.');
    }

    // Liste toutes les offres
    public function offres(Request $request)
    {
        $search = $request->search;

        $offres = Offre::with('entreprise')
                       ->when($search, function ($query) use ($search) {
                           $query->where('titre', 'like', "%{$search}%")
                                 ->orWhere('lieu', 'like', "%{$search}%");
                       })
                       ->latest()
                       ->paginate(15);

        return view('admin.offres', compact('offres', 'search'));
    }

    // Supprime une offre
    public function destroyOffre(Offre $offre)
    {
        $offre->delete();

        return redirect()->route('admin.offres')
                         ->with('success', 'Offre supprimée.');
    }
}