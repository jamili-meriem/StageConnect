<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Plateforme de stages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { transition: background-color 0.3s ease, border-color 0.3s ease, color 0.2s ease; }
    </style>
</head>
<body style="background-color: var(--bg-secondary); color: var(--text-primary);">

    {{-- Navbar --}}
    <nav class="nav-blur sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <div class="w-9 h-9 btn-primary rounded-xl flex items-center justify-center shadow-md">
                    <span style="color:white;font-weight:700;font-size:16px;">S</span>
                </div>
                <span class="text-lg font-bold gradient-text">StageConnect</span>
            </a>

            <div class="flex items-center gap-3">

                {{-- Bouton mode sombre --}}
                <button onclick="toggleTheme()"
                        id="theme-btn"
                        style="width:38px;height:38px;border-radius:10px;border:1px solid var(--border-color);background:var(--bg-card);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;transition:all 0.3s ease;"
                        title="Changer le thème">
                    🌙
                </button>

                @auth
                    {{-- Badge rôle --}}
                    @if(auth()->user()->isEtudiant())
                        <span style="background:#eff6ff;color:#1d4ed8;font-size:11px;padding:4px 12px;border-radius:20px;font-weight:500;border:1px solid #bfdbfe;">
                            Étudiant
                        </span>
                    @elseif(auth()->user()->isEntreprise())
                        <span style="background:#eef2ff;color:#4338ca;font-size:11px;padding:4px 12px;border-radius:20px;font-weight:500;border:1px solid #c7d2fe;">
                            Entreprise
                        </span>
                    @else
                        <span style="background:#f1f5f9;color:#475569;font-size:11px;padding:4px 12px;border-radius:20px;font-weight:500;border:1px solid #e2e8f0;">
                            Admin
                        </span>
                    @endif

                    <span style="color:var(--text-secondary);font-size:14px;font-weight:500;">
                        {{ auth()->user()->name }}
                    </span>

                    <a href="{{ route('dashboard') }}"
                       class="btn-primary"
                       style="padding:8px 16px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;box-shadow:0 2px 8px rgba(59,130,246,0.3);">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button style="color:#94a3b8;font-size:13px;background:none;border:none;cursor:pointer;font-weight:500;"
                                onmouseover="this.style.color='#ef4444'"
                                onmouseout="this.style.color='#94a3b8'">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       style="color:var(--text-secondary);font-size:14px;font-weight:500;text-decoration:none;">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn-primary"
                       style="padding:8px 18px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;">
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
                <div class="w-6 h-6 btn-primary rounded-lg flex items-center justify-center">
                    <span style="color:white;font-weight:700;font-size:11px;">S</span>
                </div>
                <span class="font-semibold gradient-text text-sm">StageConnect</span>
            </div>
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
            <span style="font-size:24px;">🤖</span>
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
    // Applique le thème sauvegardé au chargement
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeBtn(savedTheme);

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        const next    = current === 'light' ? 'dark' : 'light';

        // Change le thème
        document.documentElement.setAttribute('data-theme', next);

        // Sauvegarde dans localStorage pour persister entre les pages
        localStorage.setItem('theme', next);

        updateThemeBtn(next);
    }

    function updateThemeBtn(theme) {
        const btn = document.getElementById('theme-btn');
        if (btn) {
            // Change l'icône selon le thème
            btn.textContent = theme === 'dark' ? '☀️' : '🌙';
            btn.title = theme === 'dark' ? 'Mode clair' : 'Mode sombre';
        }
    }
    </script>

</body>
</html>