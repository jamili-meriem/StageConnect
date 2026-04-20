<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validation avec le champ role ajouté
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // in:etudiant,entreprise : seuls ces deux rôles sont autorisés à l'inscription
        // l'admin ne peut être créé que manuellement via le seeder
        'role'     => ['required', 'in:etudiant,entreprise'],
    ]);

    // Crée l'utilisateur avec le rôle choisi
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Redirige vers le dashboard général
    // qui redirige ensuite vers le bon dashboard selon le rôle
    return redirect(route('dashboard', absolute: false));
}
}
