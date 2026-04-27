<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — StageConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:var(--bg-secondary);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px 0;">

<div style="width:100%;max-width:460px;padding:24px;">

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
            Créer un compte
        </h1>
        <p style="font-size:13px;color:var(--text-secondary);margin-bottom:28px;">
            Rejoignez la plateforme StageConnect
        </p>

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px;margin-bottom:20px;">
            @foreach($errors->all() as $error)
            <p style="font-size:13px;color:#dc2626;">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nom --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    Nom complet
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       required autofocus
                       placeholder="Votre nom"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    Adresse email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       required
                       placeholder="vous@exemple.com"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            {{-- Rôle --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:10px;">
                    Je suis
                </label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <label style="cursor:pointer;">
                        <input type="radio" name="role" value="etudiant"
                               {{ old('role') == 'etudiant' ? 'checked' : '' }}
                               style="display:none;"
                               onchange="selectRole(this)">
                        <div id="role-etudiant"
                             onclick="document.querySelector('[name=role][value=etudiant]').checked=true;selectRole(document.querySelector('[name=role][value=etudiant]'))"
                             style="border:2px solid var(--border-color);border-radius:12px;padding:16px;text-align:center;cursor:pointer;transition:all 0.2s;{{ old('role') == 'etudiant' ? 'border-color:#3b82f6;background:#eff6ff;' : '' }}">
                            <div style="width:40px;height:40px;background:{{ old('role') == 'etudiant' ? '#3b82f6' : 'var(--bg-secondary)' }};border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ old('role') == 'etudiant' ? 'white' : 'currentColor' }}" stroke-width="2">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:600;color:var(--text-primary);">Étudiant</p>
                            <p style="font-size:11px;color:var(--text-secondary);margin-top:2px;">Je cherche un stage</p>
                        </div>
                    </label>
                    <label style="cursor:pointer;">
                        <input type="radio" name="role" value="entreprise"
                               {{ old('role') == 'entreprise' ? 'checked' : '' }}
                               style="display:none;"
                               onchange="selectRole(this)">
                        <div id="role-entreprise"
                             onclick="document.querySelector('[name=role][value=entreprise]').checked=true;selectRole(document.querySelector('[name=role][value=entreprise]'))"
                             style="border:2px solid var(--border-color);border-radius:12px;padding:16px;text-align:center;cursor:pointer;transition:all 0.2s;{{ old('role') == 'entreprise' ? 'border-color:#3b82f6;background:#eff6ff;' : '' }}">
                            <div style="width:40px;height:40px;background:{{ old('role') == 'entreprise' ? '#3b82f6' : 'var(--bg-secondary)' }};border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ old('role') == 'entreprise' ? 'white' : 'currentColor' }}" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            </div>
                            <p style="font-size:13px;font-weight:600;color:var(--text-primary);">Entreprise</p>
                            <p style="font-size:11px;color:var(--text-secondary);margin-top:2px;">Je publie des stages</p>
                        </div>
                    </label>
                </div>
                @error('role')
                <p style="font-size:12px;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Mot de passe --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    Mot de passe
                </label>
                <input type="password" name="password"
                       required
                       placeholder="Minimum 8 caractères"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            {{-- Confirmation --}}
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    Confirmer le mot de passe
                </label>
                <input type="password" name="password_confirmation"
                       required
                       placeholder="Répétez votre mot de passe"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:11px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='var(--border-color)'">
            </div>

            <button type="submit"
                    style="width:100%;height:44px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(59,130,246,0.3);">
                Créer mon compte
            </button>

        </form>
    </div>

    <p style="text-align:center;font-size:13px;color:var(--text-secondary);margin-top:20px;">
        Déjà un compte ?
        <a href="{{ route('login') }}"
           style="color:#3b82f6;font-weight:500;text-decoration:none;">
            Se connecter
        </a>
    </p>

</div>

<script>
const t = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', t);

function selectRole(input) {
    ['etudiant', 'entreprise'].forEach(role => {
        const div = document.getElementById('role-' + role);
        const icon = div.querySelector('div');
        const svg = div.querySelector('svg');
        if (input.value === role) {
            div.style.borderColor = '#3b82f6';
            div.style.background = '#eff6ff';
            icon.style.background = '#3b82f6';
            svg.setAttribute('stroke', 'white');
        } else {
            div.style.borderColor = 'var(--border-color)';
            div.style.background = 'transparent';
            icon.style.background = 'var(--bg-secondary)';
            svg.setAttribute('stroke', 'currentColor');
        }
    });
}
</script>

</body>
</html>