@extends('layouts.app')

@section('content')

{{-- En-tête --}}
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary)">
            Offres de stage
        </h1>
        <p style="color:var(--text-secondary);font-size:14px;margin-top:4px;">
            {{ $offres->total() }} offre(s) disponible(s)
        </p>
    </div>
    <a href="{{ route('etudiant.favoris') }}"
       style="display:flex;align-items:center;gap:6px;border:1px solid var(--border-color);color:var(--text-primary);padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;background:var(--bg-card);">
        ❤️ Mes favoris
    </a>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('etudiant.offres') }}"
      style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:20px;margin-bottom:24px;">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Recherche --}}
        <div style="md:col-span-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Titre, domaine, lieu..."
                   style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:9px 14px;font-size:13px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
        </div>

        {{-- Domaine --}}
        <div>
            <select name="domaine"
                    style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:9px 14px;font-size:13px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                <option value="">Tous les domaines</option>
                @foreach(['informatique', 'marketing', 'finance', 'rh', 'design', 'autre'] as $d)
                    <option value="{{ $d }}" {{ request('domaine') == $d ? 'selected' : '' }}>
                        {{ ucfirst($d) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Type travail --}}
        <div>
            <select name="type_travail"
                    style="width:100%;border:1px solid var(--border-color);border-radius:10px;padding:9px 14px;font-size:13px;background:var(--bg-secondary);color:var(--text-primary);outline:none;">
                <option value="">Tous les types</option>
                <option value="presentiel" {{ request('type_travail') == 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                <option value="remote" {{ request('type_travail') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="hybride" {{ request('type_travail') == 'hybride' ? 'selected' : '' }}>Hybride</option>
            </select>
        </div>

    </div>

    <div style="display:flex;gap:8px;margin-top:12px;">
        <button type="submit"
                class="btn-primary"
                style="color:white;padding:8px 20px;border-radius:10px;border:none;cursor:pointer;font-size:13px;font-weight:500;">
            Rechercher
        </button>
        @if(request()->anyFilled(['search', 'domaine', 'type_travail']))
        <a href="{{ route('etudiant.offres') }}"
           style="border:1px solid var(--border-color);color:var(--text-secondary);padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;">
            Effacer les filtres
        </a>
        @endif
        <a href="{{ route('etudiant.recommandations') }}"
           style="margin-left:auto;display:flex;align-items:center;gap:6px;background:#eff6ff;color:#1d4ed8;padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;">
            🤖 Recommandations IA
        </a>
    </div>

</form>

{{-- Grille des offres --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($offres as $offre)
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:22px;display:flex;flex-direction:column;justify-content:space-between;transition:all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 40px rgba(59,130,246,0.1)';this.style.borderColor='#93c5fd'"
         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none';this.style.borderColor='var(--border-color)'">

        <div>
            {{-- En-tête carte --}}
            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:14px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <img src="{{ $offre->entreprise->avatar_url }}"
                         alt="{{ $offre->entreprise->name }}"
                         style="width:42px;height:42px;border-radius:10px;object-fit:cover;">
                    <div>
                        <p style="font-size:13px;font-weight:600;color:var(--text-primary);">
                            {{ Str::limit($offre->titre, 30) }}
                        </p>
                        <p style="font-size:12px;color:#3b82f6;margin-top:2px;">
                            {{ $offre->entreprise->name }}
                        </p>
                    </div>
                </div>
                {{-- Bouton favori rapide --}}
                @auth
                <button onclick="toggleFavori({{ $offre->id }}, this)"
                        style="font-size:18px;background:none;border:none;cursor:pointer;flex-shrink:0;">
                    {{ auth()->user()->aEnFavori($offre->id) ? '❤️' : '🤍' }}
                </button>
                @endauth
            </div>

            {{-- Badges --}}
            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;">

                <span style="background:#eff6ff;color:#1d4ed8;font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;">
                    {{ $offre->domaine }}
                </span>

                @php $badge = $offre->type_travail_badge; @endphp
                <span style="font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;
                             background:{{ $badge['color'] === 'green' ? '#f0fdf4' : ($badge['color'] === 'amber' ? '#fffbeb' : '#eff6ff') }};
                             color:{{ $badge['color'] === 'green' ? '#16a34a' : ($badge['color'] === 'amber' ? '#d97706' : '#1d4ed8') }};">
                    {{ $badge['label'] }}
                </span>

                <span style="background:#f1f5f9;color:#475569;font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;">
                    {{ strtoupper($offre->niveau_requis) }}
                </span>

            </div>

            {{-- Infos --}}
            <div style="margin-bottom:12px;">
                <p style="font-size:12px;color:var(--text-secondary);margin-bottom:4px;">
                    📍 {{ $offre->lieu }}
                    @if($offre->duree) · ⏱ {{ $offre->duree }} @endif
                </p>

                {{-- Salaire --}}
                <p style="font-size:13px;font-weight:600;color:#16a34a;">
                    💰 {{ $offre->salaire_format }}
                </p>
            </div>

            {{-- Description courte --}}
            <p style="font-size:12px;color:var(--text-secondary);line-height:1.6;margin-bottom:14px;">
                {{ Str::limit($offre->description, 90) }}
            </p>

            {{-- Compétences --}}
            @if($offre->competences_requises && count($offre->competences_requises) > 0)
            <div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:14px;">
                @foreach(array_slice($offre->competences_requises, 0, 3) as $comp)
                <span style="background:var(--bg-secondary);border:1px solid var(--border-color);color:var(--text-primary);font-size:10px;padding:2px 8px;border-radius:6px;">
                    {{ $comp }}
                </span>
                @endforeach
                @if(count($offre->competences_requises) > 3)
                <span style="background:var(--bg-secondary);border:1px solid var(--border-color);color:var(--text-secondary);font-size:10px;padding:2px 8px;border-radius:6px;">
                    +{{ count($offre->competences_requises) - 3 }}
                </span>
                @endif
            </div>
            @endif

        </div>

        {{-- Footer carte --}}
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span style="font-size:11px;color:var(--text-secondary);">
                    {{ $offre->created_at->diffForHumans() }}
                </span>
                <span style="font-size:11px;color:var(--text-secondary);">
                    👁 {{ $offre->vues }} vues
                </span>
            </div>

            <div style="display:flex;gap:8px;">
                <a href="{{ route('etudiant.offres.show', $offre->id) }}"
                   style="flex:1;text-align:center;border:1px solid var(--border-color);color:var(--text-primary);padding:9px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:500;">
                    Voir détails
                </a>
                <a href="{{ route('etudiant.offres.postuler', $offre->id) }}"
                   class="btn-primary"
                   style="flex:1;text-align:center;color:white;padding:9px;border-radius:10px;text-decoration:none;font-size:12px;font-weight:500;">
                    Postuler
                </a>
            </div>
        </div>

    </div>
    @empty
    <div class="col-span-3" style="text-align:center;padding:80px;background:var(--bg-card);border-radius:16px;border:1px solid var(--border-color);">
        <p style="font-size:40px;margin-bottom:12px;">🔍</p>
        <p style="color:var(--text-secondary);font-size:15px;">
            @if(request()->anyFilled(['search', 'domaine', 'type_travail']))
                Aucune offre trouvée pour ces critères.
            @else
                Aucune offre disponible pour le moment.
            @endif
        </p>
    </div>
    @endforelse

</div>

{{-- Pagination --}}
<div style="margin-top:32px;">
    {{ $offres->links() }}
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