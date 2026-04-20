<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GroqService
{
    private string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->model  = config('services.groq.model');
    }

    private function call(string $prompt, int $maxTokens = 1000): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($this->apiUrl, [
            'model'      => $this->model,
            'max_tokens' => $maxTokens,
            'messages'   => [
                [
                    'role'    => 'user',
                    'content' => $prompt,
                ]
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('Erreur API Groq : ' . $response->body());
        }

        return $response->json('choices.0.message.content');
    }

    public function genererLettreMotivation(
        string $nomEtudiant,
        string $titreOffre,
        string $nomEntreprise,
        string $descriptionOffre,
        string $competences = ''
    ): string {
        $prompt = "Tu es un expert en rédaction de lettres de motivation professionnelles.

Génère une lettre de motivation en français pour :
- Étudiant : {$nomEtudiant}
- Poste : {$titreOffre}
- Entreprise : {$nomEntreprise}
- Description du stage : {$descriptionOffre}
- Compétences de l'étudiant : {$competences}

La lettre doit être :
- Professionnelle et personnalisée
- Entre 200 et 300 mots
- Structurée avec introduction, développement et conclusion
- Sans formule de politesse finale

Génère UNIQUEMENT la lettre, sans commentaires.";

        return $this->call($prompt, 800);
    }

    public function conseillerStage(string $question, string $contexte = ''): string
    {
        $prompt = "Tu es un conseiller expert en stages professionnels au Maroc.
Tu aides les étudiants à trouver et décrocher des stages.

{$contexte}

Question de l'étudiant : {$question}

Réponds de façon claire, pratique et encourageante en français.
Maximum 150 mots.";

        return $this->call($prompt, 400);
    }

    public function analyserCV(string $descriptionCV, string $titreOffre): string
    {
        $prompt = "Tu es un expert RH qui analyse des CV pour des stages.

Offre ciblée : {$titreOffre}
Description du profil du candidat : {$descriptionCV}

Donne une analyse structurée en JSON avec exactement ce format :
{
  \"score\": 85,
  \"points_forts\": [\"point 1\", \"point 2\", \"point 3\"],
  \"points_ameliorer\": [\"point 1\", \"point 2\"],
  \"conseil\": \"Un conseil personnalisé en une phrase\"
}

Réponds UNIQUEMENT avec le JSON, rien d'autre.";

       $resultat = $this->call($prompt, 400);
return $this->nettoyerJSON($resultat);
    }
    // Nettoie la réponse de l'IA
// L'IA entoure parfois le JSON de ```json ... ```
// ce qui empêche json_decode() de fonctionner
private function nettoyerJSON(string $texte): string
{
    // Supprime les balises markdown ```json ou ```
    $texte = preg_replace('/```json\s*/i', '', $texte);
    $texte = preg_replace('/```\s*/i', '', $texte);

    // Supprime les espaces au début et à la fin
    $texte = trim($texte);

    return $texte;
}

    public function recommanderOffres(
        string $competences,
        string $domaine,
        array $offresDisponibles
    ): string {
        $offresTexte = collect($offresDisponibles)
            ->map(fn($o) => "- ID:{$o['id']} | {$o['titre']} | {$o['domaine']} | {$o['lieu']}")
            ->join("\n");

        $prompt = "Tu es un conseiller en orientation professionnelle.

Profil étudiant :
- Compétences : {$competences}
- Domaine préféré : {$domaine}

Offres disponibles :
{$offresTexte}

Recommande les 3 meilleures offres pour ce profil.
Réponds UNIQUEMENT en JSON avec ce format :
{
  \"recommandations\": [
    {\"id\": 1, \"raison\": \"Pourquoi cette offre\"},
    {\"id\": 2, \"raison\": \"Pourquoi cette offre\"},
    {\"id\": 3, \"raison\": \"Pourquoi cette offre\"}
  ]
}";

       $resultat = $this->call($prompt, 500);

// Nettoie le JSON avant de le retourner
return $this->nettoyerJSON($resultat);
    }
}