@extends('layouts.app')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary)">
            Mes offres favorites ❤️
        </h1>
        <p style="color:var(--text-secondary);font-size:14px;margin-top:4px;">
            {{ $offres->count() }} offre(s) sauvegardée(s)
        </p>
    </div>
    <a href="{{ route('etudiant.offres') }}"
       class="btn-primary"
       style="color:white;padding:8px 18px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;">
        Voir toutes les offres
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($offres as $offre)
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:22px;transition:all 0.3s ease;"
         onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 40px rgba(59,130,246,0.1)'"
         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">

        {{-- En-tête --}}
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:14px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <img src="{{ $offre->entreprise->avatar_url }}"
                     alt="{{ $offre->entreprise->name }}"
                     style="width:44px;height:44px;border-radius:10px;object-fit:cover;">
                <div>
                    <p style="font-size:14px;font-weight:600;color:var(--text-primary);">
                        {{ $offre->titre }}
                    </p>
                    <p style="font-size:12px;color:#3b82f6;margin-top:2px;">
                        {{ $offre->entreprise->name }}
                    </p>
                </div>
            </div>
            {{-- Supprimer des favoris --}}
            <button onclick="toggleFavori({{ $offre->id }}, this, event)"
                    style="font-size:20px;background:none;border:none;cursor:pointer;">
                ❤️
            </button>
        </div>

        {{-- Badges --}}
        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:14px;">
            <span style="background:#eff6ff;color:#1d4ed8;font-size:11px;padding:3px 10px;border-radius:20px;font-weight:500;">
                {{ $offre->domaine }}
            </span>
            <span style="background:#f0fdf4;color:#16a34a;font-size:11px;padding:3px 10px;border-radius:20px;font-weight:500;">
                {{ $offre->salaire_format }}
            </span>
            @php $badge = $offre->type_travail_badge; @endphp
            <span style="font-size:11px;padding:3px 10px;border-radius:20px;font-weight:500;
                         background:{{ $badge['color'] === 'green' ? '#f0fdf4' : ($badge['color'] === 'amber' ? '#fffbeb' : '#eff6ff') }};
                         color:{{ $badge['color'] === 'green' ? '#16a34a' : ($badge['color'] === 'amber' ? '#d97706' : '#1d4ed8') }};">
                {{ $badge['label'] }}
            </span>
        </div>

        {{-- Infos --}}
        <p style="font-size:12px;color:var(--text-secondary);margin-bottom:16px;">
            📍 {{ $offre->lieu }}
            @if($offre->duree) · ⏱ {{ $offre->duree }} @endif
        </p>

        {{-- Boutons --}}
        <div style="display:flex;gap:8px;">
            <a href="{{ route('etudiant.offres.show', $offre->id) }}"
               style="flex:1;text-align:center;border:1px solid var(--border-color);color:var(--text-primary);padding:8px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:500;">
                Voir l'offre
            </a>
            <a href="{{ route('etudiant.offres.postuler', $offre->id) }}"
               class="btn-primary"
               style="flex:1;text-align:center;color:white;padding:8px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:500;">
                Postuler
            </a>
        </div>

    </div>
    @empty
    <div class="col-span-3" style="text-align:center;padding:80px 20px;background:var(--bg-card);border-radius:16px;border:1px solid var(--border-color);">
        <p style="font-size:40px;margin-bottom:16px;">🤍</p>
        <p style="color:var(--text-secondary);font-size:15px;">
            Vous n'avez pas encore de favoris.
        </p>
        <a href="{{ route('etudiant.offres') }}"
           class="btn-primary"
           style="display:inline-block;color:white;padding:10px 24px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:500;margin-top:16px;">
            Découvrir les offres
        </a>
    </div>
    @endforelse

</div>

<script>
async function toggleFavori(offreId, btn, event) {
    const card = btn.closest('div[style]');
    try {
        const response = await fetch(`/etudiant/favoris/${offreId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });
        const data = await response.json();
        if (data.success && !data.favori) {
            // Retire la carte avec animation
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => card.remove(), 300);
        }
    } catch (e) {
        console.error(e);
    }
}
</script>

@endsection