@extends('layouts.app')

@section('content')

<div class="min-h-96 flex flex-col items-center justify-center text-center">

    <div class="text-8xl font-bold text-indigo-100 mb-4">404</div>

    <h1 class="text-2xl font-bold text-gray-800 mb-2">
        Page introuvable
    </h1>

    <p class="text-gray-500 mb-8">
        La page que vous cherchez n'existe pas ou a été déplacée.
    </p>

    <a href="{{ url('/') }}"
       class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition text-sm">
        Retour à l'accueil
    </a>

</div>

@endsection