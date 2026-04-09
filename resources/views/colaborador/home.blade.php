@extends('layouts.app')
@section('title', 'Panel Colaborador')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-heading font-bold mb-2 text-green-400">Panel Colaborador</h1>
        <p class="text-gray-400">Administra Ofertas y Noticias.</p>
    </div>
    <a href="#" class="bg-green-600 hover:bg-green-700 py-2 px-4 rounded font-medium text-sm transition-colors text-white">
        + Nueva Noticia
    </a>
</div>

<div class="glass p-6 rounded-2xl border border-white/5">
    <p class="text-gray-400 italic">Módulo de gestión de noticias y ofertas en construcción.</p>
</div>
@endsection
