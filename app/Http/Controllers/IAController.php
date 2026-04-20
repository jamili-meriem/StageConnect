<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Services\GroqService;
use Illuminate\Http\Request;

class IAController extends Controller
{
    public function __construct(
        private GroqService $groq
    ) {}

    public function genererLettre(Request $request)
    {
        $request->validate([
            'offre_id'    => 'required|exists:offres,id',
            'competences' => 'nullable|string|max:500',
        ]);

        $offre = Offre::with('entreprise')->findOrFail($request->offre_id);
        $user  = auth()->user();

        try {
            $lettre = $this->groq->genererLettreMotivation(
                nomEtudiant:      $user->name,
                titreOffre:       $offre->titre,
                nomEntreprise:    $offre->entreprise->name,
                descriptionOffre: $offre->description,
                competences:      $request->competences ?? ''
            );

            return response()->json([
                'success' => true,
                'lettre'  => $lettre,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération. Réessayez.',
            ], 500);
        }
    }

    public function chatbot(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
        ]);

        try {
            $reponse = $this->groq->conseillerStage(
                question: $request->question,
                contexte: 'L\'étudiant utilise la plateforme StageConnect au Maroc.'
            );

            return response()->json([
                'success' => true,
                'reponse' => $reponse,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur. Réessayez.',
            ], 500);
        }
    }

    public function analyserCV(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:50|max:1000',
            'offre_id'    => 'required|exists:offres,id',
        ]);

        $offre = Offre::findOrFail($request->offre_id);

        try {
            $analyse = $this->groq->analyserCV(
                descriptionCV: $request->description,
                titreOffre:    $offre->titre
            );

            $data = json_decode($analyse, true);

            return response()->json([
                'success' => true,
                'analyse' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur analyse. Réessayez.',
            ], 500);
        }
    }

    public function recommander(Request $request)
    {
        $request->validate([
            'competences' => 'required|string|max:500',
            'domaine'     => 'required|string',
        ]);

        $offres = Offre::active()
                       ->select('id', 'titre', 'domaine', 'lieu')
                       ->get()
                       ->toArray();

        try {
            $resultat = $this->groq->recommanderOffres(
                competences:       $request->competences,
                domaine:           $request->domaine,
                offresDisponibles: $offres
            );

            $data = json_decode($resultat, true);
            $ids  = collect($data['recommandations'])->pluck('id');

            $offresDetaillees = Offre::with('entreprise')
                                     ->whereIn('id', $ids)
                                     ->get();

            return response()->json([
                'success'         => true,
                'recommandations' => $data['recommandations'],
                'offres'          => $offresDetaillees,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur recommandation. Réessayez.',
            ], 500);
        }
    }
}