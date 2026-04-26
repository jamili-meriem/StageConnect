@extends('layouts.app')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('entreprise.dashboard') }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Retour au dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Candidatures — {{ $offre->titre }}
        </h1>
        <p class="text-gray-400 text-sm mt-1">
            {{ $candidatures->count() }} candidature(s) reçue(s)
        </p>
    </div>
</div>

{{-- Message succès --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
    <p class="text-green-700 text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- Liste des candidatures --}}
<div class="space-y-4">

    @forelse($candidatures as $candidature)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">

        <div class="flex justify-between items-start">

            {{-- Infos étudiant --}}
            <div>
                <h3 class="font-semibold text-gray-800 text-base">
                    {{ $candidature->etudiant->name }}
                </h3>
                <p class="text-sm text-gray-400 mt-1">
                    {{ $candidature->etudiant->email }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Reçue le {{ $candidature->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            {{-- Badge statut --}}
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

        </div>

        {{-- Extrait motivation --}}
        <div class="mt-4 bg-gray-50 rounded-lg p-4">
            {{-- Str::limit() coupe le texte à 200 caractères --}}
            <p class="text-sm text-gray-600">
                {{ Str::limit($candidature->motivation, 200) }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="mt-4 flex gap-3 flex-wrap">

            {{-- Télécharger le CV --}}
            {{-- asset('storage/...') : génère l'URL publique du fichier --}}
            <a href="{{ asset('storage/' . $candidature->cv_path) }}"
               target="_blank"
               class="border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                Télécharger CV
            </a>

            <a href="{{ route('entreprise.candidatures.show', $candidature->id) }}"
               class="border border-indigo-200 text-indigo-600 px-4 py-2 rounded-lg text-sm hover:bg-indigo-50 transition">
                Voir détail complet
            </a>

            {{-- Boutons accepter/refuser : visibles seulement si en attente --}}
            @if($candidature->statut === 'en_attente')
            <form method="POST"
                  action="{{ route('entreprise.candidatures.statut', $candidature->id) }}"
                  class="flex gap-2">
                @csrf
                {{-- @method('PATCH') : simule une requête PATCH --}}
                {{-- car les navigateurs ne supportent que GET et POST --}}
                @method('PATCH')

                {{-- name="statut" value="acceptee" : envoie le statut choisi --}}
                <button type="submit"
                        name="statut"
                        value="acceptee"
                        onclick="return confirm('Accepter cette candidature ?')"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                    Accepter
                </button>
                <button type="submit"
                        name="statut"
                        value="refusee"
                        onclick="return confirm('Refuser cette candidature ?')"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition">
                    Refuser
                </button>
                
            </form>
            @endif

        </div>

    </div>
    @empty
    <div class="text-center py-20 text-gray-400 bg-white rounded-2xl border border-gray-100">
        Aucune candidature reçue pour cette offre.
    </div>
    @endforelse

</div>

@endsection