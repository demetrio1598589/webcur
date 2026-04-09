@extends('layouts.app')
@section('title', 'Estadísticas')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-heading font-bold mb-2 text-primary">Estadísticas de Plataforma</h1>
        <p class="text-gray-400">Resumen y métricas clave de tus usuarios.</p>
    </div>
    <a href="{{ route('gerente.home') }}" class="glass hover:bg-white/5 transition-colors px-4 py-2 rounded text-sm text-gray-300">Volver al Hub</a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass p-6 rounded-2xl border-l-4 border-primary">
        <h3 class="text-gray-400 text-sm mb-1 uppercase tracking-wider font-semibold">Usuarios Totales</h3>
        <p class="text-4xl font-heading font-bold">{{ $totalUsuarios }}</p>
    </div>
    <div class="glass p-6 rounded-2xl border-l-4 border-cta">
        <h3 class="text-gray-400 text-sm mb-1 uppercase tracking-wider font-semibold">Cursos Activos</h3>
        <p class="text-4xl font-heading font-bold">{{ $totalCursos }}</p>
    </div>
    <div class="glass p-6 rounded-2xl border-l-4 border-success">
        <h3 class="text-gray-400 text-sm mb-1 uppercase tracking-wider font-semibold">Conversión Estimada</h3>
        <p class="text-4xl font-heading font-bold">12%</p>
        <p class="text-xs text-gray-500 mt-2">Dato sim.</p>
    </div>
    <div class="glass p-6 rounded-2xl border-l-4 border-purple-500">
        <h3 class="text-gray-400 text-sm mb-1 uppercase tracking-wider font-semibold">Ingresos Mes</h3>
        <p class="text-4xl font-heading font-bold text-white">S/ 4,200</p>
        <p class="text-xs text-gray-500 mt-2">Dato sim.</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="glass p-8 rounded-2xl border border-white/5">
        <h3 class="text-xl font-heading font-bold mb-6">Distribución por Roles</h3>
        <div class="space-y-4">
            @foreach($counts as $c)
            @php
                $percentage = $totalUsuarios > 0 ? round(($c->total / $totalUsuarios) * 100) : 0;
            @endphp
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-300 capitalize">{{ $c->nombre }}</span>
                    <span class="text-sm font-bold text-white">{{ $c->total }} <span class="text-gray-500 font-normal">({{ $percentage }}%)</span></span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="glass p-8 rounded-2xl border border-white/5 flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
        </div>
        <h3 class="text-xl font-heading font-bold mb-2">Más gráficas pronto</h3>
        <p class="text-gray-400 text-sm max-w-sm">Aquí integraremos el registro de inscripciones y ventas usando librerías como Chart.js en fases posteriores.</p>
    </div>
</div>
@endsection
