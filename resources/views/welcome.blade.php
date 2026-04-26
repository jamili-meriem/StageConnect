@extends('layouts.app')

@section('content')

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-10px); }
}
@keyframes pulse-ring {
    0%   { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}
@keyframes countUp {
    from { opacity: 0; transform: scale(0.5); }
    to   { opacity: 1; transform: scale(1); }
}
.animate-fade-up   { animation: fadeInUp 0.8s ease forwards; }
.animate-fade-left { animation: fadeInLeft 0.8s ease forwards; }
.animate-fade-right{ animation: fadeInRight 0.8s ease forwards; }
.animate-float     { animation: float 3s ease-in-out infinite; }
.delay-1 { animation-delay: 0.2s; opacity: 0; }
.delay-2 { animation-delay: 0.4s; opacity: 0; }
.delay-3 { animation-delay: 0.6s; opacity: 0; }
.delay-4 { animation-delay: 0.8s; opacity: 0; }
.delay-5 { animation-delay: 1.0s; opacity: 0; }

.card-3d {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}
.card-3d:hover {
    transform: translateY(-8px) rotateX(2deg);
    box-shadow: 0 24px 48px rgba(59,130,246,0.15);
}
.btn-shine {
    position: relative;
    overflow: hidden;
}
.btn-shine::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -60%;
    width: 30%;
    height: 200%;
    background: rgba(255,255,255,0.3);
    transform: skewX(-20deg);
    animation: shine 3s infinite;
}
@keyframes shine {
    0%   { left: -60%; }
    100% { left: 130%; }
}
</style>

{{-- Hero section --}}
<div style="background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 50%,#3b82f6 100%);border-radius:24px;padding:80px 40px;text-align:center;margin-bottom:48px;position:relative;overflow:hidden;">

    {{-- Cercles décoratifs animés --}}
    <div style="position:absolute;top:-80px;right:-80px;width:320px;height:320px;border-radius:50%;background:white;opacity:0.04;animation:float 6s ease-in-out infinite;"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:240px;height:240px;border-radius:50%;background:white;opacity:0.04;animation:float 4s ease-in-out infinite reverse;"></div>
    <div style="position:absolute;top:40%;left:5%;width:80px;height:80px;border-radius:50%;border:2px solid rgba(255,255,255,0.15);animation:pulse-ring 3s ease-out infinite;"></div>
    <div style="position:absolute;top:20%;right:8%;width:50px;height:50px;border-radius:50%;border:2px solid rgba(255,255,255,0.1);animation:pulse-ring 3s ease-out infinite 1.5s;"></div>

    {{-- Logo --}}
    <div class="animate-fade-up" style="display:flex;justify-content:center;margin-bottom:28px;">
        <img src="{{ asset('images/logo.svg') }}"
             alt="StageConnect"
             style="height:60px;width:auto;filter:brightness(0) invert(1);"
             class="animate-float">
    </div>

    {{-- Badge --}}
    <div class="animate-fade-up delay-1"
         style="display:inline-block;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:white;font-size:12px;font-weight:500;padding:6px 18px;border-radius:20px;margin-bottom:28px;letter-spacing:1.5px;backdrop-filter:blur(4px);">
        ✨ PLATEFORME DE GESTION DE STAGES AU MAROC
    </div>

    {{-- Titre --}}
    <h1 class="animate-fade-up delay-2"
        style="font-size:54px;font-weight:700;color:white;margin-bottom:20px;line-height:1.15;">
        Trouvez votre stage<br>
        <span style="color:#bfdbfe;font-weight:300;">idéal en quelques clics</span>
    </h1>

    {{-- Sous-titre --}}
    <p class="animate-fade-up delay-3"
       style="color:rgba(255,255,255,0.85);font-size:18px;margin-bottom:40px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.6;">
        StageConnect connecte les étudiants ambitieux avec les meilleures entreprises du Maroc grâce à l'intelligence artificielle.
    </p>

    {{-- Boutons --}}
    <div class="animate-fade-up delay-4"
         style="display:flex;justify-content:center;gap:16px;flex-wrap:wrap;">
        <a href="{{ route('register') }}"
           class="btn-shine"
           style="background:white;color:#1e40af;padding:14px 36px;border-radius:12px;font-weight:700;text-decoration:none;font-size:14px;box-shadow:0 8px 24px rgba(0,0,0,0.25);transition:transform 0.2s ease;"
           onmouseover="this.style.transform='scale(1.05)'"
           onmouseout="this.style.transform='scale(1)'">
            🚀 Commencer gratuitement
        </a>
        <a href="{{ route('login') }}"
           style="background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.4);color:white;padding:14px 36px;border-radius:12px;font-weight:500;text-decoration:none;font-size:14px;backdrop-filter:blur(4px);transition:all 0.2s ease;"
           onmouseover="this.style.background='rgba(255,255,255,0.25)'"
           onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            Se connecter →
        </a>
    </div>

    {{-- Stats dans le hero --}}
    <div class="animate-fade-up delay-5"
         style="display:flex;justify-content:center;gap:40px;margin-top:48px;padding-top:40px;border-top:1px solid rgba(255,255,255,0.15);">
        <div style="text-align:center;">
            <p style="font-size:28px;font-weight:700;color:white;" class="counter" data-target="500">0</p>
            <p style="font-size:12px;color:rgba(255,255,255,0.7);">Offres publiées</p>
        </div>
        <div style="text-align:center;">
            <p style="font-size:28px;font-weight:700;color:white;" class="counter" data-target="200">0</p>
            <p style="font-size:12px;color:rgba(255,255,255,0.7);">Entreprises</p>
        </div>
        <div style="text-align:center;">
            <p style="font-size:28px;font-weight:700;color:white;" class="counter" data-target="1000">0</p>
            <p style="font-size:12px;color:rgba(255,255,255,0.7);">Étudiants</p>
        </div>
        <div style="text-align:center;">
            <p style="font-size:28px;font-weight:700;color:white;" class="counter" data-target="95">0</p>
            <p style="font-size:12px;color:rgba(255,255,255,0.7);">% satisfaction</p>
        </div>
    </div>

</div>

{{-- Fonctionnalités --}}
<div style="margin-bottom:48px;">
    <div style="text-align:center;margin-bottom:40px;">
        <h2 class="animate-fade-up"
            style="font-size:30px;font-weight:700;color:var(--text-primary);margin-bottom:8px;">
            Pourquoi choisir StageConnect ?
        </h2>
        <p style="color:var(--text-secondary);font-size:14px;">
            Une plateforme pensée pour simplifier la recherche de stage
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="card-3d animate-fade-left"
             style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:20px;padding:32px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:26px;box-shadow:0 8px 20px rgba(59,130,246,0.3);">
                🎓
            </div>
            <h3 style="font-size:17px;font-weight:600;color:var(--text-primary);margin-bottom:10px;">
                Pour les étudiants
            </h3>
            <p style="font-size:13px;color:var(--text-secondary);line-height:1.7;">
                Parcourez des centaines d'offres, postulez en quelques clics et suivez vos candidatures en temps réel.
            </p>
            <div style="margin-top:20px;display:flex;flex-direction:column;gap:6px;">
                @foreach(['Candidature simplifiée', 'Suivi en temps réel', 'Favoris et recommandations'] as $f)
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text-secondary);">
                    <span style="color:#10b981;font-size:14px;">✓</span> {{ $f }}
                </div>
                @endforeach
            </div>
        </div>

        <div class="card-3d animate-fade-up delay-1"
             style="background:linear-gradient(135deg,#1e40af,#2563eb);border-radius:20px;padding:32px;transform:scale(1.03);">
            <div style="width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:26px;">
                🤖
            </div>
            <h3 style="font-size:17px;font-weight:600;color:white;margin-bottom:10px;">
                IA intégrée
            </h3>
            <div style="background:rgba(255,255,255,0.1);border-radius:8px;padding:6px 12px;display:inline-block;margin-bottom:10px;">
                <span style="font-size:11px;color:#bfdbfe;font-weight:500;">✨ Propulsé par Groq LLaMA 3.3</span>
            </div>
            <p style="font-size:13px;color:rgba(255,255,255,0.85);line-height:1.7;">
                Générez votre lettre de motivation, obtenez des recommandations personnalisées et consultez notre chatbot.
            </p>
            <div style="margin-top:20px;display:flex;flex-direction:column;gap:6px;">
                @foreach(['Génération lettre auto', 'Chatbot conseiller 24/7', 'Recommandations IA'] as $f)
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,0.8);">
                    <span style="color:#bfdbfe;font-size:14px;">✓</span> {{ $f }}
                </div>
                @endforeach
            </div>
        </div>

        <div class="card-3d animate-fade-right"
             style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:20px;padding:32px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:26px;box-shadow:0 8px 20px rgba(59,130,246,0.3);">
                🏢
            </div>
            <h3 style="font-size:17px;font-weight:600;color:var(--text-primary);margin-bottom:10px;">
                Pour les entreprises
            </h3>
            <p style="font-size:13px;color:var(--text-secondary);line-height:1.7;">
                Publiez vos offres, gérez les candidatures reçues et trouvez les meilleurs talents.
            </p>
            <div style="margin-top:20px;display:flex;flex-direction:column;gap:6px;">
                @foreach(['Publication facile', 'Gestion candidatures', 'Évaluation stagiaires'] as $f)
                <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text-secondary);">
                    <span style="color:#10b981;font-size:14px;">✓</span> {{ $f }}
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Comment ça marche --}}
<div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:24px;padding:48px;margin-bottom:48px;">
    <h2 style="font-size:26px;font-weight:700;color:var(--text-primary);text-align:center;margin-bottom:40px;">
        Comment ça marche ?
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach([
            ['1', 'Créez votre compte', 'Inscrivez-vous en 2 minutes en tant qu\'étudiant ou entreprise', '👤'],
            ['2', 'Complétez votre profil', 'Ajoutez vos informations, CV et compétences', '📝'],
            ['3', 'Trouvez ou publiez', 'Parcourez les offres ou publiez vos stages', '🔍'],
            ['4', 'Postulez avec l\'IA', 'Générez votre lettre et postulez en 1 clic', '🚀'],
        ] as $step)
        <div style="text-align:center;position:relative;">
            <div style="width:64px;height:64px;background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;box-shadow:0 8px 20px rgba(59,130,246,0.3);">
                {{ $step[3] }}
            </div>
            <div style="position:absolute;top:30px;left:65%;width:35%;height:2px;background:linear-gradient(90deg,#3b82f6,transparent);display:{{ $loop->last ? 'none' : 'block' }};"></div>
            <p style="font-size:11px;font-weight:700;color:#3b82f6;margin-bottom:6px;letter-spacing:1px;">ÉTAPE {{ $step[0] }}</p>
            <p style="font-size:14px;font-weight:600;color:var(--text-primary);margin-bottom:6px;">{{ $step[1] }}</p>
            <p style="font-size:12px;color:var(--text-secondary);line-height:1.5;">{{ $step[2] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- CTA final --}}
<div style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:24px;padding:60px 40px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:white;opacity:0.04;"></div>
    <h2 style="font-size:30px;font-weight:700;color:white;margin-bottom:12px;">
        Prêt à trouver votre stage ? 🎓
    </h2>
    <p style="color:rgba(255,255,255,0.8);font-size:15px;margin-bottom:32px;">
        Rejoignez des milliers d'étudiants qui ont trouvé leur stage grâce à StageConnect
    </p>
    <a href="{{ route('register') }}"
       class="btn-shine"
       style="display:inline-block;background:white;color:#1e40af;padding:16px 48px;border-radius:12px;font-weight:700;text-decoration:none;font-size:15px;box-shadow:0 8px 24px rgba(0,0,0,0.2);transition:transform 0.2s;"
       onmouseover="this.style.transform='scale(1.05)'"
       onmouseout="this.style.transform='scale(1)'">
        Créer mon compte gratuitement →
    </a>
</div>

{{-- Script compteur animé --}}
<script>
// Anime les compteurs quand ils sont visibles
const counters = document.querySelectorAll('.counter');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = parseInt(entry.target.dataset.target);
            let current = 0;
            const increment = target / 60;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                entry.target.textContent = Math.floor(current) + (target >= 100 ? '+' : '%');
            }, 20);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

counters.forEach(c => observer.observe(c));

// Anime les éléments au scroll
const animElements = document.querySelectorAll('.animate-fade-up, .animate-fade-left, .animate-fade-right');
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'none';
        }
    });
}, { threshold: 0.1 });

animElements.forEach(el => scrollObserver.observe(el));
</script>

@endsection