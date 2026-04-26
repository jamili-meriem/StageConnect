@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('entreprise.candidatures.show', $candidature->id) }}"
           class="text-sm text-blue-600 hover:underline">
            ← Retour à la candidature
        </a>
        <h1 class="text-2xl font-bold mt-2" style="color:var(--text-primary)">
            Évaluer le stagiaire
        </h1>
        <p style="color:var(--text-secondary);font-size:14px;margin-top:4px;">
            {{ $candidature->etudiant->name }} — {{ $candidature->offre->titre }}
        </p>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px;margin-bottom:20px;">
        <p style="color:#16a34a;font-size:13px;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Évaluation existante --}}
    @if($evaluation)
    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:14px;padding:20px;margin-bottom:24px;">
        <p style="font-size:13px;font-weight:600;color:#1d4ed8;margin-bottom:8px;">
            Votre évaluation actuelle
        </p>
        <div style="display:flex;gap:4px;margin-bottom:8px;">
            @for($i = 1; $i <= 5; $i++)
                <span style="font-size:24px;color:{{ $i <= $evaluation->note ? '#f59e0b' : '#d1d5db' }};">★</span>
            @endfor
        </div>
        @if($evaluation->commentaire)
        <p style="font-size:13px;color:#1e40af;">{{ $evaluation->commentaire }}</p>
        @endif
    </div>
    @endif

    <form method="POST"
         action="{{ route('entreprise.candidatures.evaluer.store', $candidature->id) }}"
          style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:28px;"
          class="space-y-6">
        @csrf

        {{-- Note étoiles --}}
        <div>
            <label style="display:block;font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                Note globale <span class="text-red-500">*</span>
            </label>

            <div style="display:flex;gap:12px;justify-content:center;">
                @for($i = 1; $i <= 5; $i++)
                <label style="cursor:pointer;text-align:center;">
                    <input type="radio" name="note" value="{{ $i }}"
                           {{ old('note', $evaluation?->note) == $i ? 'checked' : '' }}
                           style="display:none;"
                           onchange="updateStars({{ $i }})">
                    <span id="star-{{ $i }}"
                          onclick="selectStar({{ $i }})"
                          style="font-size:40px;cursor:pointer;transition:transform 0.2s;display:block;color:{{ old('note', $evaluation?->note) >= $i ? '#f59e0b' : '#d1d5db' }};"
                          onmouseover="hoverStars({{ $i }})"
                          onmouseout="resetStars()">
                        ★
                    </span>
                    <span style="font-size:11px;color:var(--text-secondary);">
                        {{ ['', 'Mauvais', 'Passable', 'Bien', 'Très bien', 'Excellent'][$i] }}
                    </span>
                </label>
                @endfor
            </div>

            <input type="hidden" name="note" id="note-value"
                   value="{{ old('note', $evaluation?->note ?? '') }}">
            @error('note')<p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>@enderror
        </div>

        {{-- Critères détaillés --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

            @foreach([
                'Ponctualité' => '⏰',
                'Qualité du travail' => '✅',
                'Initiative' => '💡',
                'Esprit d\'équipe' => '🤝',
            ] as $critere => $emoji)
            <div style="background:var(--bg-secondary);border-radius:10px;padding:14px;">
                <p style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:8px;">
                    {{ $emoji }} {{ $critere }}
                </p>
                <div style="display:flex;gap:4px;">
                    @for($i = 1; $i <= 5; $i++)
                    <span style="font-size:20px;cursor:pointer;color:#d1d5db;"
                          onclick="this.parentElement.querySelectorAll('span').forEach((s,idx) => s.style.color = idx < {{ $i }} ? '#f59e0b' : '#d1d5db')">
                        ★
                    </span>
                    @endfor
                </div>
            </div>
            @endforeach

        </div>

        {{-- Commentaire --}}
        <div>
            <label style="display:block;font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:8px;">
                Commentaire
                <span style="font-weight:400;color:var(--text-secondary);">(optionnel)</span>
            </label>
            <textarea name="commentaire" rows="4"
                      placeholder="Partagez votre expérience avec ce stagiaire, ses points forts, ses axes d'amélioration..."
                      style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:12px 14px;font-size:14px;background:var(--bg-secondary);color:var(--text-primary);outline:none;resize:none;">{{ old('commentaire', $evaluation?->commentaire) }}</textarea>
        </div>

        {{-- Recommandation --}}
        <div style="background:var(--bg-secondary);border-radius:10px;padding:16px;">
            <p style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:12px;">
                Recommanderiez-vous ce stagiaire ?
            </p>
            <div style="display:flex;gap:12px;">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="radio" name="recommande" value="1"
                           {{ old('recommande') == '1' ? 'checked' : '' }}>
                    <span style="font-size:13px;color:var(--text-primary);">👍 Oui, je recommande</span>
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="radio" name="recommande" value="0"
                           {{ old('recommande') == '0' ? 'checked' : '' }}>
                    <span style="font-size:13px;color:var(--text-primary);">👎 Non</span>
                </label>
            </div>
        </div>

        {{-- Boutons --}}
        <div style="display:flex;gap:12px;">
            <button type="submit"
                    class="btn-primary"
                    style="flex:1;color:white;padding:14px;border-radius:12px;font-weight:600;border:none;cursor:pointer;font-size:14px;">
                {{ $evaluation ? 'Modifier l\'évaluation' : 'Soumettre l\'évaluation' }}
            </button>
            <a href="{{ route('entreprise.candidatures.show', $candidature->id) }}"
               style="flex:1;text-align:center;border:1px solid var(--border-color);color:var(--text-secondary);padding:14px;border-radius:12px;text-decoration:none;font-size:14px;">
                Annuler
            </a>
        </div>

    </form>
</div>

<script>
let selectedNote = {{ old('note', $evaluation?->note ?? 0) }};

function selectStar(n) {
    selectedNote = n;
    document.getElementById('note-value').value = n;
    updateStarsDisplay(n);
}

function hoverStars(n) {
    updateStarsDisplay(n);
}

function resetStars() {
    updateStarsDisplay(selectedNote);
}

function updateStarsDisplay(n) {
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById(`star-${i}`);
        star.style.color = i <= n ? '#f59e0b' : '#d1d5db';
        star.style.transform = i <= n ? 'scale(1.1)' : 'scale(1)';
    }
}

updateStarsDisplay(selectedNote);
</script>

@endsection