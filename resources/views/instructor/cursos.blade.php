@extends('layouts.app')
@section('title', 'Mis Cursos — Instructor')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl font-heading font-bold mb-1 text-purple-400">Cursos y Módulos</h1>
        <p class="text-sm text-gray-400">Gestiona tus cursos y el material pedagógico de cada uno.</p>
    </div>
    <a href="{{ route('instructor.home') }}" class="text-xs text-gray-400 hover:text-white transition-colors">← Volver al Hub</a>
</div>

{{-- Mensajes flash --}}
@if(session('success'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- ── FORMULARIO CREAR CURSO ── --}}
<div class="glass rounded-xl border border-white/10 p-6 mb-8">
    <h2 class="text-base font-heading font-semibold mb-4 flex items-center gap-2">
        <span class="w-6 h-6 rounded-full bg-purple-500/30 text-purple-400 flex items-center justify-center text-xs">+</span>
        Crear Nuevo Curso
    </h2>
    <form action="{{ route('instructor.cursos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @csrf
        <div class="lg:col-span-2">
            <label class="block text-xs text-gray-400 mb-1">Título del Curso <span class="text-red-400">*</span></label>
            <input type="text" name="titulo" required placeholder="Ej: Python desde Cero"
                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-colors">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Nivel <span class="text-red-400">*</span></label>
            <select name="nivel" required class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors appearance-none">
                <option value="" disabled selected class="bg-slate-800">— Seleccionar —</option>
                <option value="basico" class="bg-slate-800">Básico</option>
                <option value="intermedio" class="bg-slate-800">Intermedio</option>
                <option value="avanzado" class="bg-slate-800">Avanzado</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">Duración (horas)</label>
            <input type="number" name="duracion_horas" min="1" placeholder="Ej: 40"
                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-colors">
        </div>
        <div class="md:col-span-2 lg:col-span-3">
            <label class="block text-xs text-gray-400 mb-1">Descripción</label>
            <textarea name="descripcion" rows="2" placeholder="Breve descripción del curso..."
                class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-colors resize-none"></textarea>
        </div>
        <div class="flex items-end">
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-500 transition-colors text-white text-sm font-medium py-2.5 rounded-lg shadow-[0_0_12px_rgba(168,85,247,0.3)] hover:shadow-[0_0_20px_rgba(168,85,247,0.5)]">
                Crear Curso
            </button>
        </div>
    </form>
</div>

{{-- ── LISTA DE CURSOS ── --}}
<div class="space-y-4">
    @forelse($cursos as $curso)
    <div class="glass rounded-xl border border-white/10 overflow-hidden" id="curso-{{ $curso->id_curso }}">
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-purple-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-sm text-white">{{ $curso->titulo }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-medium
                            {{ $curso->nivel === 'basico' ? 'bg-green-500/20 text-green-400' : ($curso->nivel === 'intermedio' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                            {{ ucfirst($curso->nivel) }}
                        </span>
                        @if($curso->duracion_horas)
                            <span class="text-[10px] text-gray-500">{{ $curso->duracion_horas }}h</span>
                        @endif
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-medium
                            {{ $curso->estado === 'activo' ? 'bg-success/20 text-success' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ ucfirst($curso->estado) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('instructor.modulos', $curso->id_curso) }}"
                    class="text-xs text-purple-400 border border-purple-500/40 hover:bg-purple-500/10 transition-colors px-3 py-1.5 rounded-lg">
                    Ver Módulos
                </a>
                <button onclick="toggleEdit('edit-{{ $curso->id_curso }}')"
                    class="text-xs text-gray-400 border border-white/10 hover:bg-white/10 transition-colors px-3 py-1.5 rounded-lg">
                    Editar
                </button>
            </div>
        </div>

        {{-- Formulario de edición --}}
        <div id="edit-{{ $curso->id_curso }}" class="hidden px-5 py-4 bg-white/3 border-t border-white/5">
            <form action="{{ route('instructor.cursos.update', $curso->id_curso) }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                @method('PUT')
                <div class="lg:col-span-2">
                    <label class="block text-xs text-gray-400 mb-1">Título</label>
                    <input type="text" name="titulo" value="{{ $curso->titulo }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Nivel</label>
                    <select name="nivel" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 appearance-none">
                        <option value="basico" {{ $curso->nivel == 'basico' ? 'selected' : '' }} class="bg-slate-800">Básico</option>
                        <option value="intermedio" {{ $curso->nivel == 'intermedio' ? 'selected' : '' }} class="bg-slate-800">Intermedio</option>
                        <option value="avanzado" {{ $curso->nivel == 'avanzado' ? 'selected' : '' }} class="bg-slate-800">Avanzado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Estado</label>
                    <select name="estado" class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 appearance-none">
                        <option value="activo" {{ $curso->estado == 'activo' ? 'selected' : '' }} class="bg-slate-800">Activo</option>
                        <option value="inactivo" {{ $curso->estado == 'inactivo' ? 'selected' : '' }} class="bg-slate-800">Inactivo</option>
                    </select>
                </div>
                <input type="hidden" name="duracion_horas" value="{{ $curso->duracion_horas }}">
                <div class="md:col-span-2 lg:col-span-4 flex gap-3">
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-500 transition-colors text-white text-xs font-medium px-5 py-2 rounded-lg">
                        Guardar Cambios
                    </button>
                    <button type="button" onclick="toggleEdit('edit-{{ $curso->id_curso }}')"
                        class="text-gray-400 hover:text-white text-xs px-4 py-2 rounded-lg border border-white/10 hover:bg-white/5 transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="glass rounded-xl border border-white/10 p-12 text-center">
        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
        </svg>
        <p class="text-gray-500 text-sm">Aún no tienes cursos. ¡Crea el primero!</p>
    </div>
    @endforelse
</div>

<script>
    function toggleEdit(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
    }
</script>
@endsection
