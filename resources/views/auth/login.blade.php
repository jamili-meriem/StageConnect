<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — StageConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:var(--bg-secondary);min-height:100vh;display:flex;align-items:center;justify-content:center;">

<div style="width:100%;max-width:420px;padding:24px;">

    {{-- Logo --}}
    <div style="text-align:center;margin-bottom:32px;">
        <a href="/">
            <img src="{{ asset('images/logo.svg') }}"
                 alt="StageConnect"
                 style="height:44px;width:auto;">
        </a>
    </div>

    {{-- Carte --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:20px;padding:36px;box-shadow:0 4px 24px rgba(0,0,0,0.06);">

        <h1 style="font-size:22px;font-weight:700;color:var(--text-primary);margin-bottom:6px;">
            Bon retour !
        </h1>
        <p style="font-size:13px;color:var(--text-secondary);margin-bottom:28px;">
            Connectez-vous à votre compte StageConnect
        </p>

        {{-- Erreurs --}}
        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px;margin-bottom:20px;">
            @foreach($errors->all() as $error)
            <p style="font-size:13px;color:#dc2626;">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    Adresse email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       required autofocus
                       placeholder="vous@exemple.com"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            {{-- Mot de passe --}}
            <div style="margin-bottom:20px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                    <label style="font-size:13px;font-weight:500;color:var(--text-primary);">
                        Mot de passe
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       style="font-size:12px;color:#3b82f6;text-decoration:none;">
                        Mot de passe oublié ?
                    </a>
                    @endif
                </div>
                <input type="password" name="password"
                       required
                       placeholder="••••••••"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            {{-- Remember me --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;">
                <input type="checkbox" name="remember" id="remember"
                       style="width:16px;height:16px;accent-color:#3b82f6;cursor:pointer;">
                <label for="remember" style="font-size:13px;color:var(--text-secondary);cursor:pointer;">
                    Se souvenir de moi
                </label>
            </div>

            {{-- Bouton connexion --}}
            <button type="submit"
                    style="width:100%;height:44px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(59,130,246,0.3);transition:all 0.2s;"
                    onmouseover="this.style.opacity='0.9'"
                    onmouseout="this.style.opacity='1'">
                Se connecter
            </button>

        </form>

    </div>

    {{-- Lien inscription --}}
    <p style="text-align:center;font-size:13px;color:var(--text-secondary);margin-top:20px;">
        Pas encore de compte ?
        <a href="{{ route('register') }}"
           style="color:#3b82f6;font-weight:500;text-decoration:none;">
            Créer un compte
        </a>
    </p>

</div>

<script>
const t = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', t);
</script>

</body>
</html>