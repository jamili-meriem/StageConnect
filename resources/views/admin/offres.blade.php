@extends('layouts.app')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des offres</h1>
    {{-- $offres->total() : nombre total d'offres avec pagination --}}
    <span class="text-sm text-gray-400">{{ $offres->total() }} offre(s)</span>
</div>

{{-- Message succès --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
    <p class="text-green-700 text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- Barre de recherche --}}
<form method="GET" action="{{ route('admin.offres') }}" class="mb-6 flex gap-3">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Rechercher par titre ou lieu..."
        class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
    >
    <button type="submit"
            class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
        Rechercher
    </button>
    @if(request('search'))
    <a href="{{ route('admin.offres') }}"
       class="border border-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
        Effacer
    </a>
    @endif
</form>

{{-- Tableau des offres --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Titre</th>
                <th class="px-6 py-3 text-left">Entreprise</th>
                <th class="px-6 py-3 text-left">Lieu</th>
                <th class="px-6 py-3 text-left">Domaine</th>
                <th class="px-6 py-3 text-left">Statut</th>
                <th class="px-6 py-3 text-left">Publié le</th>
                <th class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

            @forelse($offres as $offre)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $offre->titre }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{-- entreprise est la relation définie dans le modèle Offre --}}
                    {{ $offre->entreprise->name }}
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $offre->lieu }}
                </td>

                <td class="px-6 py-4">
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium">
                        {{ $offre->domaine }}
                    </span>
                </td>

                <td class="px-6 py-4">
                    {{-- is_active est casté en boolean dans le modèle --}}
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

                <td class="px-6 py-4 text-gray-400">
                    {{ $offre->created_at->format('d/m/Y') }}
                </td>

                <td class="px-6 py-4">
                    <form method="POST"
                          action="{{ route('admin.offres.destroy', $offre->id) }}"
                          onsubmit="return confirm('Supprimer cette offre ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-500 hover:underline text-xs">
                            Supprimer
                        </button>
                    </form>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                    Aucune offre trouvée.
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

    {{-- Pagination : affichée seulement si plusieurs pages --}}
    @if($offres->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $offres->links() }}
    </div>
    @endif

</div>

@endsection