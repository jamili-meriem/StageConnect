<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        {{-- Logo StageConnect --}}
        <a href="/" class="text-xl font-bold text-indigo-600">
            StageConnect
        </a>

        {{-- Liens navigation --}}
        <div class="flex gap-4 items-center">

            @auth
                {{-- @auth vérifie que l'utilisateur EST connecté --}}
                {{-- ?-> est l'opérateur nullsafe : évite le crash si user est null --}}
                <span class="text-gray-600 text-sm">
                    {{ Auth::user()?->name }}
                </span>

                <a href="{{ route('dashboard') }}"
                   class="text-indigo-600 hover:underline text-sm">
                    Dashboard
                </a>

                {{-- Formulaire déconnexion --}}
                {{-- Les navigateurs ne supportent que GET/POST --}}
                {{-- donc on utilise un formulaire POST pour se déconnecter --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-red-500 text-sm hover:underline">
                        Déconnexion
                    </button>
                </form>

            @else
                {{-- @else : l'utilisateur N'est PAS connecté --}}

                <a href="{{ route('login') }}"
                   class="text-gray-600 hover:text-indigo-600 text-sm">
                    Connexion
                </a>

                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                    S'inscrire
                </a>

            @endauth

        </div>

    </div>
</nav>