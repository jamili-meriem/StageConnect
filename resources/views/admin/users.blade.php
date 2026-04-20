@extends('layouts.app')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des utilisateurs</h1>
    <span class="text-sm text-gray-400">{{ $users->total() }} utilisateur(s)</span>
</div>

{{-- Message succès --}}
@if(session('success'))
<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
    <p class="text-green-700 text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- Barre de recherche --}}
<form method="GET" action="{{ route('admin.users') }}" class="mb-6 flex gap-3">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Rechercher par nom ou email..."
        class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
    >
    <button type="submit"
            class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
        Rechercher
    </button>
    @if(request('search'))
    <a href="{{ route('admin.users') }}"
       class="border border-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
        Effacer
    </a>
    @endif
</form>

{{-- Tableau des utilisateurs --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Nom</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Rôle</th>
                <th class="px-6 py-3 text-left">Inscrit le</th>
                <th class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">

            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $user->name }}
                    {{-- Indique si c'est le compte connecté --}}
                    @if($user->id === auth()->id())
                        <span class="text-xs text-indigo-400 ml-1">(vous)</span>
                    @endif
                </td>

                <td class="px-6 py-4 text-gray-500">
                    {{ $user->email }}
                </td>

                <td class="px-6 py-4">
                    @if($user->role === 'etudiant')
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-medium">
                            Étudiant
                        </span>
                    @elseif($user->role === 'entreprise')
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">
                            Entreprise
                        </span>
                    @else
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium">
                            Admin
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-gray-400">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>

                <td class="px-6 py-4">
                    {{-- On ne peut pas supprimer son propre compte --}}
                    @if($user->id !== auth()->id())
                    <form method="POST"
                          action="{{ route('admin.users.destroy', $user->id) }}"
                          onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-500 hover:underline text-xs">
                            Supprimer
                        </button>
                    </form>
                    @else
                        <span class="text-gray-300 text-xs">—</span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                    Aucun utilisateur trouvé.
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif

</div>

@endsection