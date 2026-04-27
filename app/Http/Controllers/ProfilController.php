<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class ProfilController extends Controller
{

// Profil public entreprise
public function publicEntreprise(User $user)
{
    if (!$user->isEntreprise()) abort(404);

    $offres = \App\Models\Offre::where('user_id', $user->id)
                                ->active()
                                ->latest()
                                ->get();

    $evaluations = \App\Models\Evaluation::where('evalue_id', $user->id)
                                          ->with('evaluateur')
                                          ->latest()
                                          ->get();

    return view('profils.entreprise', compact('user', 'offres', 'evaluations'));
}

// Profil public étudiant
public function publicEtudiant(User $user)
{
    if (!$user->isEtudiant()) abort(404);

    // Charge les candidatures avec leurs statuts
    $user->load('candidatures');

    $evaluations = \App\Models\Evaluation::where('evalue_id', $user->id)
                                          ->with('evaluateur')
                                          ->latest()
                                          ->get();

    return view('profils.etudiant', compact('user', 'evaluations'));
}
    // ========== ÉTUDIANT ==========

    public function showEtudiant()
    {
        return view('etudiant.profil');
    }

    public function updateEtudiant(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string',
            'bio'        => 'nullable|string|max:1000',
            'linkedin'   => 'nullable|url',
            'universite' => 'nullable|string',
            'filiere'    => 'nullable|string',
            'niveau'     => 'nullable|string',
            'ville'      => 'nullable|string',
            'avatar'     => 'nullable|image|max:2048',
            'cv'         => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->only([
            'name', 'phone', 'bio', 'linkedin',
            'universite', 'filiere', 'niveau', 'ville',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')
                                      ->store('avatars', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($user->cv_path) {
                Storage::disk('public')->delete($user->cv_path);
            }
            $data['cv_path'] = $request->file('cv')
                                       ->store('cvs', 'public');
        }

        $user->update($data);

        return redirect()->route('etudiant.profil')
                         ->with('success', 'Profil mis à jour avec succès !');
    }

    // ========== ENTREPRISE ==========

    public function showEntreprise()
    {
        return view('entreprise.profil');
    }

    public function updateEntreprise(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'bio'               => 'nullable|string|max:1000',
            'secteur'           => 'nullable|string',
            'taille_entreprise' => 'nullable|string',
            'site_web'          => 'nullable|url',
            'phone'             => 'nullable|string',
            'ville'             => 'nullable|string',
            'adresse'           => 'nullable|string',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'avatar'            => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name', 'bio', 'secteur', 'taille_entreprise',
            'site_web', 'phone', 'ville', 'adresse',
            'latitude', 'longitude',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')
                                      ->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('entreprise.profil')
                         ->with('success', 'Profil mis à jour avec succès !');
    }
}
