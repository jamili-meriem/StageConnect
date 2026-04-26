<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;
use App\Models\Candidature;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    // Appelé quand on visite GET /admin/dashboard
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

    // Inscriptions des 6 derniers mois pour le graphique line
    $inscriptionsParMois = User::selectRaw('DATE_FORMAT(created_at, "%b %Y") as mois, count(*) as total')
                                ->where('created_at', '>=', now()->subMonths(6))
                                ->groupByRaw('DATE_FORMAT(created_at, "%b %Y")')
                                ->orderBy('created_at')
                                ->get();

    return view('admin.dashboard', compact(
        'totalUsers', 'totalOffres', 'totalCandidatures',
        'totalEtudiants', 'totalEntreprises', 'totalAdmins',
        'derniersUsers', 'dernieresOffres',
        'candidaturesParStatut', 'offresParDomaine',
        'inscriptionsParMois'
    ));
}

    // Liste tous les utilisateurs
    // Appelé quand on visite GET /admin/users
    public function users(Request $request)
    {
        $search = $request->search;

        // paginate(15) : affiche 15 utilisateurs par page
        // Laravel gère automatiquement la pagination
        $users = User::when($search, function ($query) use ($search) {
                        // Cherche par nom ou email
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(15);

        return view('admin.users', compact('users', 'search'));
    }

    // Supprime un utilisateur
    // Appelé quand on soumet DELETE /admin/users/{user}
    public function destroyUser(User $user)
    {
        // Empêche l'admin de se supprimer lui-même
        // auth()->id() : id de l'admin connecté
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors([
                'error' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ]);
        }

        // delete() supprime l'utilisateur
        // grâce à onDelete('cascade') dans les migrations,
        // ses offres et candidatures sont supprimées aussi
        $user->delete();

        return redirect()->route('admin.users')
                         ->with('success', 'Utilisateur supprimé.');
    }

    // Liste toutes les offres
    // Appelé quand on visite GET /admin/offres
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

    // Supprime une offre (admin peut supprimer n'importe quelle offre)
    // Appelé quand on soumet DELETE /admin/offres/{offre}
    public function destroyOffre(Offre $offre)
    {
        $offre->delete();

        return redirect()->route('admin.offres')
                         ->with('success', 'Offre supprimée.');
    }
}