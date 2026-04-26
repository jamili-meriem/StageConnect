@extends('layouts.app')

@section('content')

{{-- Message de succès après une candidature --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
    <p class="text-green-700 text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- En-tête de bienvenue --}}
<div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Bonjour, {{ auth()->user()->name }} !
            </h1>
            <p class="text-gray-500 mt-1">
                Bienvenue sur votre espace étudiant.
            </p>
        </div>
        <a href="{{ route('etudiant.offres') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
            Voir les offres
        </a>
        <a href="{{ route('etudiant.profil') }}"
   style="border:1px solid var(--border-color);color:var(--text-primary);padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;background:var(--bg-card);">
    Mon profil
</a>
    </div>
</div>

{{-- Statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Candidatures envoyées</p>
        {{-- $totalCandidatures vient du contrôleur --}}
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalCandidatures }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">En attente</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $enAttente }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Acceptées</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $acceptees }}</p>
    </div>

</div>

{{-- Tableau des candidatures --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">Mes candidatures</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Offre</th>
                <th class="px-6 py-3 text-left">Entreprise</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

            @forelse($candidatures as $candidature)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $candidature->offre->titre }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $candidature->offre->entreprise->name }}
                </td>

                <td class="px-6 py-4 text-gray-400">
                    {{-- format() formate la date Carbon en string lisible --}}
                    {{ $candidature->created_at->format('d/m/Y') }}
                </td>

                <td class="px-6 py-4">
                    {{-- Badge couleur selon le statut --}}
                    @if($candidature->statut === 'acceptee')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                            Acceptée
                        </span>
                    @elseif($candidature->statut === 'refusee')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">
                            Refusée
                        </span>
                    @else
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">
                            En attente
                        </span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                    Vous n'avez pas encore postulé.
                    <a href="{{ route('etudiant.offres') }}"
                       class="text-indigo-600 hover:underline ml-1">
                        Voir les offres
                    </a>
            
                    <a href="{{ route('etudiant.recommandations') }}"
   class="border border-blue-600 text-blue-600 px-5 py-2 rounded-lg hover:bg-blue-50 transition text-sm">
    Recommandations IA
</a>
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>

@endsection