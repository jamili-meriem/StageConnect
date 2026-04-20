@extends('layouts.app')

@section('content')

<div class="min-h-96 flex flex-col items-center justify-center text-center">

    <div class="text-8xl font-bold text-indigo-100 mb-4">403</div>

    <h1 class="text-2xl font-bold text-gray-800 mb-2">
        Accès interdit
    </h1>

    <p class="text-gray-500 mb-8">
        Vous n'avez pas les permissions nécessaires pour accéder à cette page.
    </p>

    <div class="flex gap-4">
        <a href="{{ url('/') }}"
           class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition text-sm">
            Retour à l'accueil
        </a>
        <a href="{{ url('/dashboard') }}"
           class="border border-gray-200 text-gray-600 px-6 py-3 rounded-lg hover:bg-gray-50 transition text-sm">
            Mon dashboard
        </a>
    </div>

</div>

@endsection