@extends('layouts.app')
@section('title', 'Mi Aprendizaje')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-heading font-bold mb-2 text-[#0ea5e9]">Mi Aprendizaje</h1>
    <p class="text-gray-400">Aquí puedes continuar con tus cursos inscritos.</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="#" class="glass rounded-xl overflow-hidden group hover:border-[#0ea5e9]/50 transition-colors border border-white/5">
        <div class="h-32 bg-[#0ea5e9]/20 group-hover:bg-[#0ea5e9]/30 transition-colors flex items-center justify-center">
            <span class="text-4xl">🐍</span>
        </div>
        <div class="p-6">
            <h3 class="font-heading font-medium text-lg mb-2">Python desde cero</h3>
            
            <div class="w-full bg-gray-800 rounded-full h-2.5 mb-2 mt-4">
                <div class="bg-green-500 h-2.5 rounded-full" style="width: 50%"></div>
            </div>
            <p class="text-xs text-gray-400 text-right">50% Completado</p>
        </div>
    </a>
</div>
@endsection
