@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('entreprise.dashboard') }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Retour au dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">
            Modifier l'offre
        </h1>
        <p class="text-gray-400 text-sm mt-1">
            {{ $offre->titre }}
        </p>
    </div>

    {{-- Erreurs de validation --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <p class="text-red-700 font-medium text-sm mb-2">
            Corrigez les erreurs suivantes :
        </p>
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- @method('PUT') : simule une requête PUT --}}
    {{-- car les navigateurs ne supportent que GET et POST --}}
    <form method="POST"
          action="{{ route('entreprise.offres.update', $offre->id) }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-6">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Titre du stage <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="titre"
                {{-- old('titre', $offre->titre) --}}
                {{-- old() : garde la valeur après erreur --}}
                {{-- $offre->titre : valeur actuelle si pas d'erreur --}}
                value="{{ old('titre', $offre->titre) }}"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
            >
            @error('titre')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Domaine --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Domaine <span class="text-red-500">*</span>
            </label>
            <select
                name="domaine"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
            >
                <option value="">-- Sélectionner --</option>
                {{-- old('domaine', $offre->domaine) --}}
                {{-- compare avec la valeur actuelle de l'offre --}}
                <option value="informatique" {{ old('domaine', $offre->domaine) == 'informatique' ? 'selected' : '' }}>
                    Informatique
                </option>
                <option value="marketing" {{ old('domaine', $offre->domaine) == 'marketing' ? 'selected' : '' }}>
                    Marketing
                </option>
                <option value="finance" {{ old('domaine', $offre->domaine) == 'finance' ? 'selected' : '' }}>
                    Finance
                </option>
                <option value="rh" {{ old('domaine', $offre->domaine) == 'rh' ? 'selected' : '' }}>
                    Ressources humaines
                </option>
                <option value="design" {{ old('domaine', $offre->domaine) == 'design' ? 'selected' : '' }}>
                    Design
                </option>
                <option value="autre" {{ old('domaine', $offre->domaine) == 'autre' ? 'selected' : '' }}>
                    Autre
                </option>
            </select>
            @error('domaine')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lieu et Durée --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lieu <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="lieu"
                    value="{{ old('lieu', $offre->lieu) }}"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                >
                @error('lieu')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Durée
                </label>
                <input
                    type="text"
                    name="duree"
                    value="{{ old('duree', $offre->duree) }}"
                    placeholder="Ex : 2 mois"
                    class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                >
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea
                name="description"
                rows="5"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none"
            >{{ old('description', $offre->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Date limite --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Date limite
            </label>
            <input
                type="date"
                name="date_limite"
                {{-- format('Y-m-d') : format attendu par l'input type="date" --}}
                value="{{ old('date_limite', $offre->date_limite?->format('Y-m-d')) }}"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
            >
            @error('date_limite')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Statut actif/inactif --}}
        <div class="flex items-center gap-3">
            <input
                type="checkbox"
                name="is_active"
                id="is_active"
                value="1"
                {{-- checked si l'offre est active --}}
                {{ old('is_active', $offre->is_active) ? 'checked' : '' }}
                class="w-4 h-4 text-indigo-600 rounded"
            >
            <label for="is_active" class="text-sm font-medium text-gray-700">
                Offre active (visible par les étudiants)
            </label>
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                Sauvegarder les modifications
            </button>
            <a href="{{ route('entreprise.dashboard') }}"
               class="flex-1 text-center border border-gray-200 text-gray-600 py-3 rounded-lg hover:bg-gray-50 transition">
                Annuler
            </a>
        </div>

    </form>

</div>

@endsection