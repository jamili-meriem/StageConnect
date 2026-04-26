<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Candidature;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;

class EntrepriseController extends Controller
{
    // Dashboard entreprise
    // Appelé quand on visite GET /entreprise/dashboard
    public function dashboard()
    {
        // auth()->id() : récupère l'id de l'utilisateur connecté
        $userId = auth()->id();

        // Récupère toutes les offres de cette entreprise
        // with('candidatures') : charge aussi les candidatures liées
        $offres = Offre::where('user_id', $userId)
                       ->with('candidatures')
                       ->latest()
                       ->get();

        // Compte les statistiques
        $totalOffres = $offres->count();

        // flatMap() : fusionne toutes les candidatures de toutes les offres
        // en une seule collection pour pouvoir les compter facilement
        $toutesLesCandidatures = $offres->flatMap->candidatures;
        $totalCandidatures = $toutesLesCandidatures->count();
        $enAttente = $toutesLesCandidatures->where('statut', 'en_attente')->count();
        $acceptees = $toutesLesCandidatures->where('statut', 'acceptee')->count();

        return view('entreprise.dashboard', compact(
            'offres',
            'totalOffres',
            'totalCandidatures',
            'enAttente',
            'acceptees'
        ));
    }

    // Affiche le formulaire de création d'offre
    // Appelé quand on visite GET /entreprise/offres/create
    public function createOffre()
    {
        return view('entreprise.offre-create');
    }

    // Sauvegarde la nouvelle offre en base de données
    // Appelé quand on soumet POST /entreprise/offres
   public function storeOffre(Request $request)
{
    $request->validate([
        'titre'       => 'required|min:5|max:255',
        'domaine'     => 'required',
        'lieu'        => 'required',
        'description' => 'required|min:20',
        'duree'       => 'nullable|string',
        'date_limite' => 'nullable|date|after:today',
        'salaire_min' => 'nullable|integer|min:0',
        'salaire_max' => 'nullable|integer|min:0',
        'type_travail'         => 'nullable|in:presentiel,remote,hybride',
        'niveau_requis'        => 'nullable|in:bac,bac+2,bac+3,bac+4,bac+5',
        'nombre_postes'        => 'nullable|integer|min:1',
        'competences_requises' => 'nullable|string',
    ]);

    // Transforme la string de compétences en tableau JSON
    // "PHP, Laravel, MySQL" → ["PHP", "Laravel", "MySQL"]
    $competences = null;
    if ($request->competences_requises) {
        $competences = array_map('trim', explode(',', $request->competences_requises));
    }

    Offre::create([
        'user_id'              => auth()->id(),
        'titre'                => $request->titre,
        'domaine'              => $request->domaine,
        'lieu'                 => $request->lieu,
        'description'          => $request->description,
        'duree'                => $request->duree,
        'date_limite'          => $request->date_limite,
        'salaire_min'          => $request->salaire_min,
        'salaire_max'          => $request->salaire_max,
        'type_travail'         => $request->type_travail ?? 'presentiel',
        'niveau_requis'        => $request->niveau_requis ?? 'bac+3',
        'nombre_postes'        => $request->nombre_postes ?? 1,
        'competences_requises' => $competences,
        'is_active'            => true,
    ]);

    return redirect()->route('entreprise.dashboard')
                     ->with('success', 'Offre publiée avec succès !');
}    // Affiche le formulaire de modification d'une offre
    // Appelé quand on visite GET /entreprise/offres/{offre}/edit
    public function editOffre(Offre $offre)
    {
        // Vérifie que cette offre appartient bien à l'entreprise connectée
        // abort(403) : renvoie une erreur "Accès interdit"
        if ($offre->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier cette offre.');
        }

        return view('entreprise.offre-edit', compact('offre'));
    }

    // Sauvegarde les modifications d'une offre
    // Appelé quand on soumet PUT /entreprise/offres/{offre}
    public function updateOffre(Request $request, Offre $offre)
{
    if ($offre->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'titre'       => 'required|min:5|max:255',
        'domaine'     => 'required',
        'lieu'        => 'required',
        'description' => 'required|min:20',
        'duree'       => 'nullable|string',
        'date_limite' => 'nullable|date',
    ]);

    $offre->update([
        'titre'       => $request->titre,
        'domaine'     => $request->domaine,
        'lieu'        => $request->lieu,
        'description' => $request->description,
        'duree'       => $request->duree,
        'date_limite' => $request->date_limite,
        // Si la checkbox est cochée, $request->is_active = '1'
        // Sinon elle n'est pas envoyée, donc on utilise ?? false
        'is_active'   => $request->is_active ?? false,
    ]);

    return redirect()->route('entreprise.dashboard')
                     ->with('success', 'Offre modifiée avec succès !');
}
    // Supprime une offre
    // Appelé quand on soumet DELETE /entreprise/offres/{offre}
    public function destroyOffre(Offre $offre)
    {
        if ($offre->user_id !== auth()->id()) {
            abort(403);
        }

        // delete() : supprime l'offre de la base de données
        // grâce à onDelete('cascade') dans la migration,
        // toutes les candidatures liées sont supprimées aussi
        $offre->delete();

        return redirect()->route('entreprise.dashboard')
                         ->with('success', 'Offre supprimée.');
    }

    // Liste des candidatures reçues pour une offre
    // Appelé quand on visite GET /entreprise/offres/{offre}/candidatures
    public function candidatures(Offre $offre)
    {
        if ($offre->user_id !== auth()->id()) {
            abort(403);
        }

        // Charge les candidatures avec les infos de l'étudiant
        $candidatures = $offre->candidatures()
                               ->with('etudiant')
                               ->latest()
                               ->get();

        return view('entreprise.candidatures', compact('offre', 'candidatures'));
    }

    // Détail d'une candidature
    // Appelé quand on visite GET /entreprise/candidatures/{candidature}
    public function showCandidature(Candidature $candidature)
    {
        // Vérifie que la candidature concerne une offre de cette entreprise
        if ($candidature->offre->user_id !== auth()->id()) {
            abort(403);
        }

        // load() : charge les relations nécessaires
        $candidature->load('etudiant', 'offre');

        return view('entreprise.candidature-detail', compact('candidature'));
    }

    // Change le statut d'une candidature (acceptée / refusée)
    // Appelé quand on soumet PATCH /entreprise/candidatures/{candidature}/statut
    public function updateStatut(Request $request, Candidature $candidature)
{
    if ($candidature->offre->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'statut' => 'required|in:acceptee,refusee',
    ]);

    $candidature->update(['statut' => $request->statut]);

    // Envoie une notification à l'étudiant
    if ($request->statut === 'acceptee') {
        NotificationHelper::candidatureAcceptee(
            $candidature->user_id,
            $candidature->offre->titre
        );
    } else {
        NotificationHelper::candidatureRefusee(
            $candidature->user_id,
            $candidature->offre->titre
        );
    }

    return redirect()->back()
                     ->with('success', 'Statut mis à jour !');
}
}