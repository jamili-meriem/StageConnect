<?php
use App\Http\Controllers\IAController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\AdminController;

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

require __DIR__.'/auth.php';