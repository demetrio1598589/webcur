@extends('layouts.app')
@section('title', 'Gestión de Calificaciones — Instructor')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-heading font-bold mb-1 text-success">Gestión de Calificaciones</h1>
        <p class="text-sm text-gray-400">Revisa y rectifica las notas de tus estudiantes.</p>
    </div>
    <a href="{{ route('instructor.home') }}" class="text-xs text-gray-400 hover:text-white transition-colors">← Volver al Hub</a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- KPI RÁPIDOS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $total    = $notas->count();
        $promedio = $total > 0 ? round($notas->avg('puntaje_obtenido'), 1) : 0;
        $max      = $total > 0 ? $notas->max('puntaje_obtenido') : 0;
        $min      = $total > 0 ? $notas->min('puntaje_obtenido') : 0;
    @endphp
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-success">{{ $total }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Evaluaciones</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-primary">{{ $promedio }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Promedio pts.</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-cta">{{ $max }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Puntaje máximo</p>
    </div>
    <div class="glass rounded-xl border border-white/10 p-4 text-center">
        <p class="text-2xl font-bold text-gray-400">{{ $min }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Puntaje mínimo</p>
    </div>
</div>

{{-- TABLA --}}
<div class="glass rounded-xl border border-white/10 overflow-hidden">
    @if($notas->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Estudiante</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Examen</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Curso</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-400 font-medium">Puntaje</th>
                    <th class="text-left px-5 py-3 text-xs text-gray-400 font-medium">Fecha</th>
                    <th class="text-center px-5 py-3 text-xs text-gray-400 font-medium">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($notas as $nota)
                <tr class="hover:bg-white/3 transition-colors group" id="row-{{ $nota->id_nota }}">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-primary/20 flex items-center justify-center text-primary text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($nota->nombre, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white text-xs font-medium">{{ $nota->nombre }} {{ $nota->apellido }}</p>
                                <p class="text-gray-600 text-[10px]">DNI: {{ $nota->dni }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-300">{{ $nota->examen_titulo }}</td>
                    <td class="px-5 py-3 text-xs text-gray-400 max-w-[160px] truncate">{{ $nota->curso_titulo }}</td>
                    <td class="px-5 py-3 text-center">
                        {{-- Vista estática --}}
                        <div id="static-{{ $nota->id_nota }}">
                            @php
                                $score = $nota->puntaje_obtenido;
                                $color = $score >= 70 ? 'text-success' : ($score >= 50 ? 'text-yellow-400' : 'text-red-400');
                            @endphp
                            <span class="text-lg font-bold {{ $color }}">{{ $score }}</span>
                        </div>
                        {{-- Inline edit --}}
                        <div id="edit-{{ $nota->id_nota }}" class="hidden">
                            <form action="{{ route('instructor.calificaciones.update', $nota->id_nota) }}" method="POST" class="flex items-center justify-center gap-1">
                                @csrf
                                @method('PUT')
                                <input type="number" name="puntaje_obtenido" value="{{ $nota->puntaje_obtenido }}" min="0"
                                    class="w-16 bg-white/10 border border-success/40 rounded px-1.5 py-1 text-xs text-white text-center focus:outline-none focus:border-success">
                                <button type="submit" class="text-success hover:text-green-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                <button type="button" onclick="cancelEdit({{ $nota->id_nota }})" class="text-gray-500 hover:text-gray-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($nota->fecha_examen)->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3 text-center">
                        <button onclick="openEdit({{ $nota->id_nota }})" id="btn-edit-{{ $nota->id_nota }}"
                            class="text-xs text-gray-400 hover:text-success border border-white/10 hover:border-success/40 transition-colors px-3 py-1 rounded-lg">
                            Editar Nota
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-14 text-center">
        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
        </svg>
        <p class="text-sm text-gray-500">Ningún estudiante ha rendido exámenes aún.</p>
    </div>
    @endif
</div>

<script>
    function openEdit(id) {
        document.getElementById('static-' + id).classList.add('hidden');
        document.getElementById('edit-' + id).classList.remove('hidden');
        document.getElementById('btn-edit-' + id).classList.add('hidden');
    }
    function cancelEdit(id) {
        document.getElementById('static-' + id).classList.remove('hidden');
        document.getElementById('edit-' + id).classList.add('hidden');
        document.getElementById('btn-edit-' + id).classList.remove('hidden');
    }
</script>
@endsection
