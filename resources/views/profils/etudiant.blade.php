@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Bannière --}}
    <div style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;padding:40px;margin-bottom:24px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:250px;height:250px;border-radius:50%;background:white;opacity:0.04;"></div>
        <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;border-radius:50%;background:white;opacity:0.04;"></div>

        <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">

            {{-- Avatar --}}
            <img src="{{ $user->avatar_url }}"
                 style="width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.4);flex-shrink:0;">

            {{-- Infos principales --}}
            <div style="flex:1;">
                <h1 style="font-size:26px;font-weight:700;color:white;margin-bottom:4px;">
                    {{ $user->name }}
                </h1>

                @if($user->filiere || $user->niveau)
                <p style="color:rgba(255,255,255,0.85);font-size:15px;margin-bottom:12px;">
                    {{ $user->filiere }}
                    @if($user->filiere && $user->niveau) — @endif
                    {{ $user->niveau }}
                </p>
                @endif

                <div style="display:flex;gap:16px;flex-wrap:wrap;">
                    @if($user->universite)
                    <span style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;">
                        <x-icon name="graduation" :size="14" color="rgba(255,255,255,0.75)"/>
                        {{ $user->universite }}
                    </span>
                    @endif
                    @if($user->ville)
                    <span style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;">
                        <x-icon name="map-pin" :size="14" color="rgba(255,255,255,0.75)"/>
                        {{ $user->ville }}
                    </span>
                    @endif
                    @if($user->linkedin)
                    <a href="{{ $user->linkedin }}" target="_blank"
                       style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,0.75);font-size:13px;text-decoration:none;">
                        <x-icon name="linkedin" :size="14" color="rgba(255,255,255,0.75)"/>
                        LinkedIn
                    </a>
                    @endif
                </div>
            </div>

            {{-- Note moyenne --}}
            @if($evaluations->count() > 0)
            <div style="text-align:center;background:rgba(255,255,255,0.15);border-radius:16px;padding:20px 28px;backdrop-filter:blur(4px);">
                <p style="font-size:36px;font-weight:700;color:white;line-height:1;">
                    {{ number_format($user->note_moyenne, 1) }}
                </p>
                <div style="display:flex;gap:3px;justify-content:center;margin:8px 0;">
                    @for($i = 1; $i <= 5; $i++)
                    <x-icon name="star" :size="16"
                            :color="$i <= round($user->note_moyenne) ? '#fbbf24' : 'rgba(255,255,255,0.25)'"
                            :stroke="1"/>
                    @endfor
                </div>
                <p style="font-size:12px;color:rgba(255,255,255,0.65);">
                    {{ $evaluations->count() }} évaluation(s)
                </p>
            </div>
            @endif

        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Colonne gauche --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Contact --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="user" :size="15" color="#3b82f6"/>
                    Contact
                </h2>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;gap:10px;align-items:center;">
                        <x-icon name="mail" :size="15" color="#3b82f6"/>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $user->email }}</span>
                    </div>
                    @if($user->phone)
                    <div style="display:flex;gap:10px;align-items:center;">
                        <x-icon name="phone" :size="15" color="#3b82f6"/>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $user->phone }}</span>
                    </div>
                    @endif
                    @if($user->ville)
                    <div style="display:flex;gap:10px;align-items:center;">
                        <x-icon name="map-pin" :size="15" color="#3b82f6"/>
                        <span style="font-size:13px;color:var(--text-secondary);">{{ $user->ville }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Formation --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="graduation" :size="15" color="#3b82f6"/>
                    Formation
                </h2>

                @if($user->universite || $user->filiere || $user->niveau)
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @if($user->universite)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:2px;">Établissement</p>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">{{ $user->universite }}</p>
                    </div>
                    @endif
                    @if($user->filiere)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:2px;">Filière</p>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">{{ $user->filiere }}</p>
                    </div>
                    @endif
                    @if($user->niveau)
                    <div>
                        <p style="font-size:11px;color:var(--text-secondary);margin-bottom:2px;">Niveau</p>
                        <span style="display:inline-block;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:600;padding:3px 10px;border-radius:6px;">
                            {{ $user->niveau }}
                        </span>
                    </div>
                    @endif
                </div>
                @else
                <p style="font-size:13px;color:var(--text-secondary);font-style:italic;">
                    Informations de formation non renseignées
                </p>
                @endif
            </div>

            {{-- CV --}}
            @if($user->cv_path)
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:20px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="file" :size="15" color="#3b82f6"/>
                    CV
                </h2>
                <a href="{{ asset('storage/' . $user->cv_path) }}"
                   target="_blank"
                   style="display:flex;align-items:center;gap:10px;padding:12px;background:#eff6ff;border-radius:10px;text-decoration:none;border:1px solid #bfdbfe;">
                    <x-icon name="download" :size="18" color="#1d4ed8"/>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#1d4ed8;">Télécharger le CV</p>
                        <p style="font-size:11px;color:#3b82f6;">Format PDF</p>
                    </div>
                </a>
            </div>
            @endif

        </div>

        {{-- Colonne droite --}}
        <div class="md:col-span-2" style="display:flex;flex-direction:column;gap:16px;">

            {{-- Bio --}}
            @if($user->bio)
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
                <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                    <x-icon name="info" :size="15" color="#3b82f6"/>
                    À propos
                </h2>
                <p style="font-size:14px;color:var(--text-secondary);line-height:1.8;">{{ $user->bio }}</p>
            </div>
            @endif

            {{-- Statistiques --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:18px;text-align:center;">
                    <p style="font-size:28px;font-weight:700;color:#3b82f6;">
                        {{ $user->candidatures->count() ?? 0 }}
                    </p>
                    <p style="font-size:12px;color:var(--text-secondary);margin-top:4px;">Candidatures</p>
                </div>
                <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:18px;text-align:center;">
                    <p style="font-size:28px;font-weight:700;color:#10b981;">
                        {{ $user->candidatures->where('statut','acceptee')->count() ?? 0 }}
                    </p>
                    <p style="font-size:12px;color:var(--text-secondary);margin-top:4px;">Acceptées</p>
                </div>
                <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:18px;text-align:center;">
                    <p style="font-size:28px;font-weight:700;color:#f59e0b;">
                        {{ number_format($user->note_moyenne, 1) }}
                    </p>
                    <p style="font-size:12px;color:var(--text-secondary);margin-top:4px;">Note moyenne</p>
                </div>
            </div>

            {{-- Évaluations --}}
            <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;">
                <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);">
                    <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);display:flex;align-items:center;gap:8px;">
                        <x-icon name="star" :size="15" color="#f59e0b" :stroke="1"/>
                        Évaluations reçues ({{ $evaluations->count() }})
                    </h2>
                </div>

                @forelse($evaluations as $eval)
                <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);">
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:10px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="{{ $eval->evaluateur->avatar_url }}"
                                 style="width:36px;height:36px;border-radius:8px;object-fit:cover;">
                            <div>
                                <p style="font-size:13px;font-weight:500;color:var(--text-primary);">
                                    {{ $eval->evaluateur->name }}
                                </p>
                                <p style="font-size:11px;color:var(--text-secondary);">
                                    {{ $eval->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex;gap:2px;align-items:center;">
                            @for($i = 1; $i <= 5; $i++)
                            <x-icon name="star" :size="16"
                                    :color="$i <= $eval->note ? '#f59e0b' : 'var(--border-color)'"
                                    :stroke="1"/>
                            @endfor
                            <span style="font-size:13px;font-weight:600;color:var(--text-primary);margin-left:6px;">
                                {{ $eval->note }}/5
                            </span>
                        </div>
                    </div>
                    @if($eval->commentaire)
                    <div style="background:var(--bg-secondary);border-radius:8px;padding:12px;">
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
                        Aucune évaluation pour le moment
                    </p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@endsection