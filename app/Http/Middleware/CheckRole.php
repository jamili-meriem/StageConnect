<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // handle() est appelé automatiquement par Laravel
    // avant chaque requête qui utilise ce middleware
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Vérifie que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // $roles contient les rôles autorisés pour cette route
        // ex: ['entreprise'] ou ['admin'] ou ['etudiant', 'admin']
        // in_array vérifie si le rôle de l'utilisateur est dans la liste
        if (!in_array($user->role, $roles)) {

            // abort(403) : page "Accès interdit"
            abort(403, 'Vous n\'avez pas accès à cette page.');
        }

        // next($request) : laisse passer la requête si tout est ok
        return $next($request);
    }
}