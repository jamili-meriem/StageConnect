@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('etudiant.offres') }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Retour aux offres
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Postuler : {{ $offre->titre }}
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            {{ $offre->entreprise->name }} — {{ $offre->lieu }}
        </p>
    </div>

    {{-- Affiche les erreurs de validation --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <p class="text-red-700 font-medium text-sm mb-2">
            Veuillez corriger les erreurs suivantes :
        </p>
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- enctype="multipart/form-data" : OBLIGATOIRE pour uploader des fichiers --}}
    {{-- sans ça, le fichier CV ne sera jamais reçu par Laravel --}}
    <form method="POST"
          action="{{ route('etudiant.offres.postuler.store', $offre->id) }}"
          enctype="multipart/form-data"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-6">

        {{-- @csrf : token de sécurité obligatoire dans tout formulaire POST --}}
        @csrf

        {{-- Lettre de motivation --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Lettre de motivation
                <span class="text-red-500">*</span>
                <span class="text-gray-400 font-normal">(minimum 50 caractères)</span>
            </label>
            <textarea
                name="motivation"
                rows="7"
                placeholder="Expliquez pourquoi vous êtes intéressé par ce stage, vos compétences..."
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none"
            >{{ old('motivation') }}</textarea>
            {{-- old('motivation') : remet le texte tapé si le formulaire a une erreur --}}
            {{-- @error : affiche l'erreur spécifique à ce champ --}}
            @error('motivation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload CV --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                CV
                <span class="text-red-500">*</span>
                <span class="text-gray-400 font-normal">(PDF uniquement, max 2 Mo)</span>
            </label>
            <input
                type="file"
                name="cv"
                accept=".pdf"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm
                       file:mr-4 file:py-1 file:px-3 file:rounded file:border-0
                       file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
            >
            @error('cv')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                Envoyer ma candidature
            </button>
            <a href="{{ route('etudiant.offres') }}"
               class="flex-1 text-center border border-gray-200 text-gray-600 py-3 rounded-lg hover:bg-gray-50 transition">
                Annuler
            </a>
        </div>

    </form>

</div>

@endsection