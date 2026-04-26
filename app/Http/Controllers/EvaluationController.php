<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Evaluation;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function create(Candidature $candidature)
    {
        if ($candidature->offre->user_id !== auth()->id()) {
            abort(403);
        }

        if ($candidature->statut !== 'acceptee') {
            return redirect()->back()
                             ->withErrors(['error' => 'Vous ne pouvez évaluer que les stagiaires acceptés.']);
        }

        $evaluation = Evaluation::where('candidature_id', $candidature->id)
                                 ->where('evaluateur_id', auth()->id())
                                 ->first();

        $candidature->load('etudiant', 'offre');

        return view('entreprise.evaluation', compact('candidature', 'evaluation'));
    }

    public function store(Request $request, Candidature $candidature)
    {
        if ($candidature->offre->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Evaluation::updateOrCreate(
            [
                'candidature_id' => $candidature->id,
                'evaluateur_id'  => auth()->id(),
                'type'           => 'entreprise_evalue',
            ],
            [
                'evalue_id'   => $candidature->user_id,
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
            ]
        );

        NotificationHelper::envoyer(
            userId:  $candidature->user_id,
            titre:   'Nouvelle évaluation reçue ⭐',
            message: auth()->user()->name . ' vous a évalué ' . $request->note . '/5 pour votre stage.',
            type:    'success',
            lien:    '/etudiant/dashboard'
        );

        return redirect()->route('entreprise.candidatures.show', $candidature->id)
                         ->with('success', 'Évaluation soumise avec succès !');
    }
}