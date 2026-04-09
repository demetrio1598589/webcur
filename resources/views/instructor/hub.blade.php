@extends('layouts.app')
@section('title', 'Hub Instructor')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-heading font-bold mb-1 text-purple-400">Hub Instructor</h1>
        <p class="text-sm text-gray-400">Panel de creador de contenido pedagógico.</p>
    </div>
    @if(Auth::user()->roles->count() > 1)
        <a href="{{ route('dashboard') }}" class="text-xs text-gray-400 hover:text-white transition-colors">← Volver al Selector de Roles</a>
    @endif
</div>

<!-- 3 columnas en pantallas muy grandes, hasta 1 en móviles -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- CRUD Cursos -->
    <a href="{{ route('instructor.cursos') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-purple-500 group flex flex-col">
        <div class="h-24 bg-purple-500/10 relative overflow-hidden flex items-center justify-center">
            <svg class="w-10 h-10 text-purple-500/30 absolute -right-2 top-2 rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <div class="w-12 h-12 bg-purple-500/20 text-purple-400 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(168,85,247,0.3)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
        <div class="p-5 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Cursos y Módulos</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Inicia un curso, diseña los temas y sube tu material en formato PDF.</p>
        </div>
    </a>

    <!-- Evaluaciones -->
    <a href="{{ route('instructor.evaluaciones') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-cta group flex flex-col">
        <div class="h-24 bg-cta/10 relative overflow-hidden flex items-center justify-center">
            <svg class="w-10 h-10 text-cta/30 absolute -left-2 top-2 -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="w-12 h-12 bg-cta/20 text-cta rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
        <div class="p-5 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Banco de Evaluaciones</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Genera cuestionarios para cada módulo con opciones múltiples.</p>
        </div>
    </a>

    <!-- Calificaciones -->
    <a href="{{ route('instructor.calificaciones') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-success group flex flex-col">
        <div class="h-24 bg-success/10 relative overflow-hidden flex items-center justify-center">
            <div class="w-12 h-12 bg-success/20 text-success rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
            </div>
        </div>
        <div class="p-5 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1 line-clamp-1">Gestión de Calificaciones</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Analiza y recalifica las pruebas enviadas por tus estudiantes.</p>
        </div>
    </a>
</div>
@endsection
