@extends('layouts.app')

@section('content')

{{-- Message de succès --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
    <p class="text-green-700 text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- En-tête --}}
<div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tableau de bord — {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-500 mt-1">
                Gérez vos offres et suivez vos candidatures
            </p>
        </div>
        <a href="{{ route('entreprise.offres.create') }}"
           class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
            + Publier une offre
        </a>
    </div>
</div>

{{-- Statistiques --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Offres publiées</p>
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalOffres }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Candidatures reçues</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $totalCandidatures }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">En attente</p>
        <p class="text-3xl font-bold text-gray-600 mt-2">{{ $enAttente }}</p>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Acceptées</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $acceptees }}</p>
    </div>

</div>

{{-- Tableau des offres --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">Mes offres publiées</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Titre</th>
                <th class="px-6 py-3 text-left">Lieu</th>
                <th class="px-6 py-3 text-left">Candidatures</th>
                <th class="px-6 py-3 text-left">Statut</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

            @forelse($offres as $offre)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $offre->titre }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $offre->lieu }}
                </td>

                <td class="px-6 py-4">
                    {{-- count() sur la relation candidatures --}}
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium">
                        {{ $offre->candidatures->count() }} candidature(s)
                    </span>
                </td>

                <td class="px-6 py-4">
                    @if($offre->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                            Active
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-medium">
                            Fermée
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    <div class="flex gap-3">

                        <a href="{{ route('entreprise.offres.candidatures', $offre->id) }}"
                           class="text-indigo-600 hover:underline text-xs">
                            Candidatures
                        </a>

                        <a href="{{ route('entreprise.offres.edit', $offre->id) }}"
                           class="text-amber-600 hover:underline text-xs">
                            Modifier
                        </a>

                        {{-- Formulaire DELETE pour supprimer --}}
                        {{-- @method('DELETE') : simule une requête DELETE --}}
                        {{-- car les navigateurs ne supportent que GET et POST --}}
                        <form method="POST"
                              action="{{ route('entreprise.offres.destroy', $offre->id) }}"
                              onsubmit="return confirm('Supprimer cette offre ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-500 hover:underline text-xs">
                                Supprimer
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                    Vous n'avez pas encore publié d'offre.
                    <a href="{{ route('entreprise.offres.create') }}"
                       class="text-indigo-600 hover:underline ml-1">
                        Publier maintenant
                    </a>
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>

@endsection