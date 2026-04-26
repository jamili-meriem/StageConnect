<?php
use App\Http\Controllers\IAController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilController;



// ========== ROUTE PUBLIQUE ==========

Route::get('/', function () {
    return view('welcome');
});

// ========== ROUTES ÉTUDIANT ==========

// middleware(['auth']) : doit être connecté
// middleware(['role:etudiant']) : doit avoir le rôle étudiant
Route::middleware(['auth', 'role:etudiant'])
     ->prefix('etudiant')
     ->name('etudiant.')
     ->group(function () {

    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])
         ->name('dashboard');

    Route::get('/offres', [EtudiantController::class, 'offres'])
         ->name('offres');

    Route::get('/offres/{offre}', [EtudiantController::class, 'showOffre'])
         ->name('offres.show');

    Route::get('/offres/{offre}/postuler', [EtudiantController::class, 'showCandidature'])
         ->name('offres.postuler');

    Route::post('/offres/{offre}/postuler', [EtudiantController::class, 'postuler'])
         ->name('offres.postuler.store');
    Route::get('/recommandations', function() {
    return view('etudiant.recommandations');
})->name('recommandations');
Route::post('/favoris/{offre}/toggle', [EtudiantController::class, 'toggleFavori'])
     ->name('favoris.toggle');

Route::get('/favoris', [EtudiantController::class, 'favoris'])
     ->name('favoris');

Route::get('/profil', [ProfilController::class, 'showEtudiant'])->name('profil');
Route::put('/profil', [ProfilController::class, 'updateEtudiant'])->name('profil.update');
});

// ========== ROUTES ENTREPRISE ==========

Route::middleware(['auth', 'role:entreprise'])
     ->prefix('entreprise')
     ->name('entreprise.')
     ->group(function () {

    Route::get('/dashboard', [EntrepriseController::class, 'dashboard'])
         ->name('dashboard');

    Route::get('/offres/create', [EntrepriseController::class, 'createOffre'])
         ->name('offres.create');

    Route::post('/offres', [EntrepriseController::class, 'storeOffre'])
         ->name('offres.store');

    Route::get('/offres/{offre}/edit', [EntrepriseController::class, 'editOffre'])
         ->name('offres.edit');

    Route::put('/offres/{offre}', [EntrepriseController::class, 'updateOffre'])
         ->name('offres.update');

    Route::delete('/offres/{offre}', [EntrepriseController::class, 'destroyOffre'])
         ->name('offres.destroy');

    Route::get('/offres/{offre}/candidatures', [EntrepriseController::class, 'candidatures'])
         ->name('offres.candidatures');

    Route::get('/candidatures/{candidature}', [EntrepriseController::class, 'showCandidature'])
         ->name('candidatures.show');

    Route::patch('/candidatures/{candidature}/statut', [EntrepriseController::class, 'updateStatut'])
         ->name('candidatures.statut');
         Route::get('/candidatures/{candidature}/evaluer', [EvaluationController::class, 'create'])
     ->name('candidatures.evaluer');
Route::post('/candidatures/{candidature}/evaluer', [EvaluationController::class, 'store'])
     ->name('candidatures.evaluer.store');
     Route::get('/profil', [ProfilController::class, 'showEntreprise'])->name('profil');
Route::put('/profil', [ProfilController::class, 'updateEntreprise'])->name('profil.update');

Route::get('/candidatures/{candidature}/evaluer', [EvaluationController::class, 'create'])
     ->name('candidatures.evaluer');
Route::post('/candidatures/{candidature}/evaluer', [EvaluationController::class, 'store'])
     ->name('candidatures.evaluer.store');
});
// ========== ROUTES IA ==========
Route::middleware(['auth'])->prefix('ia')->name('ia.')->group(function () {
    Route::post('/lettre', [IAController::class, 'genererLettre'])->name('lettre');
    Route::post('/chatbot', [IAController::class, 'chatbot'])->name('chatbot');
    Route::post('/cv', [IAController::class, 'analyserCV'])->name('cv');
    Route::post('/recommander', [IAController::class, 'recommander'])->name('recommander');
});

// ========== ROUTES ADMIN ==========

Route::middleware(['auth', 'role:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
         ->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])
         ->name('users');

    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
         ->name('users.destroy');

    Route::get('/offres', [AdminController::class, 'offres'])
         ->name('offres');

    Route::delete('/offres/{offre}', [AdminController::class, 'destroyOffre'])
         ->name('offres.destroy');

});

// ========== DASHBOARD GÉNÉRAL ==========

// Redirige vers le bon dashboard selon le rôle
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isEtudiant()) {
        return redirect()->route('etudiant.dashboard');
    } elseif ($user->isEntreprise()) {
        return redirect()->route('entreprise.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

})->middleware('auth')->name('dashboard');
use App\Http\Controllers\NotificationController;

// Profil entreprise
Route::middleware(['auth', 'role:entreprise'])->group(function () {
    Route::get('/entreprise/profil', [ProfilController::class, 'showEntreprise'])
         ->name('entreprise.profil');
    Route::put('/entreprise/profil', [ProfilController::class, 'updateEntreprise'])
         ->name('entreprise.profil.update');
});

// Notifications (tous les rôles connectés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
         ->name('notifications.index');
    Route::post('/notifications/{notification}/lire', [NotificationController::class, 'lire'])
         ->name('notifications.lire');
    Route::post('/notifications/lire-tout', [NotificationController::class, 'lireTout'])
         ->name('notifications.lireTout');
});
require __DIR__.'/auth.php';