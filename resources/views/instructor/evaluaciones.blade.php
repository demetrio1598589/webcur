@extends('layouts.app')
@section('title', 'Banco de Evaluaciones — Instructor')

@section('content')

{{-- Inicializar variables para evitar errores de scope en analizadores estáticos --}}
@php
    $preguntasPorExamen = $preguntasPorExamen ?? collect();
    $modulosSinExamen   = $modulosSinExamen   ?? collect();
    $opciones           = $opciones           ?? collect();
@endphp
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-heading font-bold mb-1 text-cta">Banco de Evaluaciones</h1>
        <p class="text-sm text-gray-400">Vista general de todos tus exámenes por módulo. Entra a cada módulo para gestionar sus preguntas.</p>
    </div>
    <a href="{{ route('instructor.home') }}" class="text-xs text-gray-400 hover:text-white transition-colors">← Volver al Hub</a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── KPIs ── --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-cta">{{ $examenes->count() }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Exámenes</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        @php
            $totalPreguntas = 0;
            foreach ($examenes as $_e) {
                $totalPreguntas += isset($preguntasPorExamen[$_e->id_examen])
                    ? $preguntasPorExamen[$_e->id_examen]->count()
                    : 0;
            }
        @endphp
        <p class="text-2xl font-bold text-purple-400">{{ $totalPreguntas }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Preguntas totales</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-success">{{ $modulos->count() }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Módulos</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-gray-400">{{ $modulosSinExamen->count() }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Sin examen</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── EXÁMENES EXISTENTES ── --}}
    <div class="lg:col-span-2 space-y-5">
        <h2 class="text-sm font-heading font-semibold text-gray-300 flex items-center gap-2">
            <svg class="w-4 h-4 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            </svg>
            Exámenes creados
        </h2>

        @forelse($examenes as $examen)
        @php
            $numPreguntas = isset($preguntasPorExamen[$examen->id_examen]) ? $preguntasPorExamen[$examen->id_examen]->count() : 0;
            $puntajeTotal = isset($preguntasPorExamen[$examen->id_examen]) ? $preguntasPorExamen[$examen->id_examen]->sum('puntos') : 0;
        @endphp
        <div class="glass rounded-xl border border-white/10 overflow-hidden hover:border-cta/30 transition-colors">
            {{-- Header examen --}}
            <div class="flex items-start gap-4 px-5 py-4 border-b border-white/5">
                <div class="w-9 h-9 rounded-lg bg-cta/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-cta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-white">{{ $examen->titulo }}</p>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1">
                        <span class="text-xs text-gray-500">
                            <span class="text-gray-400">Módulo:</span> {{ $examen->modulo_orden }}. {{ $examen->modulo_titulo }}
                        </span>
                        <span class="text-gray-700">·</span>
                        <span class="text-xs text-gray-500">
                            <span class="text-gray-400">Curso:</span> {{ $examen->curso_titulo }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs {{ $numPreguntas > 0 ? 'text-purple-400' : 'text-gray-600' }}">
                            {{ $numPreguntas }} {{ $numPreguntas == 1 ? 'pregunta' : 'preguntas' }}
                        </span>
                        @if($puntajeTotal > 0)
                        <span class="text-gray-700 text-xs">·</span>
                        <span class="text-xs text-cta/70">{{ $puntajeTotal }} pts totales</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('instructor.modulo.detalle', [$examen->id_curso, $examen->id_modulo]) }}"
                    class="flex items-center gap-1.5 text-xs text-cta border border-cta/30 hover:bg-cta/10 transition-colors px-3 py-1.5 rounded-lg flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Gestionar
                </a>
            </div>

            {{-- Preview preguntas --}}
            @if(isset($preguntasPorExamen[$examen->id_examen]) && $preguntasPorExamen[$examen->id_examen]->count() > 0)
            <div class="px-5 py-3">
                <div class="space-y-2">
                    @foreach($preguntasPorExamen[$examen->id_examen]->take(3) as $preg)
                    <div class="flex items-start gap-2">
                        <span class="w-4 h-4 rounded-full bg-white/5 text-gray-500 text-[9px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">
                            {{ $loop->iteration }}
                        </span>
                        <p class="text-xs text-gray-400 line-clamp-1">{{ $preg->texto_pregunta }}</p>
                        <span class="text-[10px] text-gray-600 flex-shrink-0">{{ $preg->puntos }}p</span>
                    </div>
                    @endforeach
                    @if($preguntasPorExamen[$examen->id_examen]->count() > 3)
                    <p class="text-[10px] text-gray-600 pl-6">
                        + {{ $preguntasPorExamen[$examen->id_examen]->count() - 3 }} más...
                    </p>
                    @endif
                </div>
            </div>
            @else
            <div class="px-5 py-3">
                <p class="text-xs text-gray-600 italic">Sin preguntas aún. Entra al módulo para agregarlas.</p>
            </div>
            @endif
        </div>
        @empty
        <div class="glass rounded-xl border border-white/10 p-14 text-center">
            <svg class="w-12 h-12 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            </svg>
            <p class="text-gray-500 text-sm">No tienes exámenes creados aún.</p>
            <p class="text-gray-600 text-xs mt-1">Ve a la lista de módulos de cada curso para crear el primero.</p>
        </div>
        @endforelse
    </div>

    {{-- ── MÓDULOS SIN EXAMEN ── --}}
    <div class="lg:col-span-1">
        <div class="glass rounded-xl border border-white/10 overflow-hidden sticky top-20">
            <div class="px-5 py-4 border-b border-white/5 flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-sm font-heading font-semibold text-yellow-500/80">Módulos sin Examen</h2>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($modulosSinExamen as $m)
                <div class="flex items-center gap-3 px-4 py-3">
                    <span class="w-6 h-6 rounded-full bg-white/5 text-gray-500 text-[10px] font-bold flex items-center justify-center flex-shrink-0">
                        {{ $m->orden }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-300 truncate">{{ $m->titulo }}</p>
                        <p class="text-[10px] text-gray-600 truncate">{{ $m->curso_titulo }}</p>
                    </div>
                    <a href="{{ route('instructor.modulo.detalle', [$m->id_curso, $m->id_modulo]) }}"
                        class="text-[10px] text-cta border border-cta/30 hover:bg-cta/10 transition-colors px-2 py-1 rounded flex-shrink-0">
                        + Crear
                    </a>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <svg class="w-8 h-8 text-green-500/50 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-gray-500">¡Todos los módulos tienen examen!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
