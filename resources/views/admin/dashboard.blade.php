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
        [
            'label' => 'Utilisateurs',
            'value' => $totalUsers,
            'color' => '#3b82f6',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>',
        ],
        [
            'label' => 'Étudiants',
            'value' => $totalEtudiants,
            'color' => '#06b6d4',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>',
        ],
        [
            'label' => 'Entreprises',
            'value' => $totalEntreprises,
            'color' => '#8b5cf6',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
        ],
        [
            'label' => 'Offres',
            'value' => $totalOffres,
            'color' => '#f59e0b',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>',
        ],
        [
            'label' => 'Candidatures',
            'value' => $totalCandidatures,
            'color' => '#10b981',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" width="26" height="26"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>',
        ],
    ] as $stat)
    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:14px;padding:20px;text-align:center;">
        <div style="display:flex;justify-content:center;margin-bottom:10px;">
            <div style="background:{{ $stat['color'] }};border-radius:12px;padding:10px;display:inline-flex;align-items:center;justify-content:center;">
                {!! $stat['icon'] !!}
            </div>
        </div>
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