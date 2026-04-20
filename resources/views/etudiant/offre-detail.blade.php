@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('etudiant.offres') }}"
           class="text-sm text-indigo-600 hover:underline">
            ← Retour aux offres
        </a>
    </div>

    {{-- Carte principale de l'offre --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">

        {{-- En-tête --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-1 rounded-full">
                    {{ $offre->domaine }}
                </span>
                <h1 class="text-2xl font-bold text-gray-800 mt-3">
                    {{ $offre->titre }}
                </h1>
                <p class="text-indigo-600 font-medium mt-1">
                    {{ $offre->entreprise->name }}
                </p>
            </div>

            {{-- Statut de l'offre --}}
            @if($offre->is_active)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                    Active
                </span>
            @else
                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-medium">
                    Fermée
                </span>
            @endif
        </div>

        {{-- Informations rapides --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Lieu</p>
                <p class="text-sm font-medium text-gray-700">{{ $offre->lieu }}</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Durée</p>
                <p class="text-sm font-medium text-gray-700">
                    {{-- ?? : si $offre->duree est null, affiche 'Non précisée' --}}
                    {{ $offre->duree ?? 'Non précisée' }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Publiée</p>
                <p class="text-sm font-medium text-gray-700">
                    {{ $offre->created_at->format('d/m/Y') }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Date limite</p>
                <p class="text-sm font-medium text-gray-700">
                    {{-- Si date_limite existe, on la formate --}}
                    {{ $offre->date_limite ? $offre->date_limite->format('d/m/Y') : 'Non précisée' }}
                </p>
            </div>

        </div>

        {{-- Description complète --}}
        <div>
            <h2 class="text-base font-semibold text-gray-700 mb-3">
                Description du stage
            </h2>
            {{-- whitespace-pre-line : respecte les sauts de ligne --}}
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                {{ $offre->description }}
            </p>
        </div>

    </div>

    {{-- Bouton postuler --}}
    @if($offre->is_active)
        <div class="text-center">
            <a href="{{ route('etudiant.offres.postuler', $offre->id) }}"
               class="inline-block bg-indigo-600 text-white px-10 py-3 rounded-lg font-medium hover:bg-indigo-700 transition text-sm">
                Postuler à cette offre
            </a>
        </div>
    @else
        <div class="text-center bg-gray-50 rounded-xl p-6">
            <p class="text-gray-400 text-sm">
                Cette offre est fermée et n'accepte plus de candidatures.
            </p>
        </div>
    @endif

</div>

@endsection