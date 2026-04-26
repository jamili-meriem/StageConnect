@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('etudiant.dashboard') }}"
           class="text-sm text-blue-600 hover:underline">
            ← Retour au dashboard
        </a>
        <h1 class="text-2xl font-bold mt-2" style="color:var(--text-primary)">
            Mon profil étudiant
        </h1>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;margin-bottom:20px;">
        <p style="color:#16a34a;font-size:13px;">{{ session('success') }}</p>
    </div>
    @endif

    <form method="POST"
          action="{{ route('etudiant.profil.update') }}"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Photo de profil --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                Photo de profil
            </h2>
            <div style="display:flex;align-items:center;gap:20px;">
                <img id="preview-avatar"
                     src="{{ auth()->user()->avatar_url }}"
                     alt="Avatar"
                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #bfdbfe;">
                <div>
                    <input type="file" name="avatar" id="avatar-input"
                           accept="image/*"
                           onchange="previewImage(this)"
                           style="display:none;">
                    <button type="button"
                            onclick="document.getElementById('avatar-input').click()"
                            style="background:var(--bg-secondary);border:1px solid var(--border-color);color:var(--text-primary);padding:8px 16px;border-radius:8px;cursor:pointer;font-size:13px;">
                        Changer la photo
                    </button>
                    <p style="font-size:11px;color:var(--text-secondary);margin-top:6px;">
                        JPG, PNG — max 2 Mo
                    </p>
                </div>
            </div>
        </div>

        {{-- Informations personnelles --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                Informations personnelles
            </h2>

            <div class="space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Nom complet
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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

                <div>
                    <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                        Bio / Présentation
                    </label>
                    <textarea name="bio" rows="3"
                              placeholder="Présentez-vous en quelques mots..."
                              style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;resize:none;">{{ old('bio', auth()->user()->bio) }}</textarea>
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                        LinkedIn
                    </label>
                    <input type="url" name="linkedin"
                           value="{{ old('linkedin', auth()->user()->linkedin) }}"
                           placeholder="https://linkedin.com/in/votre-profil"
                           style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                </div>

            </div>
        </div>

        {{-- Informations académiques --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                🎓 Informations académiques
            </h2>

            <div class="space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Université / École
                        </label>
                        <input type="text" name="universite"
                               value="{{ old('universite', auth()->user()->universite) }}"
                               placeholder="Ex : ENSIAS, ENSA, FST..."
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Filière
                        </label>
                        <input type="text" name="filiere"
                               value="{{ old('filiere', auth()->user()->filiere) }}"
                               placeholder="Ex : Génie Informatique"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Niveau d'études
                        </label>
                        <select name="niveau"
                                style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                            <option value="">-- Sélectionner --</option>
                            @foreach(['Bac+1', 'Bac+2', 'Bac+3', 'Bac+4', 'Bac+5'] as $n)
                                <option value="{{ $n }}"
                                    {{ old('niveau', auth()->user()->niveau) == $n ? 'selected' : '' }}>
                                    {{ $n }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                            Ville
                        </label>
                        <input type="text" name="ville"
                               value="{{ old('ville', auth()->user()->ville) }}"
                               placeholder="Ex : Rabat"
                               style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                    </div>
                </div>

            </div>
        </div>

        {{-- CV --}}
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
            <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                📄 Mon CV
            </h2>

            @if(auth()->user()->cv_path)
            <div style="display:flex;align-items:center;justify-content:space-between;background:#eff6ff;border-radius:10px;padding:14px;margin-bottom:14px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:24px;">📄</span>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#1d4ed8;">CV actuel</p>
                        <p style="font-size:11px;color:#3b82f6;">Uploadé précédemment</p>
                    </div>
                </div>
                <a href="{{ asset('storage/' . auth()->user()->cv_path) }}"
                   target="_blank"
                   style="font-size:12px;color:#1d4ed8;font-weight:500;text-decoration:none;background:white;padding:6px 12px;border-radius:8px;border:1px solid #bfdbfe;">
                    Voir le CV
                </a>
            </div>
            @endif

            <div>
                <label style="display:block;font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:6px;">
                    {{ auth()->user()->cv_path ? 'Remplacer mon CV' : 'Uploader mon CV' }}
                    <span style="color:var(--text-secondary);font-weight:400;">(PDF, max 2 Mo)</span>
                </label>
                <input type="file" name="cv" accept=".pdf"
                       style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:10px 14px;font-size:13px;background:var(--bg-secondary);color:var(--text-primary);">
                @error('cv')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Boutons --}}
        <div style="display:flex;gap:12px;">
            <button type="submit"
                    class="btn-primary"
                    style="flex:1;color:white;padding:14px;border-radius:12px;font-weight:600;border:none;cursor:pointer;font-size:14px;">
                Sauvegarder mon profil
            </button>
            <a href="{{ route('etudiant.dashboard') }}"
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