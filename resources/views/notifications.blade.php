@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold" style="color:var(--text-primary)">
            Notifications
        </h1>
        @if($notifications->where('lue_at', null)->count() > 0)
        <form method="POST" action="{{ route('notifications.lireTout') }}">
            @csrf
            <button type="submit"
                    style="background:none;border:none;color:#3b82f6;font-size:13px;cursor:pointer;font-weight:500;">
                Tout marquer comme lu
            </button>
        </form>
        @endif
    </div>

    <div class="space-y-3">

        @forelse($notifications as $notif)
        <div style="background:var(--bg-card);border:1px solid {{ $notif->lue_at ? 'var(--border-color)' : '#bfdbfe' }};border-radius:14px;padding:18px;
                    {{ $notif->lue_at ? '' : 'border-left: 4px solid #3b82f6;' }}
                    display:flex;gap:14px;align-items:start;">

            {{-- Icône --}}
            <div style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        background:{{ $notif->couleur === 'green' ? '#f0fdf4' : ($notif->couleur === 'red' ? '#fef2f2' : ($notif->couleur === 'amber' ? '#fffbeb' : '#eff6ff')) }};">
                <span style="font-size:18px;">
                    {{ $notif->type === 'success' ? '✅' : ($notif->type === 'danger' ? '❌' : ($notif->type === 'warning' ? '⚠️' : 'ℹ️')) }}
                </span>
            </div>

            {{-- Contenu --}}
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:start;">
                    <p style="font-size:14px;font-weight:600;color:var(--text-primary);">
                        {{ $notif->titre }}
                    </p>
                    <span style="font-size:11px;color:var(--text-secondary);white-space:nowrap;margin-left:12px;">
                        {{ $notif->created_at->diffForHumans() }}
                    </span>
                </div>
                <p style="font-size:13px;color:var(--text-secondary);margin-top:4px;line-height:1.5;">
                    {{ $notif->message }}
                </p>
                @if($notif->lien)
                <a href="{{ $notif->lien }}"
                   style="font-size:12px;color:#3b82f6;text-decoration:none;margin-top:6px;display:inline-block;font-weight:500;">
                    Voir →
                </a>
                @endif
            </div>

            {{-- Marquer comme lu --}}
            @if(!$notif->lue_at)
            <form method="POST" action="{{ route('notifications.lire', $notif->id) }}">
                @csrf
                <button type="submit"
                        style="background:none;border:none;cursor:pointer;color:var(--text-secondary);font-size:18px;"
                        title="Marquer comme lu">
                    ●
                </button>
            </form>
            @endif

        </div>
        @empty
        <div style="text-align:center;padding:80px;background:var(--bg-card);border-radius:16px;border:1px solid var(--border-color);">
            <p style="font-size:40px;margin-bottom:12px;">🔔</p>
            <p style="color:var(--text-secondary);">Aucune notification pour le moment.</p>
        </div>
        @endforelse

    </div>

</div>

@endsection