@extends('layouts.app')
@section('title', 'Gestionar Diplomado')

@section('content')

{{-- ── NAVEGACIÓN Y TÍTULO ── --}}
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div class="flex-1">
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
            <a href="{{ route('instructor.home') }}" class="hover:text-white transition-colors">Hub</a>
            <span>/</span>
            <a href="{{ route('instructor.diplomados') }}" class="hover:text-white transition-colors">Diplomados</a>
            <span>/</span>
            <span class="text-cta font-bold">{{ $diplomado->nombre }}</span>
        </div>
        <h1 class="text-2xl font-heading font-bold text-white flex items-center gap-3">
            <span class="w-10 h-10 bg-cta/10 text-cta rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            </span>
            Gestión de Diplomado
        </h1>
    </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/30 text-green-300 text-xs flex items-center gap-2 animate-in fade-in slide-in-from-top-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

    {{-- ─ COLUMNA IZQUIERDA: Info del Diplomado (2/5) ─ --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="glass p-6 rounded-2xl border border-white/5 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-cta/5 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Información del Programa</h2>
            
            <form action="{{ route('instructor.diplomados.update', $diplomado->id_diplomado) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[10px] text-gray-600 mb-1 font-bold">NOMBRE</label>
                    <input type="text" name="nombre" value="{{ $diplomado->nombre }}" required
                        class="w-full bg-white/3 border border-white/5 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cta/50 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] text-gray-600 mb-1 font-bold">DESCRIPCIÓN</label>
                    <textarea name="descripcion" rows="4"
                        class="w-full bg-white/3 border border-white/5 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cta/50 transition-all resize-none">{{ $diplomado->descripcion }}</textarea>
                </div>
                <button type="submit" class="w-full bg-white/5 hover:bg-white/10 text-white text-xs font-bold py-3 rounded-xl border border-white/10 transition-all">
                    Guardar Cambios
                </button>
            </form>
        </div>

        <div class="glass p-6 rounded-2xl border border-white/5">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Agregar Curso</h2>
            <p class="text-[10px] text-gray-500 mb-4">Solo puedes agregar cursos que tú hayas creado y que no estén ya en el diplomado.</p>
            
            <form action="{{ route('instructor.diplomados.addCurso', $diplomado->id_diplomado) }}" method="POST" class="space-y-3">
                @csrf
                <select name="id_curso" required 
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white appearance-none focus:outline-none focus:border-cta transition-all cursor-pointer">
                    <option value="" disabled selected>Selecciona un curso...</option>
                    @foreach($cursosDisponibles as $cd)
                        <option value="{{ $cd->id_curso }}">{{ $cd->titulo }} ({{ $cd->nivel }})</option>
                    @endforeach
                </select>
                
                @if($cursosDisponibles->isEmpty())
                    <p class="text-[10px] text-cta/70 text-center italic">No hay más cursos disponibles para agregar.</p>
                @else
                    <button type="submit" class="w-full bg-cta text-white text-xs font-bold py-3 rounded-xl shadow-[0_4px_12px_rgba(245,158,11,0.2)] hover:bg-cta/80 transition-all">
                        Vincular al Diplomado
                    </button>
                @endif
            </form>
        </div>
    </div>

    {{-- ─ COLUMNA DERECHA: Lista de Cursos Asignados (3/5) ─ --}}
    <div class="lg:col-span-3 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-300 uppercase tracking-widest">Cursos Vinculados ({{ $cursosAsignados->count() }})</h2>
        </div>

        <div class="space-y-3">
            @forelse($cursosAsignados as $ca)
            <div class="glass p-4 rounded-xl border border-white/5 flex items-center justify-between group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-white/5 overflow-hidden flex items-center justify-center flex-shrink-0">
                        @if($ca->imagen)
                            <img src="{{ asset('storage/'.$ca->imagen) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-white group-hover:text-cta transition-colors">{{ $ca->titulo }}</h4>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] text-gray-500 px-1.5 py-0.5 rounded border border-white/5 uppercase">{{ $ca->nivel }}</span>
                            <span class="text-[10px] text-gray-600">{{ $ca->duracion_horas }} horas</span>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('instructor.diplomados.removeCurso', [$diplomado->id_diplomado, $ca->id_curso]) }}" method="POST" onsubmit="return confirm('¿Quitar este curso del diplomado?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-gray-600 hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-all" title="Quitar del diplomado">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-16 glass rounded-2xl border border-dashed border-white/10">
                <p class="text-xs text-gray-600 italic">No hay cursos en este diplomado.</p>
                <p class="text-[10px] text-gray-700 mt-1">Usa el panel de la izquierda para agregar tu primer curso.</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-6 bg-blue-500/5 border border-blue-500/10 rounded-2xl">
            <div class="flex gap-4">
                <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h5 class="text-xs font-bold text-blue-300 uppercase mb-1">Nota de Estructura</h5>
                    <p class="text-[11px] text-blue-200/60 leading-relaxed">
                        Un diplomado es una entidad organizativa. Al agregar un curso, le indicas al sistema que este forma parte de una ruta de aprendizaje. El estudiante deberá completar todos los cursos asignados para obtener la certificación del diplomado.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
