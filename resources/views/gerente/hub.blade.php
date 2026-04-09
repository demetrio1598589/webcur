@extends('layouts.app')
@section('title', 'Hub Gerencial')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-heading font-bold mb-1">Hub Gerencial</h1>
        <p class="text-sm text-gray-400">Selecciona el submódulo.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="text-xs text-gray-400 hover:text-white transition-colors">← Volver al inicio</a>
</div>

<!-- 3 columnas en pantallas muy grandes, hasta 1 en móviles -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- CRUD Usuarios -->
    <a href="{{ route('gerente.users.index') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-cta group flex flex-col">
        <div class="h-20 bg-cta/10 relative overflow-hidden flex items-center justify-center">
            <svg class="w-8 h-8 text-cta/50 absolute -right-2 top-2 rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <div class="w-10 h-10 bg-cta/20 text-cta rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-base font-heading font-medium mb-1">Control Usuarios</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Crea, edita y asigna roles dinámicos a tu personal.</p>
        </div>
    </a>

    <!-- Estadisticas -->
    <a href="{{ route('gerente.estadisticas') }}" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-primary group flex flex-col">
        <div class="h-20 bg-primary/10 relative overflow-hidden flex items-center justify-center">
            <svg class="w-8 h-8 text-primary/40 absolute -left-2 top-2 -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <div class="w-10 h-10 bg-primary/20 text-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-base font-heading font-medium mb-1">Kpis y Métricas</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Visualiza el balance y la distribución de alumnos vs cursos.</p>
        </div>
    </a>

    <!-- Tareas -->
    <a href="#" class="glass rounded-xl overflow-hidden hover:-translate-y-1 transition-transform border border-white/5 hover:border-success group flex flex-col relative opacity-80 hover:opacity-100">
        <div class="absolute top-2 right-2 bg-success text-slate-900 text-[9px] px-1.5 py-0.5 font-bold rounded z-20">PRÓXIMO</div>
        <div class="h-20 bg-success/10 relative overflow-hidden flex items-center justify-center">
            <div class="w-10 h-10 bg-success/20 text-success rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
        <div class="p-4 flex-1">
            <h3 class="text-base font-heading font-medium mb-1 text-gray-300">Asignar Tareas</h3>
            <p class="text-xs text-gray-400 line-clamp-2">Envía notificaciones o tareas directamente a tu equipo.</p>
        </div>
    </a>
</div>
@endsection
