@extends('layouts.app')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Offres de stage disponibles</h1>
    <span class="text-sm text-gray-400">{{ $offres->count() }} offre(s) trouvée(s)</span>
</div>

{{-- Barre de recherche --}}
{{-- method="GET" : les données s'ajoutent dans l'URL ex: /etudiant/offres?search=info --}}
<form method="GET" action="{{ route('etudiant.offres') }}" class="mb-8 flex gap-3">
    <input
        type="text"
        name="search"
        {{-- request('search') : garde la valeur tapée après la recherche --}}
        value="{{ request('search') }}"
        placeholder="Rechercher par titre, domaine, lieu..."
        class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
    >
    <button type="submit"
            class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
        Rechercher
    </button>
    {{-- Lien pour effacer la recherche --}}
    @if(request('search'))
    <a href="{{ route('etudiant.offres') }}"
       class="border border-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
        Effacer
    </a>
    @endif
</form>

{{-- Grille des offres --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($offres as $offre)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-6 flex flex-col justify-between">

        <div>
            {{-- En-tête de la carte --}}
            <div class="flex justify-between items-start mb-3">
                <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-3 py-1 rounded-full">
                    {{ $offre->domaine }}
                </span>
                {{-- diffForHumans() : affiche "il y a 3 jours" automatiquement --}}
                <span class="text-xs text-gray-400">
                    {{ $offre->created_at->diffForHumans() }}
                </span>
            </div>

            <h2 class="text-base font-semibold text-gray-800 mb-1">
                {{ $offre->titre }}
            </h2>
            <p class="text-sm text-indigo-600 mb-1">
                {{ $offre->entreprise->name }}
            </p>
            <p class="text-sm text-gray-400 mb-3">
                {{ $offre->lieu }}
                {{-- Si la durée existe, on l'affiche --}}
                @if($offre->duree)
                    · {{ $offre->duree }}
                @endif
            </p>

            {{-- Extrait de la description, coupé à 100 caractères --}}
            {{-- Str::limit() : coupe le texte proprement sans couper un mot --}}
            <p class="text-sm text-gray-600">
                {{ Str::limit($offre->description, 100) }}
            </p>
        </div>

        {{-- Pied de la carte --}}
        <div class="mt-5 flex gap-2">
            <a href="{{ route('etudiant.offres.show', $offre->id) }}"
               class="flex-1 text-center border border-indigo-600 text-indigo-600 py-2 rounded-lg text-sm hover:bg-indigo-50 transition">
                Voir détails
            </a>
            <a href="{{ route('etudiant.offres.postuler', $offre->id) }}"
               class="flex-1 text-center bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                Postuler
            </a>
        </div>

    </div>
    @empty
    <div class="col-span-3 text-center py-20 text-gray-400 bg-white rounded-2xl border border-gray-100">
        @if(request('search'))
            Aucune offre trouvée pour "{{ request('search') }}".
        @else
            Aucune offre disponible pour le moment.
        @endif
    </div>
    @endforelse

</div>

{{-- Pagination automatique générée par Laravel --}}
{{-- $offres->links() affiche les boutons page 1, 2, 3... --}}
<div class="mt-8">
    {{ $offres->links() }}
</div>

@endsection