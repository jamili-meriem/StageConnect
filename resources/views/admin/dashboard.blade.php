@extends('layouts.app')

@section('content')

{{-- En-tête --}}
<div style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;padding:32px;margin-bottom:32px;color:white;">
    <h1 style="font-size:24px;font-weight:700;margin-bottom:6px;">
        Tableau de bord Admin
    </h1>
    <p style="opacity:0.8;font-size:14px;">
        Vue globale de StageConnect — {{ now()->format('d/m/Y') }}
    </p>
</div>

{{-- Statistiques globales --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">

    @foreach([
        ['label' => 'Utilisateurs', 'value' => $totalUsers, 'icon' => '👥', 'color' => '#3b82f6'],
        ['label' => 'Étudiants', 'value' => $totalEtudiants, 'icon' => '🎓', 'color' => '#06b6d4'],
        ['label' => 'Entreprises', 'value' => $totalEntreprises, 'icon' => '🏢', 'color' => '#8b5cf6'],
        ['label' => 'Offres', 'value' => $totalOffres, 'icon' => '📋', 'color' => '#f59e0b'],
        ['label' => 'Candidatures', 'value' => $totalCandidatures, 'icon' => '📨', 'color' => '#10b981'],
    ] as $stat)
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:20px;text-align:center;">
        <div style="font-size:28px;margin-bottom:8px;">{{ $stat['icon'] }}</div>
        <p style="font-size:28px;font-weight:700;color:{{ $stat['color'] }};">
            {{ $stat['value'] }}
        </p>
        <p style="font-size:12px;color:var(--text-secondary);margin-top:4px;">
            {{ $stat['label'] }}
        </p>
    </div>
    @endforeach

</div>

{{-- Graphiques --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    {{-- Graphique candidatures par statut --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
        <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:20px;">
            Candidatures par statut
        </h2>
        <canvas id="chartStatuts" height="220"></canvas>
    </div>

    {{-- Graphique offres par domaine --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
        <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:20px;">
            Offres par domaine
        </h2>
        <canvas id="chartDomaines" height="220"></canvas>
    </div>

    {{-- Graphique inscriptions par mois --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
        <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:20px;">
            Inscriptions des 6 derniers mois
        </h2>
        <canvas id="chartInscriptions" height="220"></canvas>
    </div>

    {{-- Graphique répartition rôles --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;padding:24px;">
        <h2 style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:20px;">
            Répartition des utilisateurs
        </h2>
        <canvas id="chartRoles" height="220"></canvas>
    </div>

</div>

{{-- Tableaux côte à côte --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Derniers utilisateurs --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;">
        <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);display:flex;justify-content:space-between;align-items:center;">
            <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);">
                Derniers inscrits
            </h2>
            <a href="{{ route('admin.users') }}"
               style="font-size:12px;color:#3b82f6;text-decoration:none;font-weight:500;">
                Voir tous →
            </a>
        </div>
        <div>
            @foreach($derniersUsers as $user)
            <div style="padding:14px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-color);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <img src="{{ $user->avatar_url }}"
                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                    <div>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">
                            {{ $user->name }}
                        </p>
                        <p style="font-size:11px;color:var(--text-secondary);">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
                <span style="font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;
                             background:{{ $user->role === 'etudiant' ? '#eff6ff' : ($user->role === 'entreprise' ? '#f5f3ff' : '#fef3c7') }};
                             color:{{ $user->role === 'etudiant' ? '#1d4ed8' : ($user->role === 'entreprise' ? '#7c3aed' : '#92400e') }};">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Dernières offres --}}
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;">
        <div style="padding:18px 20px;border-bottom:1px solid var(--border-color);display:flex;justify-content:space-between;align-items:center;">
            <h2 style="font-size:14px;font-weight:600;color:var(--text-primary);">
                Dernières offres
            </h2>
            <a href="{{ route('admin.offres') }}"
               style="font-size:12px;color:#3b82f6;text-decoration:none;font-weight:500;">
                Voir toutes →
            </a>
        </div>
        <div>
            @foreach($dernieresOffres as $offre)
            <div style="padding:14px 20px;border-bottom:1px solid var(--border-color);">
                <div style="display:flex;justify-content:space-between;align-items:start;">
                    <div>
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);">
                            {{ $offre->titre }}
                        </p>
                        <p style="font-size:11px;color:var(--text-secondary);margin-top:2px;">
                            {{ $offre->entreprise->name }} — {{ $offre->lieu }}
                        </p>
                    </div>
                    <span style="font-size:11px;color:var(--text-secondary);white-space:nowrap;margin-left:8px;">
                        {{ $offre->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

<script>
const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
const textColor = isDark ? '#94a3b8' : '#64748b';
const gridColor = isDark ? '#334155' : '#e2e8f0';

Chart.defaults.color = textColor;
Chart.defaults.borderColor = gridColor;

// Graphique 1 — Candidatures par statut (Donut)
new Chart(document.getElementById('chartStatuts'), {
    type: 'doughnut',
    data: {
        labels: ['En attente', 'Acceptées', 'Refusées'],
        datasets: [{
            data: [
                {{ $candidaturesParStatut['en_attente'] ?? 0 }},
                {{ $candidaturesParStatut['acceptee'] ?? 0 }},
                {{ $candidaturesParStatut['refusee'] ?? 0 }},
            ],
            backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        cutout: '65%',
    }
});

// Graphique 2 — Offres par domaine (Bar horizontal)
new Chart(document.getElementById('chartDomaines'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($offresParDomaine->pluck('domaine')->map(fn($d) => ucfirst($d))) !!},
        datasets: [{
            label: 'Offres',
            data: {!! json_encode($offresParDomaine->pluck('total')) !!},
            backgroundColor: '#3b82f6',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: gridColor } },
            y: { grid: { display: false } },
        }
    }
});

// Graphique 3 — Inscriptions par mois (Line)
new Chart(document.getElementById('chartInscriptions'), {
    type: 'line',
    data: {
        labels: {!! json_encode($inscriptionsParMois->pluck('mois')) !!},
        datasets: [{
            label: 'Inscriptions',
            data: {!! json_encode($inscriptionsParMois->pluck('total')) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: gridColor }, beginAtZero: true },
        }
    }
});

// Graphique 4 — Répartition rôles (Pie)
new Chart(document.getElementById('chartRoles'), {
    type: 'pie',
    data: {
        labels: ['Étudiants', 'Entreprises', 'Admins'],
        datasets: [{
            data: [
                {{ $totalEtudiants }},
                {{ $totalEntreprises }},
                {{ $totalAdmins ?? 1 }},
            ],
            backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b'],
            borderWidth: 0,
            hoverOffset: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

@endsection