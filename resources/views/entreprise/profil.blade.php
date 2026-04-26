@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('entreprise.dashboard') }}"
           class="text-sm text-blue-600 hover:underline">
            ← Retour au dashboard
        </a>
        <h1 class="text-2xl font-bold mt-2" style="color:var(--text-primary)">
            Profil de l'entreprise
        </h1>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;margin-bottom:20px;">
        <p style="color:#16a34a;font-size:13px;">{{ session('success') }}</p>
    </div>
    @endif

    <form method="POST"
          action="{{ route('entreprise.profil.update') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Photo de profil --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                Logo / Photo
            </h2>
            <div style="display:flex;align-items:center;gap:20px;">
                <img id="preview-avatar"
                     src="{{ auth()->user()->avatar_url }}"
                     alt="Logo"
                     style="width:80px;height:80px;border-radius:16px;object-fit:cover;border:2px solid var(--border-color);">
                <div>
                    <input type="file" name="avatar" id="avatar-input" accept="image/*"
                           onchange="previewImage(this)"
                           style="display:none;">
                    <button type="button"
                            onclick="document.getElementById('avatar-input').click()"
                            style="background:var(--bg-secondary);border:1px solid var(--border-color);color:var(--text-primary);padding:8px 16px;border-radius:8px;cursor:pointer;font-size:13px;">
                        Changer le logo
                    </button>
                    <p style="font-size:11px;color:var(--text-secondary);margin-top:6px;">
                        JPG, PNG — max 2 Mo
                    </p>
                </div>
            </div>
        </div>

        {{-- Informations de base --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                Informations générales
            </h2>

            <div class="space-y-4">
                <div>
                    <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                        Nom de l'entreprise
                    </label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                           style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Secteur d'activité
                        </label>
                        <select name="secteur"
                                style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                            <option value="">-- Sélectionner --</option>
                            @foreach(['Technologie', 'Finance', 'Santé', 'Éducation', 'Commerce', 'Industrie', 'Conseil', 'Marketing', 'Immobilier', 'Autre'] as $s)
                                <option value="{{ $s }}" {{ old('secteur', auth()->user()->secteur) == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Taille de l'entreprise
                        </label>
                        <select name="taille_entreprise"
                                style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                            <option value="">-- Sélectionner --</option>
                            @foreach(['1-10', '11-50', '51-200', '201-500', '500+'] as $t)
                                <option value="{{ $t }} employés" {{ old('taille_entreprise', auth()->user()->taille_entreprise) == $t.' employés' ? 'selected' : '' }}>
                                    {{ $t }} employés
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                        Description / À propos
                    </label>
                    <textarea name="bio" rows="4"
                              placeholder="Décrivez votre entreprise, votre mission, vos valeurs..."
                              style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;resize:none;">{{ old('bio', auth()->user()->bio) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Site web
                        </label>
                        <input type="url" name="site_web"
                               value="{{ old('site_web', auth()->user()->site_web) }}"
                               placeholder="https://monentreprise.com"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Téléphone
                        </label>
                        <input type="text" name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}"
                               placeholder="+212 6XX XXX XXX"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                </div>
            </div>
        </div>

        {{-- Localisation --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                📍 Localisation
            </h2>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Ville
                        </label>
                        <input type="text" name="ville"
                               value="{{ old('ville', auth()->user()->ville) }}"
                               placeholder="Ex : Casablanca"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Adresse complète
                        </label>
                        <input type="text" name="adresse"
                               value="{{ old('adresse', auth()->user()->adresse) }}"
                               placeholder="Ex : 123 Rue Hassan II"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Latitude (pour Google Maps)
                        </label>
                        <input type="text" name="latitude"
                               value="{{ old('latitude', auth()->user()->latitude) }}"
                               placeholder="Ex : 33.5731"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Longitude (pour Google Maps)
                        </label>
                        <input type="text" name="longitude"
                               value="{{ old('longitude', auth()->user()->longitude) }}"
                               placeholder="Ex : -7.5898"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                </div>

                <div style="background:#eff6ff;border-radius:10px;padding:12px;">
                    <p style="font-size:12px;color:#1d4ed8;">
                        💡 Pour trouver vos coordonnées : allez sur Google Maps, cliquez droit sur votre adresse → "Plus d'infos sur cet endroit" — les coordonnées apparaissent en haut.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bouton sauvegarder --}}
        <div style="display:flex;gap:12px;">
            <button type="submit"
                    class="btn-primary"
                    style="flex:1;color:white;padding:14px;border-radius:12px;font-weight:600;border:none;cursor:pointer;font-size:14px;">
                Sauvegarder le profil
            </button>
            <a href="{{ route('entreprise.dashboard') }}"
               style="flex:1;text-align:center;border:1px solid var(--border-color);color:var(--text-secondary);padding:14px;border-radius:12px;text-decoration:none;font-size:14px;">
                Annuler
            </a>
        </div>

    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-avatar').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection