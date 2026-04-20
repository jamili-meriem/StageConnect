<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    // Dashboard étudiant
    // Appelé quand on visite GET /etudiant/dashboard
    public function dashboard()
    {
        // auth()->user() : récupère l'utilisateur connecté
        $user = auth()->user();

        // Récupère toutes les candidatures de cet étudiant
        // with('offre.entreprise') : charge aussi l'offre et l'entreprise liées
        // pour éviter le problème N+1 (trop de requêtes SQL)
        $candidatures = Candidature::where('user_id', $user->id)
                                   ->with('offre.entreprise')
                                   ->latest() // trie du plus récent au plus ancien
                                   ->get();

        // Compte les candidatures selon leur statut
        $totalCandidatures = $candidatures->count();
        $enAttente = $candidatures->where('statut', 'en_attente')->count();
        $acceptees = $candidatures->where('statut', 'acceptee')->count();

        // Envoie les données à la vue
        // compact() crée un tableau ['candidatures' => $candidatures, ...]
        return view('etudiant.dashboard', compact(
            'candidatures',
            'totalCandidatures',
            'enAttente',
            'acceptees'
        ));
    }

    // Liste des offres disponibles
    // Appelé quand on visite GET /etudiant/offres
    public function offres(Request $request)
    {
        // $request->search : récupère le paramètre ?search= dans l'URL
        $search = $request->search;

        $offres = Offre::active() // scope défini dans le modèle Offre
                       ->with('entreprise') // charge l'entreprise liée
                       ->when($search, function ($query) use ($search) {
                           // when() : applique le filtre seulement si $search n'est pas vide
                           // like '%mot%' : cherche le mot n'importe où dans le texte
                           $query->where('titre', 'like', "%{$search}%")
                                 ->orWhere('domaine', 'like', "%{$search}%")
                                 ->orWhere('lieu', 'like', "%{$search}%");
                       })
                       ->latest()
                       ->paginate(9); // affiche 9 offres par page

        return view('etudiant.offres', compact('offres', 'search'));
    }

    // Détail d'une offre
    // {offre} dans la route → Laravel récupère l'offre automatiquement
    public function showOffre(Offre $offre)
    {
        // load() : charge la relation entreprise sur cet objet
        $offre->load('entreprise');

        return view('etudiant.offre-detail', compact('offre'));
    }

    // Affiche le formulaire de candidature
    public function showCandidature(Offre $offre)
    {
        return view('etudiant.candidature', compact('offre'));
    }

    // Traite l'envoi du formulaire de candidature
    // Appelé quand on soumet POST /etudiant/offres/{offre}/postuler
    public function postuler(Request $request, Offre $offre)
    {
        // validate() : vérifie les données du formulaire
        // Si une règle échoue, Laravel redirige automatiquement avec les erreurs
        $request->validate([
            // required : le champ est obligatoire
            // min:50 : minimum 50 caractères
            'motivation' => 'required|min:50',

            // mimes:pdf : seuls les fichiers PDF sont acceptés
            // max:2048 : maximum 2 Mo (2048 Ko)
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Vérifie que l'étudiant n'a pas déjà postulé à cette offre
        $dejaCandidaté = Candidature::where('user_id', auth()->id())
                                    ->where('offre_id', $offre->id)
                                    ->exists();

        if ($dejaCandidaté) {
            // redirect()->back() : retourne à la page précédente
            // withErrors() : envoie un message d'erreur
            return redirect()->back()->withErrors([
                'cv' => 'Vous avez déjà postulé à cette offre.'
            ]);
        }

        // store('cvs', 'public') : sauvegarde le fichier dans storage/app/public/cvs/
        // retourne le chemin du fichier ex: "cvs/abc123.pdf"
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // Crée la candidature en base de données
        Candidature::create([
            'user_id'    => auth()->id(),
            'offre_id'   => $offre->id,
            'motivation' => $request->motivation,
            'cv_path'    => $cvPath,
            'statut'     => 'en_attente',
        ]);

        // Redirige vers le dashboard avec un message de succès
        // with('success', '...') : message flash (affiché une seule fois)
        return redirect()->route('etudiant.dashboard')
                         ->with('success', 'Votre candidature a été envoyée avec succès !');
    }
}