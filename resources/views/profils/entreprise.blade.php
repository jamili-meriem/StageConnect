@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Bannière --}}
    <div style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;padding:40px;margin-bottom:24px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:250px;height:250px;border-radius:50%;background:white;opacity:0.04;"></div>

        <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">

            <img src="{{ $user->avatar_url }}"
                 style="width:96px;height:96px;border-radius:20px;object-fit:cover;border:3px solid rgba(255,255,255,0.4);flex-shrink:0;">

            <div style="flex:1;">
                <h1 style="font-size:26px;font-weight:700;color:white;margin-bottom:4px;">
                    {{ $user->name }}
                </h1>
                @if($user->secteur)
                <p style="color:rgba(255,255,255,0.85);font-size:15px;margin-bottom:12px;">
                    {{ $user->secteur }}
                </p>
                @endif
                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    @if($user->ville)
                    <span style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;">
                        <x-icon name="map-pin" :size="14" color="rgba(255,255,255,0.75)"/>
                        {{ $user->ville }}
                    </span>
                    @endif
                    @if($user->taille_entreprise)
                    <span style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;">
                        <x-icon name="users" :size="14" color="rgba(255,255,255,0.75)"/>
                        {{ $user->taille_entreprise }}
                    </span>
                    @endif
                    @if($user->site_web)
                    <a href="{{ $user->site_web }}" target="_blank"
                       style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;text-decoration:none;">
                        <x-icon name="globe" :size="14" color="rgba(255,255,255,0.75)"/>
                        {{ parse_url($user->site_web, PHP_URL_HOST) ?? $user->site_web }}
                    </a>
                    @endif
                </div>
            </div>

            {{-- Stats rapides --}}
            <div style="display:flex;gap:12px;">
                <div style="text-align:center;background:rgba(255,255,255,0.15);border-radius:14px;padding:16px 20px;backdrop-filter:blur(4px);">
                    <p style="font-size:28px;font-weight:700;color:white;">{{ $offres->count() }}</p>
                    <p style="font-size:11px;color:rgba(255,255,255,0.65);margin-top:4px;">Offres actives</p>
                </div>
                @if($evaluations->count() > 0)
                <div style="text-align:center;background:rgba(255,255,255,0.15);border-radius:14px;padding:16px 20px;backdrop-filter:blur(4px);">
                    <p style="font-size:28px;font-weight:700;color:white;">{{ number_format($user->note_moyenne, 1) }}</p>
                    <div style="display:flex;gap:2px;justify-content:center;margin:4px 0;">
                        @for($i = 1; $i <= 5; $i++)
                        <x-icon name="star" :size="12" :color="$i <= round($user->note_moyenne) ? '#fbbf24' : 'rgba(255,255,255,0.25)'" :stroke="1"/>
                        @endfor
                    </div>
                    <p style="font-size:11px;color:rgba(255,255,255,0.65);">{{ $evaluations->count() }} avis</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Colonne gauche --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- À propos --}}
            @if($user->bio)
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="info" :size="15" color="#3b82f6"/>
                    À propos
                </h2>
                <p style="font-size:13px;color:var(--text-secondary);line-height:1.7;">{{ $user->bio }}</p>
            </div>
            @endif

            {{-- Informations --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="building" :size="15" color="#3b82f6"/>
                    Informations
                </h2>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @if($user->secteur)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:3px;">Secteur</p>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">{{ $user->secteur }}</p>
                    </div>
                    @endif
                    @if($user->taille_entreprise)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:3px;">Taille</p>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">{{ $user->taille_entreprise }}</p>
                    </div>
                    @endif
                    @if($user->adresse || $user->ville)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:3px;">Adresse</p>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">
                            {{ $user->adresse }}{{ $user->adresse && $user->ville ? ', ' : '' }}{{ $user->ville }}
                        </p>
                    </div>
                    @endif
                    @if($user->email)
                    <div style="display:flex;gap:8px;align-items:center;">
                        <x-icon name="mail" :size="14" color="#3b82f6"/>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $user->email }}</span>
                    </div>
                    @endif
                    @if($user->phone)
                    <div style="display:flex;gap:8px;align-items:center;">
                        <x-icon name="phone" :size="14" color="#3b82f6"/>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $user->phone }}</span>
                    </div>
                    @endif
                    @if($user->site_web)
                    <div style="display:flex;gap:8px;align-items:center;">
                        <x-icon name="globe" :size="14" color="#3b82f6"/>
                        <a href="{{ $user->site_web }}" target="_blank"
                           style="font-size:13px;color:#3b82f6;text-decoration:none;">
                            {{ parse_url($user->site_web, PHP_URL_HOST) }}
                        </a>
                    </div>
                    @endif
                </div>

                @if($user->latitude && $user->longitude)
                <a href="https://www.google.com/maps?q={{ $user->latitude }},{{ $user->longitude }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:8px;margin-top:16px;padding:10px 14px;background:#eff6ff;border-radius:10px;text-decoration:none;border:1px solid #bfdbfe;">
                    <x-icon name="map-pin" :size="14" color="#1d4ed8"/>
                    <span style="font-size:12px;color:#1d4ed8;font-weight:500;">Voir sur Google Maps</span>
                </a>
                @elseif($user->adresse)
                <a href="https://www.google.com/maps/search/{{ urlencode($user->adresse . ' ' . $user->ville) }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:8px;margin-top:16px;padding:10px 14px;background:#eff6ff;border-radius:10px;text-decoration:none;border:1px solid #bfdbfe;">
                    <x-icon name="map-pin" :size="14" color="#1d4ed8"/>
                    <span style="font-size:12px;color:#1d4ed8;font-weight:500;">Voir sur Google Maps</span>
                </a>
                @endif
            </div>

        </div>

        {{-- Colonne droite --}}
        <div class="md:col-span-2" style="display:flex;flex-direction:column;gap:16px;">

            {{-- Offres --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;">
                <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);display:flex;justify-content:space-between;align-items:center;">
                    <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);display:flex;align-items:center;gap:8px;">
                        <x-icon name="briefcase" :size="15" color="#3b82f6"/>
                        Offres de stage ({{ $offres->count() }})
                    </h2>
                </div>

                @forelse($offres as $offre)
                <a href="{{ route('etudiant.offres.show', $offre->id) }}"
                   style="display:block;padding:18px 20px;border-bottom:1px solid var(--border-color);text-decoration:none;transition:background 0.2s;"
                   onmouseover="this.style.background='var(--bg-secondary)'"
                   onmouseout="this.style.background='transparent'">
                    <div style="display:flex;justify-content:space-between;align-items:start;">
                        <div style="flex:1;">
                            <p style="font-size:14px;font-weight:500;color:var(--text-primary);margin-bottom:8px;">
                                {{ $offre->titre }}
                            </p>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span style="font-size:11px;background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:6px;font-weight:500;">
                                    {{ $offre->domaine }}
                                </span>
                                <span style="display:flex;align-items:center;gap:4px;font-size:12px;color:var(--text-secondary);">
                                    <x-icon name="map-pin" :size="11" color="var(--text-secondary)"/>
                                    {{ $offre->lieu }}
                                </span>
                                @if($offre->duree)
                                <span style="display:flex;align-items:center;gap:4px;font-size:12px;color:var(--text-secondary);">
                                    <x-icon name="clock" :size="11" color="var(--text-secondary)"/>
                                    {{ $offre->duree }}
                                </span>
                                @endif
                                @if($offre->salaire_min)
                                <span style="font-size:12px;color:#16a34a;font-weight:500;">
                                    {{ $offre->salaire_format }}
                                </span>
                                @endif
                                @php $badge = $offre->type_travail_badge; @endphp
                                <span style="font-size:11px;padding:3px 10px;border-radius:6px;font-weight:500;
                                             background:{{ $badge['color'] === 'green' ? '#f0fdf4' : ($badge['color'] === 'amber' ? '#fffbeb' : '#eff6ff') }};
                                             color:{{ $badge['color'] === 'green' ? '#16a34a' : ($badge['color'] === 'amber' ? '#d97706' : '#1d4ed8') }};">
                                    {{ $badge['label'] }}
                                </span>
                            </div>
                        </div>
                        <x-icon name="arrow-right" :size="16" color="var(--text-secondary)"/>
                    </div>
                </a>
                @empty
                <div style="padding:40px;text-align:center;">
                    <x-icon name="briefcase" :size="32" color="var(--border-color)"/>
                    <p style="font-size:13px;color:var(--text-secondary);margin-top:12px;">Aucune offre active</p>
                </div>
                @endforelse
            </div>

            {{-- Évaluations --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;">
                <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);">
                    <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);display:flex;align-items:center;gap:8px;">
                        <x-icon name="star" :size="15" color="#f59e0b" :stroke="1"/>
                        Avis sur cette entreprise ({{ $evaluations->count() }})
                    </h2>
                </div>

                @forelse($evaluations as $eval)
                <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);">
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:10px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $eval->evaluateur->avatar_url }}"
                                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                            <div>
                                <p style="font-size:13px;font-weight:500;color:var(--text-primary);">
                                    {{ $eval->evaluateur->name }}
                                </p>
                                <p style="font-size:11px;color:var(--text-secondary);">
                                    {{ $eval->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:4px;">
                            @for($i = 1; $i <= 5; $i++)
                            <x-icon name="star" :size="15" :color="$i <= $eval->note ? '#f59e0b' : 'var(--border-color)'" :stroke="1"/>
                            @endfor
                            <span style="font-size:13px;font-weight:600;color:var(--text-primary);margin-left:4px;">
                                {{ $eval->note }}/5
                            </span>
                        </div>
                    </div>
                    @if($eval->commentaire)
                    <div style="background:var(--bg-secondary);border-radius:8px;padding:12px;border-left:3px solid #3b82f6;">
                        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;">
                            "{{ $eval->commentaire }}"
                        </p>
                    </div>
                    @endif
                </div>
                @empty
                <div style="padding:40px;text-align:center;">
                    <x-icon name="star" :size="32" color="var(--border-color)" :stroke="1"/>
                    <p style="font-size:13px;color:var(--text-secondary);margin-top:12px;">
                        Aucun avis pour le moment
                    </p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@endsection