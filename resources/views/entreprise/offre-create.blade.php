@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('entreprise.dashboard') }}"
           class="text-sm text-blue-600 hover:underline">
            ← Retour au dashboard
        </a>
        <h1 class="text-2xl font-bold mt-2" style="color:var(--text-primary)">
            Publier une offre de stage
        </h1>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST"
          action="{{ route('entreprise.offres.store') }}"
          class="space-y-6"
          style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:32px;">
        @csrf

        {{-- Titre --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                Titre du stage <span class="text-red-500">*</span>
            </label>
            <input type="text" name="titre" value="{{ old('titre') }}"
                   placeholder="Ex : Développeur Laravel Junior"
                   style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
            @error('titre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Domaine + Niveau --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Domaine <span class="text-red-500">*</span>
                </label>
                <select name="domaine"
                        style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    <option value="">-- Sélectionner --</option>
                    <option value="informatique" {{ old('domaine') == 'informatique' ? 'selected' : '' }}>Informatique</option>
                    <option value="marketing" {{ old('domaine') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="finance" {{ old('domaine') == 'finance' ? 'selected' : '' }}>Finance</option>
                    <option value="rh" {{ old('domaine') == 'rh' ? 'selected' : '' }}>Ressources humaines</option>
                    <option value="design" {{ old('domaine') == 'design' ? 'selected' : '' }}>Design</option>
                    <option value="autre" {{ old('domaine') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('domaine')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Niveau requis
                </label>
                <select name="niveau_requis"
                        style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    <option value="bac+2" {{ old('niveau_requis') == 'bac+2' ? 'selected' : '' }}>Bac+2</option>
                    <option value="bac+3" {{ old('niveau_requis') == 'bac+3' ? 'selected' : '' }} selected>Bac+3</option>
                    <option value="bac+4" {{ old('niveau_requis') == 'bac+4' ? 'selected' : '' }}>Bac+4</option>
                    <option value="bac+5" {{ old('niveau_requis') == 'bac+5' ? 'selected' : '' }}>Bac+5</option>
                </select>
            </div>
        </div>

        {{-- Lieu + Durée --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Lieu <span class="text-red-500">*</span>
                </label>
                <input type="text" name="lieu" value="{{ old('lieu') }}"
                       placeholder="Ex : Casablanca"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                @error('lieu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Durée
                </label>
                <input type="text" name="duree" value="{{ old('duree') }}"
                       placeholder="Ex : 2 mois"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
            </div>
        </div>

        {{-- Type travail + Nombre postes --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Type de travail
                </label>
                <select name="type_travail"
                        style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    <option value="presentiel" {{ old('type_travail') == 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                    <option value="remote" {{ old('type_travail') == 'remote' ? 'selected' : '' }}>Remote</option>
                    <option value="hybride" {{ old('type_travail') == 'hybride' ? 'selected' : '' }}>Hybride</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Nombre de postes
                </label>
                <input type="number" name="nombre_postes" value="{{ old('nombre_postes', 1) }}"
                       min="1" max="20"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
            </div>
        </div>

        {{-- Salaire --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Salaire minimum (MAD)
                </label>
                <input type="number" name="salaire_min" value="{{ old('salaire_min') }}"
                       placeholder="Ex : 2000"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                    Salaire maximum (MAD)
                </label>
                <input type="number" name="salaire_max" value="{{ old('salaire_max') }}"
                       placeholder="Ex : 4000"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
            </div>
        </div>

        {{-- Compétences requises --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                Compétences requises
                <span style="color:var(--text-secondary);font-weight:400;">(séparées par des virgules)</span>
            </label>
            <input type="text" name="competences_requises" value="{{ old('competences_requises') }}"
                   placeholder="Ex : PHP, Laravel, MySQL, Git"
                   style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea name="description" rows="5"
                      placeholder="Décrivez les missions, les compétences requises..."
                      style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;resize:none;">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Date limite --}}
        <div>
            <label class="block text-sm font-medium mb-2" style="color:var(--text-primary)">
                Date limite
            </label>
            <input type="date" name="date_limite" value="{{ old('date_limite') }}"
                   style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="btn-primary"
                    style="flex:1;color:white;padding:12px;border-radius:10px;font-weight:500;border:none;cursor:pointer;font-size:14px;">
                Publier l'offre
            </button>
            <a href="{{ route('entreprise.dashboard') }}"
               style="flex:1;text-align:center;border:1px solid var(--border-color);color:var(--text-secondary);padding:12px;border-radius:10px;text-decoration:none;font-size:14px;">
                Annuler
            </a>
        </div>

    </form>
</div>

@endsection