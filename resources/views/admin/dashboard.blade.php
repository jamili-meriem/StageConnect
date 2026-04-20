@extends('layouts.app')

@section('content')

{{-- En-tête --}}
<div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
    <h1 class="text-2xl font-bold text-gray-800">
        Tableau de bord Admin
    </h1>
    <p class="text-gray-500 mt-1">
        Vue globale de la plateforme StageConnect
    </p>
</div>

{{-- Statistiques globales --}}
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total utilisateurs</p>
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalUsers }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Étudiants</p>
        <p class="text-3xl font-bold text-teal-500 mt-2">{{ $totalEtudiants }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Entreprises</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $totalEntreprises }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Offres publiées</p>
        <p class="text-3xl font-bold text-blue-500 mt-2">{{ $totalOffres }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Candidatures</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $totalCandidatures }}</p>
    </div>

</div>

{{-- Deux colonnes : derniers users + dernières offres --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- Derniers utilisateurs inscrits --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">
                Derniers inscrits
            </h2>
            <a href="{{ route('admin.users') }}"
               class="text-sm text-indigo-600 hover:underline">
                Voir tous
            </a>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($derniersUsers as $user)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
                {{-- Badge rôle --}}
                @if($user->role === 'etudiant')
                    <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs">
                        Étudiant
                    </span>
                @elseif($user->role === 'entreprise')
                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs">
                        Entreprise
                    </span>
                @else
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs">
                        Admin
                    </span>
                @endif
            </div>
            @endforeach
        </div>

    </div>

    {{-- Dernières offres publiées --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-base font-semibold text-gray-800">
                Dernières offres
            </h2>
            <a href="{{ route('admin.offres') }}"
               class="text-sm text-indigo-600 hover:underline">
                Voir toutes
            </a>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($dernieresOffres as $offre)
            <div class="px-6 py-4">
                <p class="text-sm font-medium text-gray-800">{{ $offre->titre }}</p>
                <div class="flex justify-between items-center mt-1">
                    <p class="text-xs text-gray-400">
                        {{ $offre->entreprise->name }} — {{ $offre->lieu }}
                    </p>
                    {{-- diffForHumans() : "il y a 2 jours" --}}
                    <p class="text-xs text-gray-400">
                        {{ $offre->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

    </div>

</div>

@endsection