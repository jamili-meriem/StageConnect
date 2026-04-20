@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('entreprise.offres.candidatures', $candidature->offre_id) }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Retour aux candidatures
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Dossier de {{ $candidature->etudiant->name }}
        </h1>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
        <p class="text-green-700 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Fiche étudiant --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">

        <h2 class="text-base font-semibold text-gray-700 mb-4">
            Informations étudiant
        </h2>

        {{-- grid grid-cols-2 : affiche les infos en 2 colonnes --}}
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Nom complet</p>
                <p class="text-gray-800 font-medium mt-1">
                    {{ $candidature->etudiant->name }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Email</p>
                <p class="text-gray-800 font-medium mt-1">
                    {{ $candidature->etudiant->email }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Offre concernée</p>
                <p class="text-gray-800 font-medium mt-1">
                    {{ $candidature->offre->titre }}
                </p>
            </div>
            <div>
                <p class="text-gray-400">Date de candidature</p>
                <p class="text-gray-800 font-medium mt-1">
                    {{ $candidature->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

    </div>

    {{-- Lettre de motivation complète --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">

        <h2 class="text-base font-semibold text-gray-700 mb-4">
            Lettre de motivation
        </h2>

        {{-- whitespace-pre-line : respecte les sauts de ligne de l'étudiant --}}
        <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
            {{ $candidature->motivation }}
        </p>

    </div>

    {{-- CV --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">

        <h2 class="text-base font-semibold text-gray-700 mb-4">CV</h2>

        {{-- asset('storage/...') génère l'URL publique du fichier uploadé --}}
        <a href="{{ asset('storage/' . $candidature->cv_path) }}"
           target="_blank"
           class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-5 py-3 rounded-lg text-sm hover:bg-indigo-100 transition">
            Télécharger le CV (PDF)
        </a>

    </div>

    {{-- Décision --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <h2 class="text-base font-semibold text-gray-700 mb-4">Décision</h2>

        {{-- Si déjà statué, affiche le statut actuel --}}
        @if($candidature->statut !== 'en_attente')
            <div class="flex items-center gap-3">
                <p class="text-sm text-gray-500">
                    Décision prise :
                </p>
                @if($candidature->statut === 'acceptee')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Candidature acceptée
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Candidature refusée
                    </span>
                @endif
            </div>
        @else
            {{-- Si encore en attente, affiche les boutons --}}
            <form method="POST"
                  action="{{ route('entreprise.candidatures.statut', $candidature->id) }}"
                  class="flex gap-3">
                @csrf
                @method('PATCH')

                <button type="submit"
                        name="statut"
                        value="acceptee"
                        onclick="return confirm('Accepter cette candidature ?')"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    Accepter la candidature
                </button>

                <button type="submit"
                        name="statut"
                        value="refusee"
                        onclick="return confirm('Refuser cette candidature ?')"
                        class="bg-red-500 text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-red-600 transition">
                    Refuser la candidature
                </button>

            </form>
        @endif

    </div>

</div>

@endsection