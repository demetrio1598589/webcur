@extends('layouts.app')
@section('title', 'Portal del Estudiante')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-heading font-bold text-white mb-1">¡Hola, {{ Auth::user()->nombre }}! 👋</h1>
        <p class="text-gray-400">¿Qué aprenderemos hoy? Tu camino hacia la maestría continúa aquí.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    
    {{-- Card 1: Disponibles --}}
    <a href="{{ route('estudiante.catalogo') }}" class="glass rounded-3xl overflow-hidden hover:-translate-y-2 transition-all duration-300 border border-white/5 hover:border-blue-500/50 group flex flex-col relative">
        <div class="h-40 bg-blue-500/10 relative overflow-hidden flex items-center justify-center">
            {{-- Fondo decorativo --}}
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all"></div>
            
            <div class="w-16 h-16 bg-blue-500 text-white rounded-2xl flex items-center justify-center transform group-hover:rotate-12 transition-transform shadow-lg shadow-blue-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <div class="p-8">
            <h3 class="text-xl font-heading font-bold text-white mb-2">Cursos Disponibles</h3>
            <p class="text-sm text-gray-400 leading-relaxed">Explora nuestro catálogo de diplomados y cursos premium de alta especialización.</p>
            <div class="mt-6 flex items-center text-blue-400 text-xs font-bold uppercase tracking-widest gap-2">
                Explorar catálogo
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </div>
    </a>

    {{-- Card 2: Mis Cursos --}}
    <a href="{{ route('estudiante.mis-cursos') }}" class="glass rounded-3xl overflow-hidden hover:-translate-y-2 transition-all duration-300 border border-white/5 hover:border-purple-500/50 group flex flex-col relative">
        <div class="h-40 bg-purple-500/10 relative overflow-hidden flex items-center justify-center">
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl group-hover:bg-purple-500/20 transition-all"></div>

            <div class="w-16 h-16 bg-purple-600 text-white rounded-2xl flex items-center justify-center transform group-hover:-rotate-12 transition-transform shadow-lg shadow-purple-600/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
        <div class="p-8">
            <h3 class="text-xl font-heading font-bold text-white mb-2">Mis Cursos</h3>
            <p class="text-sm text-gray-400 leading-relaxed">Continúa tus clases, revisa tus materiales corporativos y trackea tu progreso individual.</p>
            <div class="mt-6 flex items-center text-purple-400 text-xs font-bold uppercase tracking-widest gap-2">
                Continuar aprendizaje
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </div>
    </a>

    {{-- Card 3: Mis Diplomados --}}
    <a href="{{ route('estudiante.mis-diplomados') }}" class="glass rounded-3xl overflow-hidden hover:-translate-y-2 transition-all duration-300 border border-white/5 hover:border-cta/50 group flex flex-col relative">
        <div class="h-40 bg-cta/10 relative overflow-hidden flex items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-cta/5 to-transparent"></div>

            <div class="w-16 h-16 bg-cta text-white rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform shadow-lg shadow-cta/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
        </div>
        <div class="p-8">
            <h3 class="text-xl font-heading font-bold text-white mb-2">Mis Diplomados</h3>
            <p class="text-sm text-gray-400 leading-relaxed">Mira tus rutas de especialización completas y obtén tus certificados de diplomado.</p>
            <div class="mt-6 flex items-center text-cta text-xs font-bold uppercase tracking-widest gap-2">
                Ver programas
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </div>
        </div>
    </a>

</div>
@endsection
