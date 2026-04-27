<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Plateforme de stages</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { transition: background-color 0.3s ease, border-color 0.3s ease, color 0.2s ease; }
    </style>
</head>
<body style="background-color: var(--bg-secondary); color: var(--text-primary);">

    {{-- Navbar --}}
   <nav class="nav-blur sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6" style="height:64px;display:flex;align-items:center;justify-content:space-between;">

        {{-- Logo --}}
        <a href="/" style="display:flex;align-items:center;text-decoration:none;flex-shrink:0;">
            <img src="{{ asset('images/logo.svg') }}"
                 alt="StageConnect"
                 style="height:36px;width:auto;">
        </a>

        {{-- Navigation droite --}}
        <div style="display:flex;align-items:center;gap:8px;">
            @auth

                {{-- Badge rôle --}}
                @if(auth()->user()->isEtudiant())
                    <span style="font-size:11px;font-weight:600;color:#1d4ed8;background:#eff6ff;border:1px solid #bfdbfe;padding:4px 10px;border-radius:6px;letter-spacing:0.3px;">
                        Étudiant
                    </span>
                @elseif(auth()->user()->isEntreprise())
                    <span style="font-size:11px;font-weight:600;color:#6d28d9;background:#f5f3ff;border:1px solid #ddd6fe;padding:4px 10px;border-radius:6px;letter-spacing:0.3px;">
                        Entreprise
                    </span>
                @else
                    <span style="font-size:11px;font-weight:600;color:#374151;background:#f9fafb;border:1px solid #e5e7eb;padding:4px 10px;border-radius:6px;letter-spacing:0.3px;">
                        Admin
                    </span>
                @endif

                {{-- Nom utilisateur --}}
                <span style="font-size:13px;font-weight:500;color:var(--text-primary);padding:0 4px;">
                    {{ auth()->user()->name }}
                </span>

                {{-- Notifications --}}
                @php
                    $nbNotifs = \App\Models\NotificationApp::where('user_id', auth()->id())
                                                           ->whereNull('lue_at')
                                                           ->count();
                @endphp
               <a href="{{ route('notifications.index') }}"
   style="position:relative;width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s;"
   onmouseover="this.style.borderColor='#3b82f6'"
   onmouseout="this.style.borderColor='var(--border-color)'"
   onclick="setTimeout(() => document.getElementById('notif-badge')?.remove(), 100)">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-secondary)">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
    </svg>
    @if($nbNotifs > 0)
    <span id="notif-badge"
          style="position:absolute;top:-5px;right:-5px;background:#ef4444;color:white;font-size:10px;font-weight:700;width:17px;height:17px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid white;">
        {{ $nbNotifs > 9 ? '9+' : $nbNotifs }}
    </span>
    @endif
</a>

                {{-- Bouton mode sombre --}}
                <button onclick="toggleTheme()"
                        id="theme-btn"
                        style="width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                        onmouseover="this.style.borderColor='#3b82f6'"
                        onmouseout="this.style.borderColor='var(--border-color)'">
                    <svg id="icon-dark" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-secondary)">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <svg id="icon-light" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-secondary);display:none;">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   style="height:36px;padding:0 16px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;box-shadow:0 2px 8px rgba(59,130,246,0.3);transition:all 0.2s;"
                   onmouseover="this.style.opacity='0.9'"
                   onmouseout="this.style.opacity='1'">
                    Dashboard
                </a>

                {{-- Déconnexion --}}
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit"
                            style="height:36px;padding:0 12px;background:none;border:1px solid var(--border-color);color:var(--text-secondary);border-radius:8px;font-size:13px;cursor:pointer;transition:all 0.2s;"
                            onmouseover="this.style.borderColor='#ef4444';this.style.color='#ef4444'"
                            onmouseout="this.style.borderColor='var(--border-color)';this.style.color='var(--text-secondary)'">
                        Déconnexion
                    </button>
                </form>

            @else
                {{-- Bouton mode sombre --}}
                <button onclick="toggleTheme()"
                        id="theme-btn"
                        style="width:36px;height:36px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg id="icon-dark" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-secondary)">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <svg id="icon-light" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-secondary);display:none;">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                    </svg>
                </button>

                <a href="{{ route('login') }}"
                   style="height:36px;padding:0 14px;color:var(--text-primary);font-size:13px;font-weight:500;text-decoration:none;display:flex;align-items:center;border-radius:8px;transition:all 0.2s;"
                   onmouseover="this.style.color='#3b82f6'"
                   onmouseout="this.style.color='var(--text-primary)'">
                    Connexion
                </a>

                <a href="{{ route('register') }}"
                   style="height:36px;padding:0 16px;background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;box-shadow:0 2px 8px rgba(59,130,246,0.3);">
                    S'inscrire
                </a>
            @endauth
        </div>
    </div>
</nav>

    {{-- Contenu principal --}}
    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="margin-top:80px;border-top:1px solid var(--border-color);background:var(--bg-card);">
        <div class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                {{-- Nouveau logo SVG --}}
<a href="/" style="display:flex;align-items:center;text-decoration:none;">
    <img src="{{ asset('images/logo.svg') }}"
         alt="StageConnect"
         style="height:40px;width:auto;">
</a>
            <p style="color:var(--text-secondary);font-size:13px;">
                © {{ date('Y') }} StageConnect — Plateforme de gestion de stages
            </p>
        </div>
    </footer>

    {{-- Chatbot IA --}}
    @auth
    <div id="chatbot" style="position:fixed;bottom:24px;right:24px;z-index:9999;">

        <div id="chat-window"
             style="display:none;width:340px;background:var(--bg-card);border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.2);border:1px solid var(--border-color);overflow:hidden;margin-bottom:12px;">

            <div style="background:linear-gradient(135deg,#1e40af,#3b82f6);padding:16px 20px;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="color:white;font-weight:600;font-size:14px;margin:0;">Conseiller IA</p>
                    <p style="color:#bfdbfe;font-size:11px;margin:0;">Votre assistant stage personnel</p>
                </div>
                <button onclick="toggleChat()"
                        style="color:white;background:rgba(255,255,255,0.2);border:none;border-radius:8px;width:28px;height:28px;cursor:pointer;font-size:18px;line-height:1;">
                    ×
                </button>
            </div>

            <div id="chat-messages"
                 style="height:280px;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;">
                <div style="background:#eff6ff;border-radius:12px 12px 12px 0;padding:10px 14px;max-width:85%;">
                    <p style="font-size:13px;color:#1e40af;margin:0;line-height:1.5;">
                        Bonjour {{ auth()->user()->name }} ! Comment puis-je vous aider aujourd'hui ? 🎓
                    </p>
                </div>
            </div>

            <div style="padding:12px 16px;border-top:1px solid var(--border-color);display:flex;gap:8px;background:var(--bg-card);">
                <input
                    type="text"
                    id="chat-input"
                    placeholder="Posez votre question..."
                    onkeypress="if(event.key==='Enter') envoyerMessage()"
                    style="flex:1;border:1px solid var(--border-color);border-radius:10px;padding:8px 12px;font-size:13px;outline:none;background:var(--bg-secondary);color:var(--text-primary);"
                >
                <button onclick="envoyerMessage()"
                        id="btn-chat"
                        class="btn-primary"
                        style="border:none;border-radius:10px;padding:8px 14px;cursor:pointer;font-size:13px;font-weight:500;">
                    Envoyer
                </button>
            </div>

        </div>

        <button onclick="toggleChat()"
        style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);border:none;cursor:pointer;box-shadow:0 8px 24px rgba(59,130,246,0.5);display:flex;align-items:center;justify-content:center;margin-left:auto;transition:transform 0.2s ease;"
        onmouseover="this.style.transform='scale(1.1)'"
        onmouseout="this.style.transform='scale(1)'">
    <x-icon name="robot" :size="26" color="white"/>
</button>

    </div>

    <script>
    function toggleChat() {
        const win = document.getElementById('chat-window');
        win.style.display = win.style.display === 'none' ? 'block' : 'none';
        if (win.style.display === 'block') {
            document.getElementById('chat-input').focus();
        }
    }

    async function envoyerMessage() {
        const input    = document.getElementById('chat-input');
        const btn      = document.getElementById('btn-chat');
        const messages = document.getElementById('chat-messages');
        const question = input.value.trim();
        if (!question) return;

        messages.innerHTML += `
            <div style="background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:12px 12px 0 12px;padding:10px 14px;max-width:85%;align-self:flex-end;margin-left:auto;">
                <p style="font-size:13px;color:white;margin:0;">${question}</p>
            </div>`;

        input.value  = '';
        btn.disabled = true;
        btn.textContent = '...';

        messages.innerHTML += `
            <div id="typing" style="background:#eff6ff;border-radius:12px;padding:10px 14px;max-width:85%;">
                <p style="font-size:13px;color:#93c5fd;margin:0;">● ● ●</p>
            </div>`;
        messages.scrollTop = messages.scrollHeight;

        try {
            const response = await fetch('{{ route("ia.chatbot") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ question }),
            });
            const data = await response.json();
            document.getElementById('typing')?.remove();

            if (data.success) {
                messages.innerHTML += `
                    <div style="background:#eff6ff;border-radius:12px 12px 12px 0;padding:10px 14px;max-width:85%;">
                        <p style="font-size:13px;color:#1e40af;margin:0;line-height:1.6;">${data.reponse}</p>
                    </div>`;
            } else {
                messages.innerHTML += `
                    <div style="background:#fef2f2;border-radius:12px;padding:10px 14px;max-width:85%;">
                        <p style="font-size:13px;color:#dc2626;margin:0;">Erreur. Réessayez.</p>
                    </div>`;
            }
        } catch (e) {
            document.getElementById('typing')?.remove();
            messages.innerHTML += `
                <div style="background:#fef2f2;border-radius:12px;padding:10px 14px;max-width:85%;">
                    <p style="font-size:13px;color:#dc2626;margin:0;">Erreur de connexion.</p>
                </div>`;
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Envoyer';
            messages.scrollTop = messages.scrollHeight;
        }
    }
    </script>
    @endauth

    {{-- Script mode sombre --}}
    <script>
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', savedTheme);
updateThemeIcons(savedTheme);

function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    updateThemeIcons(next);
}

function updateThemeIcons(theme) {
    const iconDark  = document.getElementById('icon-dark');
    const iconLight = document.getElementById('icon-light');
    if (!iconDark || !iconLight) return;
    if (theme === 'dark') {
        iconDark.style.display  = 'none';
        iconLight.style.display = 'block';
    } else {
        iconDark.style.display  = 'block';
        iconLight.style.display = 'none';
    }
}
</script>

</body>
</html>