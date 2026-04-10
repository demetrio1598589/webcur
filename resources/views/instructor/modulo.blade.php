@extends('layouts.app')
@section('title', 'Gestionar: ' . $modulo->titulo)

@section('content')

{{-- ── BREADCRUMB ── --}}
<nav class="flex items-center gap-2 text-xs text-gray-500 mb-5">
    <a href="{{ route('instructor.cursos') }}" class="hover:text-gray-300 transition-colors">Mis Cursos</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('instructor.modulos', $curso->id_curso) }}" class="hover:text-gray-300 transition-colors">{{ $curso->titulo }}</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-gray-300">{{ $modulo->titulo }}</span>
</nav>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

    {{-- ══════════════════════════════════════════
         COLUMNA IZQUIERDA (2/5): EDITAR INFO
    ══════════════════════════════════════════ --}}
    <div class="xl:col-span-2 space-y-5">
        
        {{-- Card: Información del Módulo --}}
        <div class="glass rounded-xl border border-white/10 overflow-hidden">
            <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-mono font-bold text-sm
                        {{ $modulo->tipo === 'examen' ? 'bg-cta/20 text-cta' : 'bg-purple-500/20 text-purple-400' }}">
                        {{ $modulo->orden }}
                    </div>
                    <h2 class="text-sm font-heading font-semibold text-white">Editar Información</h2>
                </div>
                <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded
                    {{ $modulo->tipo === 'examen' ? 'bg-cta/15 text-cta border border-cta/20' : 'bg-purple-500/15 text-purple-400 border border-purple-500/20' }}">
                    {{ $modulo->tipo }}
                </span>
            </div>

            <div class="p-5">
                <form action="{{ route('instructor.modulos.update', $modulo->id_modulo) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Título <span class="text-red-400">*</span></label>
                        <input type="text" name="titulo" value="{{ $modulo->titulo }}" required
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Posición (Orden) <span class="text-red-400">*</span></label>
                        <input type="number" name="orden" value="{{ $modulo->orden }}" required min="1"
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors resize-none">{{ $modulo->descripcion }}</textarea>
                    </div>

                    @if($modulo->tipo === 'contenido')
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Actualizar Material PDF</label>
                        <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-white/10 hover:border-purple-500/50 rounded-lg cursor-pointer bg-white/3 transition-colors group">
                            <svg class="w-7 h-7 text-gray-500 group-hover:text-purple-400 transition-colors mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-xs text-gray-500 group-hover:text-gray-300 transition-colors" id="pdf-label">Actualizar archivo PDF</span>
                            <input type="file" name="pdf" accept=".pdf" class="hidden" onchange="document.getElementById('pdf-label').textContent = this.files[0].name">
                        </label>
                    </div>
                    @endif

                    <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-500 transition-all text-white text-sm font-medium py-2.5 rounded-lg shadow-[0_4px_12px_rgba(168,85,247,0.2)]">
                        Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        {{-- Botón peligroso: Eliminar --}}
        <form action="{{ route('instructor.modulos.delete', $modulo->id_modulo) }}" method="POST" 
              onsubmit="return confirm('¿Eliminar completamente este módulo? Esta acción es irreversible.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-2.5 text-xs font-semibold text-red-400 border border-red-500/30 hover:bg-red-500/10 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Eliminar Módulo del Curso
            </button>
        </form>

    </div>

    {{-- ══════════════════════════════════════════
         COLUMNA DERECHA (3/5): CONTENIDO / EXAMEN
    ══════════════════════════════════════════ --}}
    <div class="xl:col-span-3 space-y-5">

        @if($modulo->tipo === 'contenido')
            {{-- VISTA CONTENIDO PDF --}}
            <div class="glass rounded-xl border border-white/10 overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-sm font-heading font-semibold text-white">Material Actual</h3>
                </div>
                <div class="p-5">
                    @forelse($contenidos->where('tipo', 'pdf') as $con)
                        <div class="flex items-center justify-between p-4 bg-red-500/5 border border-red-500/20 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">{{ $con->titulo }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase">Documento PDF</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $con->url) }}" target="_blank"
                               class="px-4 py-2 bg-red-500 hover:bg-red-400 text-white text-xs font-bold rounded-lg transition-colors">
                                Ver Material
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <svg class="w-12 h-12 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6M9 17h3m-3-4l3 3m5-3H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-xs text-gray-500">No hay PDF cargado para este módulo.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            {{-- VISTA EXAMEN: CRUD PREGUNTAS --}}
            @if($examen)
                {{-- ─ Formulario agregar pregunta ─ --}}
                <div class="glass rounded-xl border border-white/10 overflow-hidden">
                    <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <h3 class="text-sm font-heading font-semibold text-white">Agregar Pregunta</h3>
                        </div>
                    </div>
                    <div class="p-5">
                        <form action="{{ route('instructor.preguntas.store', $examen->id_examen) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Enunciado de la Pregunta <span class="text-red-400">*</span></label>
                                    <textarea name="texto_pregunta" rows="2" required placeholder="¿Cuál es el resultado de...?"
                                        class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors resize-none"></textarea>
                                </div>

                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">Puntos <span class="text-red-400">*</span></label>
                                        <input type="number" name="puntos" min="1" value="10" required
                                            class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition-colors">
                                    </div>
                                    <div class="col-span-2 flex items-end">
                                        <p class="text-[10px] text-gray-600 pb-2 italic">Añade al menos 2 opciones y marca la correcta.</p>
                                    </div>
                                </div>

                                {{-- Opciones Dinámicas --}}
                                <div class="space-y-2" id="opciones-wrapper">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="correcta" value="0" required class="w-4 h-4 accent-cta">
                                        <input type="text" name="opciones[]" placeholder="Opción 1" required class="flex-1 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-cta">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="correcta" value="1" class="w-4 h-4 accent-cta">
                                        <input type="text" name="opciones[]" placeholder="Opción 2" required class="flex-1 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-cta">
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="addChoice()" class="text-[10px] text-purple-400 hover:text-white transition-colors border border-purple-500/30 px-2 py-1 rounded">+ Opción</button>
                                    <button type="button" onclick="removeChoice()" class="text-[10px] text-gray-500 hover:text-red-400 transition-colors border border-white/5 px-2 py-1 rounded">- Quitar última</button>
                                </div>

                                <button type="submit" class="w-full bg-cta hover:bg-cta/80 text-white text-xs font-bold py-2.5 rounded-lg shadow-[0_4px_12px_rgba(245,158,11,0.2)] transition-all">
                                    Añadir Pregunta al Examen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ─ Listado de Preguntas ─ --}}
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-gray-500 flex items-center gap-2 uppercase tracking-widest">
                        Preguntas Existentes ({{ $preguntas->count() }})
                    </h3>

                    @forelse($preguntas as $idx => $preg)
                        <div class="glass rounded-xl border border-white/5 overflow-hidden">
                            <div class="px-5 py-4 flex gap-4">
                                <span class="w-6 h-6 rounded bg-white/10 flex items-center justify-center text-[10px] font-bold text-gray-400 flex-shrink-0">
                                    {{ $idx + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white leading-relaxed">{{ $preg->texto_pregunta }}</p>
                                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach($opciones[$preg->id_pregunta] ?? [] as $op)
                                            <div class="px-3 py-1.5 rounded-lg text-[11px] flex items-center gap-2
                                                {{ $op->es_correcta ? 'bg-green-500/15 border border-green-500/30 text-green-300' : 'bg-white/3 border border-white/5 text-gray-500' }}">
                                                <div class="w-1.5 h-1.5 rounded-full {{ $op->es_correcta ? 'bg-green-400' : 'bg-gray-700' }}"></div>
                                                {{ $op->texto_opcion }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-[10px] text-gray-600 mt-3">{{ $preg->puntos }} puntos por esta pregunta.</p>
                                </div>
                                <form action="{{ route('instructor.preguntas.delete', $preg->id_pregunta) }}" method="POST" onsubmit="return confirm('¿Eliminar pregunta?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 flex items-center justify-center transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 glass rounded-xl border border-white/5">
                            <p class="text-xs text-gray-600">Este examen no tiene preguntas aún.</p>
                        </div>
                    @endforelse
                </div>
            @endif
        @endif

    </div>
</div>

<script>
    let choiceIndex = 2;
    function addChoice() {
        const wrapper = document.getElementById('opciones-wrapper');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2';
        div.innerHTML = `
            <input type="radio" name="correcta" value="${choiceIndex}" class="w-4 h-4 accent-cta">
            <input type="text" name="opciones[]" placeholder="Opción ${choiceIndex + 1}" required class="flex-1 bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-cta">
        `;
        wrapper.appendChild(div);
        choiceIndex++;
    }

    function removeChoice() {
        if (choiceIndex <= 2) return;
        const wrapper = document.getElementById('opciones-wrapper');
        wrapper.removeChild(wrapper.lastElementChild);
        choiceIndex--;
    }
</script>

@endsection
