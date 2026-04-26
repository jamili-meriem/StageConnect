@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('etudiant.offres') }}"
           class="text-sm text-blue-600 hover:underline">
            ← Retour aux offres
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Colonne principale --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Carte principale --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:28px;">

                {{-- En-tête --}}
                <div class="flex justify-between items-start mb-5">
                    <div class="flex items-center gap-4">
                        {{-- Logo entreprise --}}
                        <img src="{{ $offre->entreprise->avatar_url }}"
                             alt="{{ $offre->entreprise->name }}"
                             style="width:56px;height:56px;border-radius:12px;object-fit:cover;">
                        <div>
                            <h1 class="text-xl font-bold" style="color:var(--text-primary)">
                                {{ $offre->titre }}
                            </h1>
                            <p style="color:#3b82f6;font-size:14px;font-weight:500;margin-top:2px;">
                                {{ $offre->entreprise->name }}
                            </p>
                        </div>
                    </div>

                    {{-- Bouton favori --}}
                    @auth
                    <button onclick="toggleFavori({{ $offre->id }}, this)"
                            id="btn-favori"
                            style="width:40px;height:40px;border-radius:10px;border:1px solid var(--border-color);background:var(--bg-secondary);cursor:pointer;font-size:20px;display:flex;align-items:center;justify-content:center;">
                        {{ auth()->user()->aEnFavori($offre->id) ? '❤️' : '🤍' }}
                    </button>
                    @endauth
                </div>

                {{-- Badges --}}
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px;">
                    <span style="background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:500;padding:4px 12px;border-radius:20px;">
                        {{ $offre->domaine }}
                    </span>

                    @php $badge = $offre->type_travail_badge; @endphp
                    <span style="background:{{ $badge['color'] === 'green' ? '#f0fdf4' : ($badge['color'] === 'amber' ? '#fffbeb' : '#eff6ff') }};
                                 color:{{ $badge['color'] === 'green' ? '#16a34a' : ($badge['color'] === 'amber' ? '#d97706' : '#1d4ed8') }};
                                 font-size:12px;font-weight:500;padding:4px 12px;border-radius:20px;">
                        {{ $badge['label'] }}
                    </span>

                    <span style="background:#f1f5f9;color:#475569;font-size:12px;font-weight:500;padding:4px 12px;border-radius:20px;">
                        {{ strtoupper($offre->niveau_requis) }}
                    </span>

                    @if($offre->is_active)
                        <span style="background:#f0fdf4;color:#16a34a;font-size:12px;font-weight:500;padding:4px 12px;border-radius:20px;">
                            Active
                        </span>
                    @endif
                </div>

                {{-- Infos rapides --}}
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:24px;">

                    <div style="background:var(--bg-secondary);border-radius:10px;padding:14px;text-align:center;">
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:4px;">Lieu</p>
                        <p style="font-size:14px;font-weight:500;color:var(--text-primary);">{{ $offre->lieu }}</p>
                    </div>

                    <div style="background:var(--bg-secondary);border-radius:10px;padding:14px;text-align:center;">
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:4px;">Durée</p>
                        <p style="font-size:14px;font-weight:500;color:var(--text-primary);">{{ $offre->duree ?? 'Non précisée' }}</p>
                    </div>

                    <div style="background:var(--bg-secondary);border-radius:10px;padding:14px;text-align:center;">
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:4px;">Rémunération</p>
                        <p style="font-size:14px;font-weight:600;color:#16a34a;">{{ $offre->salaire_format }}</p>
                    </div>

                    <div style="background:var(--bg-secondary);border-radius:10px;padding:14px;text-align:center;">
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:4px;">Postes</p>
                        <p style="font-size:14px;font-weight:500;color:var(--text-primary);">{{ $offre->nombre_postes }} poste(s)</p>
                    </div>

                </div>

                {{-- Description --}}
                <div>
                    <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:12px;">
                        Description du stage
                    </h2>
                    <p style="font-size:14px;color:var(--text-secondary);line-height:1.7;white-space:pre-line;">
                        {{ $offre->description }}
                    </p>
                </div>

                {{-- Compétences requises --}}
                @if($offre->competences_requises)
                <div style="margin-top:20px;">
                    <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:12px;">
                        Compétences requises
                    </h2>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @foreach($offre->competences_requises as $competence)
                        <span style="background:var(--bg-secondary);border:1px solid var(--border-color);color:var(--text-primary);font-size:12px;font-weight:500;padding:5px 12px;border-radius:8px;">
                            {{ $competence }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-4">

            {{-- Carte entreprise --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">

                <h3 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:16px;">
                    À propos de l'entreprise
                </h3>

                <div style="text-align:center;margin-bottom:16px;">
                    <img src="{{ $offre->entreprise->avatar_url }}"
                         alt="{{ $offre->entreprise->name }}"
                         style="width:72px;height:72px;border-radius:16px;object-fit:cover;margin:0 auto 10px;">
                    <p style="font-size:15px;font-weight:600;color:var(--text-primary);">
                        {{ $offre->entreprise->name }}
                    </p>
                    @if($offre->entreprise->secteur)
                    <p style="font-size:12px;color:var(--text-secondary);margin-top:2px;">
                        {{ $offre->entreprise->secteur }}
                    </p>
                    @endif
                </div>

                @if($offre->entreprise->taille_entreprise)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border-color);">
                    <span style="font-size:12px;color:var(--text-secondary);">Taille</span>
                    <span style="font-size:12px;font-weight:500;color:var(--text-primary);">{{ $offre->entreprise->taille_entreprise }}</span>
                </div>
                @endif

                @if($offre->entreprise->ville)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border-color);">
                    <span style="font-size:12px;color:var(--text-secondary);">Ville</span>
                    <span style="font-size:12px;font-weight:500;color:var(--text-primary);">{{ $offre->entreprise->ville }}</span>
                </div>
                @endif

                {{-- Lien Google Maps --}}
                @if($offre->entreprise->latitude && $offre->entreprise->longitude)
                <a href="https://www.google.com/maps?q={{ $offre->entreprise->latitude }},{{ $offre->entreprise->longitude }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:8px;padding:10px;background:#eff6ff;border-radius:10px;text-decoration:none;margin-top:12px;">
                    <span style="font-size:18px;">📍</span>
                    <span style="font-size:12px;color:#1d4ed8;font-weight:500;">Voir sur Google Maps</span>
                </a>
                @elseif($offre->entreprise->adresse)
                <a href="https://www.google.com/maps/search/{{ urlencode($offre->entreprise->adresse . ' ' . $offre->entreprise->ville) }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:8px;padding:10px;background:#eff6ff;border-radius:10px;text-decoration:none;margin-top:12px;">
                    <span style="font-size:18px;">📍</span>
                    <span style="font-size:12px;color:#1d4ed8;font-weight:500;">Voir sur Google Maps</span>
                </a>
                @endif

                @if($offre->entreprise->site_web)
                <a href="{{ $offre->entreprise->site_web }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:8px;padding:10px;background:var(--bg-secondary);border-radius:10px;text-decoration:none;margin-top:8px;">
                    <span style="font-size:18px;">🌐</span>
                    <span style="font-size:12px;color:var(--text-primary);font-weight:500;">Visiter le site web</span>
                </a>
                @endif

                @if($offre->entreprise->bio)
                <p style="font-size:12px;color:var(--text-secondary);margin-top:12px;line-height:1.6;">
                    {{ Str::limit($offre->entreprise->bio, 150) }}
                </p>
                @endif

            </div>

            {{-- Carte action --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">

                <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
                    <span style="font-size:12px;color:var(--text-secondary);">Date limite</span>
                    <span style="font-size:12px;font-weight:500;color:var(--text-primary);">
                        {{ $offre->date_limite ? $offre->date_limite->format('d/m/Y') : 'Non précisée' }}
                    </span>
                </div>

                <div style="display:flex;justify-content:space-between;margin-bottom:16px;">
                    <span style="font-size:12px;color:var(--text-secondary);">Vues</span>
                    <span style="font-size:12px;font-weight:500;color:var(--text-primary);">
                        {{ $offre->vues }} vue(s)
                    </span>
                </div>

                @if($offre->is_active)
                    <a href="{{ route('etudiant.offres.postuler', $offre->id) }}"
                       class="btn-primary"
                       style="display:block;text-align:center;color:white;padding:12px;border-radius:10px;text-decoration:none;font-weight:500;font-size:14px;margin-bottom:8px;">
                        Postuler à cette offre
                    </a>
                @else
                    <div style="background:#f1f5f9;border-radius:10px;padding:12px;text-align:center;">
                        <p style="font-size:13px;color:var(--text-secondary);">Offre fermée</p>
                    </div>
                @endif

                <a href="{{ route('etudiant.offres') }}"
                   style="display:block;text-align:center;border:1px solid var(--border-color);color:var(--text-secondary);padding:10px;border-radius:10px;text-decoration:none;font-size:13px;margin-top:8px;">
                    Voir d'autres offres
                </a>

            </div>

        </div>

    </div>

</div>

{{-- Script favoris --}}
<script>
async function toggleFavori(offreId, btn) {
    try {
        const response = await fetch(`/etudiant/favoris/${offreId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        const data = await response.json();
        if (data.success) {
            btn.textContent = data.favori ? '❤️' : '🤍';
        }
    } catch (e) {
        console.error(e);
    }
}
</script>

@endsection