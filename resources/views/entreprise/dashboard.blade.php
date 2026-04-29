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
        <a href="{{ route('entreprise.profil') }}"
   style="border:1px solid var(--border-color);color:var(--text-primary);padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;background:var(--bg-secondary);">
    Mon profil
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
    <div style="display:flex;align-items:center;gap:8px;white-space:nowrap;">
        <a href="{{ route('entreprise.offres.candidatures', $offre->id) }}"
           style="font-size:12px;color:#3b82f6;text-decoration:none;padding:4px 10px;border:1px solid #bfdbfe;border-radius:6px;background:#eff6ff;font-weight:500;">
            Candidatures
        </a>
        <a href="{{ route('entreprise.offres.edit', $offre->id) }}"
           style="font-size:12px;color:#d97706;text-decoration:none;padding:4px 10px;border:1px solid #fcd34d;border-radius:6px;background:#fffbeb;font-weight:500;">
            Modifier
        </a>
        <form method="POST"
              action="{{ route('entreprise.offres.destroy', $offre->id) }}"
              onsubmit="return confirm('Supprimer cette offre ?')"
              style="margin:0;">
            @csrf
            @method('DELETE')
            <button type="submit"
                    style="font-size:12px;color:#ef4444;padding:4px 10px;border:1px solid #fecaca;border-radius:6px;background:#fef2f2;font-weight:500;cursor:pointer;">
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