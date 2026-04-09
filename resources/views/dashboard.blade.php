@extends('layouts.app')
@section('title', 'Dashboard Principal')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold mb-1">Bienvenido, {{ Auth::user()->nombre }}</h1>
    <p class="text-sm text-gray-400">Selecciona el área de trabajo a la que deseas acceder.</p>
</div>

<!-- 4 columnas en 1080p (xl), 3 en laptops (lg), 2 en tablets (sm) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    
    @if(Auth::user()->hasRole('estudiante'))
    <a href="{{ route('estudiante.home') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-primary/20 hover:border-primary group flex flex-col">
        <div class="h-24 overflow-hidden relative">
            <div class="absolute inset-0 bg-primary/20 group-hover:bg-primary/30 transition-colors z-10"></div>
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="Estudiante">
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="w-10 h-10 bg-slate-900/80 rounded-full flex items-center justify-center text-primary backdrop-blur">📚</div>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Mis Cursos</h3>
            <p class="text-xs text-gray-400">Continúa aprendiendo, revisa tus progresos y certificados.</p>
        </div>
    </a>
    @endif

    @if(Auth::user()->hasRole('instructor'))
    <a href="{{ route('instructor.home') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-purple-500/20 hover:border-purple-500 group flex flex-col">
        <div class="h-24 overflow-hidden relative">
            <div class="absolute inset-0 bg-purple-500/20 group-hover:bg-purple-500/30 transition-colors z-10"></div>
            <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="Instructor">
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="w-10 h-10 bg-slate-900/80 rounded-full flex items-center justify-center text-purple-400 backdrop-blur">🎓</div>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Panel de Instructor</h3>
            <p class="text-xs text-gray-400">Sube cursos en PDF y administra evaluaciones.</p>
        </div>
    </a>
    @endif

    @if(Auth::user()->hasRole('gerencia'))
    <a href="{{ route('gerente.home') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-yellow-500/20 hover:border-yellow-500 group flex flex-col">
        <div class="h-24 overflow-hidden relative">
            <div class="absolute inset-0 bg-yellow-500/20 group-hover:bg-yellow-500/30 transition-colors z-10"></div>
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="Gerencia">
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="w-10 h-10 bg-slate-900/80 rounded-full flex items-center justify-center text-yellow-400 backdrop-blur">💼</div>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Gerencia</h3>
            <p class="text-xs text-gray-400">Asigna roles, revisa métricas y crea usuarios.</p>
        </div>
    </a>
    @endif

    @if(Auth::user()->hasRole('colaborador'))
    <a href="{{ route('colaborador.home') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-green-500/20 hover:border-green-500 group flex flex-col">
        <div class="h-24 overflow-hidden relative">
            <div class="absolute inset-0 bg-green-500/20 group-hover:bg-green-500/30 transition-colors z-10"></div>
            <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="Colaborador">
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="w-10 h-10 bg-slate-900/80 rounded-full flex items-center justify-center text-green-400 backdrop-blur">📰</div>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Contenido</h3>
            <p class="text-xs text-gray-400">Publica ofertas y mantén las novedades activas.</p>
        </div>
    </a>
    @endif

    @if(Auth::user()->hasRole('admin'))
    <a href="{{ route('admin.home') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-red-500/20 hover:border-red-500 group flex flex-col">
        <div class="h-24 overflow-hidden relative">
            <div class="absolute inset-0 bg-red-500/20 group-hover:bg-red-500/30 transition-colors z-10"></div>
            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all" alt="Admin">
            <div class="absolute inset-0 z-20 flex items-center justify-center">
                <div class="w-10 h-10 bg-slate-900/80 rounded-full flex items-center justify-center text-red-500 backdrop-blur">⚙️</div>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-lg font-heading font-medium mb-1">Sistema</h3>
            <p class="text-xs text-gray-400">Respaldos y configuraciones de Super Admin.</p>
        </div>
    </a>
    @endif

</div>
@endsection