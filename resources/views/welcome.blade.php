@extends('layouts.app')

@section('content')

{{-- Hero section --}}
<div class="relative rounded-3xl overflow-hidden mb-16" style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #3b82f6 100%);">

    {{-- Cercles décoratifs --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10"
         style="background: white; transform: translate(30%, -30%)"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full opacity-10"
         style="background: white; transform: translate(-30%, 30%)"></div>

    <div class="relative px-12 py-20 text-center">
        <div class="inline-block bg-white bg-opacity-20 text-white text-xs font-medium px-4 py-2 rounded-full mb-6 border border-white border-opacity-30">
            Plateforme de gestion de stages au Maroc
        </div>
        <h1 class="text-5xl font-bold text-white mb-6 leading-tight">
            Trouvez votre stage<br>
            <span class="text-blue-200">idéal en quelques clics</span>
        </h1>
        <p class="text-blue-100 text-lg mb-10 max-w-xl mx-auto">
            StageConnect connecte les étudiants ambitieux avec les meilleures entreprises du Maroc.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}"
               class="bg-white text-blue-700 px-8 py-3 rounded-xl font-semibold hover:bg-blue-50 transition shadow-lg text-sm">
                Commencer gratuitement
            </a>
            <a href="{{ route('login') }}"
               class="border border-white border-opacity-50 text-white px-8 py-3 rounded-xl font-medium hover:bg-white hover:bg-opacity-10 transition text-sm">
                Se connecter
            </a>
        </div>
    </div>

</div>

{{-- Statistiques --}}
<div class="grid grid-cols-3 gap-6 mb-16">
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 card-hover">
        <p class="text-4xl font-bold gradient-text mb-1">500+</p>
        <p class="text-gray-500 text-sm">Offres de stage</p>
    </div>
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 card-hover">
        <p class="text-4xl font-bold gradient-text mb-1">200+</p>
        <p class="text-gray-500 text-sm">Entreprises partenaires</p>
    </div>
    <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 card-hover">
        <p class="text-4xl font-bold gradient-text mb-1">1000+</p>
        <p class="text-gray-500 text-sm">Étudiants inscrits</p>
    </div>
</div>

{{-- Fonctionnalités --}}
<div class="mb-16">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-3">
        Pourquoi choisir StageConnect ?
    </h2>
    <p class="text-gray-400 text-center text-sm mb-10">
        Une plateforme pensée pour simplifier la recherche de stage
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 card-hover">
            <div class="w-12 h-12 btn-primary rounded-xl flex items-center justify-center mb-5 shadow-md">
                <span class="text-2xl">🎓</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2 text-base">Pour les étudiants</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Parcourez des centaines d'offres, postulez en quelques clics et suivez vos candidatures en temps réel.
            </p>
        </div>

        <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 card-hover">
            <div class="w-12 h-12 btn-primary rounded-xl flex items-center justify-center mb-5 shadow-md">
                <span class="text-2xl">🏢</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2 text-base">Pour les entreprises</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Publiez vos offres de stage, gérez les candidatures reçues et trouvez les meilleurs talents.
            </p>
        </div>

        <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 card-hover">
            <div class="w-12 h-12 btn-primary rounded-xl flex items-center justify-center mb-5 shadow-md">
                <span class="text-2xl">🤖</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2 text-base">IA intégrée</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Générez automatiquement votre lettre de motivation grâce à notre IA, personnalisée pour chaque offre.
            </p>
        </div>

    </div>
</div>

{{-- CTA final --}}
<div class="rounded-3xl p-12 text-center" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
    <h2 class="text-2xl font-bold text-blue-900 mb-3">
        Prêt à trouver votre stage ?
    </h2>
    <p class="text-blue-600 text-sm mb-8">
        Rejoignez des milliers d'étudiants qui ont trouvé leur stage grâce à StageConnect
    </p>
    <a href="{{ route('register') }}"
       class="btn-primary text-white px-10 py-3 rounded-xl font-semibold shadow-lg text-sm inline-block">
        Créer mon compte gratuitement
    </a>
</div>

@endsection