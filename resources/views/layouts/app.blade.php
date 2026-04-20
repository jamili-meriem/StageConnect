<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — Plateforme de stages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="nav-blur sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">

            <a href="/" class="flex items-center gap-3">
                <div class="w-9 h-9 btn-primary rounded-xl flex items-center justify-center shadow-md">
                    <span class="text-white font-bold text-base">S</span>
                </div>
                <span class="text-lg font-bold gradient-text">StageConnect</span>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->isEtudiant())
                        <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full font-medium border border-blue-100">
                            Étudiant
                        </span>
                    @elseif(auth()->user()->isEntreprise())
                        <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-medium border border-indigo-100">
                            Entreprise
                        </span>
                    @else
                        <span class="bg-slate-100 text-slate-700 text-xs px-3 py-1 rounded-full font-medium border border-slate-200">
                            Admin
                        </span>
                    @endif

                    <span class="text-gray-700 text-sm font-medium">
                        {{ auth()->user()->name }}
                    </span>

                    <a href="{{ route('dashboard') }}"
                       class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium shadow-sm">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-gray-400 hover:text-red-500 text-sm transition font-medium">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-blue-600 text-sm font-medium transition">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-medium shadow-sm">
                        S'inscrire
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 btn-primary rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xs">S</span>
                </div>
                <span class="font-semibold gradient-text text-sm">StageConnect</span>
            </div>
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} StageConnect — Plateforme de gestion de stages
            </p>
        </div>
    </footer>

    {{-- Chatbot IA flottant --}}
    @auth
    <div id="chatbot" style="position:fixed;bottom:24px;right:24px;z-index:9999;">

        <div id="chat-window"
             style="display:none;width:340px;background:white;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.15);border:1px solid #e2e8f0;overflow:hidden;margin-bottom:12px;">

            <div style="background:linear-gradient(135deg,#1e40af,#3b82f6);padding:16px 20px;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="color:white;font-weight:600;font-size:14px;margin:0;">Conseiller IA</p>
                    <p style="color:#bfdbfe;font-size:11px;margin:0;">Je vous aide à trouver votre stage</p>
                </div>
                <button onclick="toggleChat()"
                        style="color:white;background:rgba(255,255,255,0.2);border:none;border-radius:8px;width:28px;height:28px;cursor:pointer;font-size:16px;">
                    
                </button>
            </div>

            <div id="chat-messages"
                 style="height:280px;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;">
                <div style="background:#eff6ff;border-radius:12px;padding:10px 14px;max-width:85%;">
                    <p style="font-size:13px;color:#1e40af;margin:0;line-height:1.5;">
                        Bonjour {{ auth()->user()->name }} ! Je suis votre conseiller IA. Comment puis-je vous aider ?
                    </p>
                </div>
            </div>

            <div style="padding:12px 16px;border-top:1px solid #f1f5f9;display:flex;gap:8px;">
                <input
                    type="text"
                    id="chat-input"
                    placeholder="Posez votre question..."
                    onkeypress="if(event.key==='Enter') envoyerMessage()"
                    style="flex:1;border:1px solid #e2e8f0;border-radius:10px;padding:8px 12px;font-size:13px;outline:none;"
                >
                <button onclick="envoyerMessage()"
                        id="btn-chat"
                        style="background:linear-gradient(135deg,#1e40af,#3b82f6);color:white;border:none;border-radius:10px;padding:8px 14px;cursor:pointer;font-size:13px;font-weight:500;">
                    Envoyer
                </button>
            </div>

        </div>

        <button onclick="toggleChat()"
                style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#3b82f6);border:none;cursor:pointer;box-shadow:0 8px 24px rgba(59,130,246,0.4);display:flex;align-items:center;justify-content:center;margin-left:auto;">
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
            <div style="background:#1e40af;border-radius:12px;padding:10px 14px;max-width:85%;align-self:flex-end;margin-left:auto;">
                <p style="font-size:13px;color:white;margin:0;">${question}</p>
            </div>
        `;

        input.value  = '';
        btn.disabled = true;
        btn.textContent = '...';

        messages.innerHTML += `
            <div id="typing" style="background:#eff6ff;border-radius:12px;padding:10px 14px;max-width:85%;">
                <p style="font-size:13px;color:#93c5fd;margin:0;">En train de répondre...</p>
            </div>
        `;
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
            document.getElementById('typing').remove();

            if (data.success) {
                messages.innerHTML += `
                    <div style="background:#eff6ff;border-radius:12px;padding:10px 14px;max-width:85%;">
                        <p style="font-size:13px;color:#1e40af;margin:0;line-height:1.5;">${data.reponse}</p>
                    </div>
                `;
            } else {
                messages.innerHTML += `
                    <div style="background:#fef2f2;border-radius:12px;padding:10px 14px;max-width:85%;">
                        <p style="font-size:13px;color:#dc2626;margin:0;">Erreur. Réessayez.</p>
                    </div>
                `;
            }
        } catch (error) {
            document.getElementById('typing')?.remove();
            messages.innerHTML += `
                <div style="background:#fef2f2;border-radius:12px;padding:10px 14px;max-width:85%;">
                    <p style="font-size:13px;color:#dc2626;margin:0;">Erreur de connexion.</p>
                </div>
            `;
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Envoyer';
            messages.scrollTop = messages.scrollHeight;
        }
    }
    </script>
    @endauth

</body>
</html>