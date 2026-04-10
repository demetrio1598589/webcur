@extends('layouts.app')
@section('title', 'Módulos — ' . $curso->titulo)

@section('content')

{{-- ── CABECERA ── --}}
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <a href="{{ route('instructor.cursos') }}"
            class="text-xs text-gray-500 hover:text-gray-300 transition-colors flex items-center gap-1 mb-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Mis Cursos
        </a>
        <h1 class="text-2xl font-heading font-bold text-white">{{ $curso->titulo }}</h1>
        <p class="text-sm text-gray-400 mt-0.5">
            Diseña la estructura del curso: agrega módulos de contenido y evaluaciones en el orden que prefieras.
        </p>
    </div>
    <span class="text-[11px] px-3 py-1 rounded-full font-medium mt-1
        {{ $curso->nivel === 'basico' ? 'bg-green-500/20 text-green-400' : ($curso->nivel === 'intermedio' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
        {{ ucfirst($curso->nivel) }}
    </span>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-lg bg-green-500/20 border border-green-500/40 text-green-300 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- ══════════════════════════════════════════
         FORMULARIO — columna izquierda (2/5)
    ══════════════════════════════════════════ --}}
    <div class="lg:col-span-2">
        <div class="glass rounded-xl border border-white/10 p-5 sticky top-20">

            {{-- Toggle Tipo --}}
            <p class="text-xs text-gray-400 mb-2">¿Qué vas a agregar?</p>
            <div class="grid grid-cols-2 gap-2 mb-5" id="tipo-toggle">
                <button type="button" id="btn-contenido" onclick="setTipo('contenido')"
                    class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg border text-xs font-medium transition-all
                           bg-purple-500/25 border-purple-500/60 text-purple-300 shadow-[0_0_10px_rgba(168,85,247,0.2)]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Módulo
                </button>
                <button type="button" id="btn-examen" onclick="setTipo('examen')"
                    class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg border text-xs font-medium transition-all
                           bg-white/5 border-white/10 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Evaluación
                </button>
            </div>

            <form action="{{ route('instructor.modulos.store', $curso->id_curso) }}"
                  method="POST" enctype="multipart/form-data" class="space-y-4" id="form-modulo">
                @csrf
                <input type="hidden" name="tipo" id="tipo-input" value="contenido">

                {{-- Título --}}
                <div>
                    <label class="block text-xs text-gray-400 mb-1" id="lbl-titulo">
                        Título del Módulo <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="titulo" id="inp-titulo" required
                        placeholder="Ej: Introducción a Python"
                        class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white
                               placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-colors"
                        id="input-titulo">
                </div>

                {{-- Orden --}}
                <div>
                    <label class="block text-xs text-gray-400 mb-1">
                        Posición en el curso <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="orden" required min="1"
                        value="{{ $modulos->count() + 1 }}"
                        class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white
                               focus:outline-none focus:border-purple-500 transition-colors">
                    <p class="text-[10px] text-gray-600 mt-1">
                        Número que define dónde aparece en la lista (1 = primero).
                    </p>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2" placeholder="Descripción opcional..."
                        class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-sm text-white
                               placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-colors resize-none">
                    </textarea>
                </div>

                {{-- Sección PDF (solo visible en tipo=contenido) --}}
                <div id="seccion-pdf">
                    <label class="block text-xs text-gray-400 mb-1">Material PDF (opcional)</label>
                    <label class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed
                                  border-white/10 hover:border-purple-500/50 rounded-lg cursor-pointer
                                  bg-white/2 transition-colors group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-purple-400 transition-colors mb-0.5"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-xs text-gray-500 group-hover:text-gray-300 transition-colors"
                            id="pdf-label">Haz clic o arrastra un PDF · máx 20 MB</span>
                        <input type="file" name="pdf" accept=".pdf" class="hidden"
                            onchange="updatePdfLabel(this)">
                    </label>
                </div>

                {{-- Info cuando es examen --}}
                <div id="seccion-examen" class="hidden">
                    <div class="flex items-start gap-2 px-3 py-3 bg-cta/10 border border-cta/20 rounded-lg">
                        <svg class="w-4 h-4 text-cta flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-cta/80">
                            Se creará una evaluación. Después de guardar, podrás agregar las preguntas directamente desde la lista.
                        </p>
                    </div>
                </div>

                {{-- Botón submit --}}
                <button type="submit" id="btn-submit"
                    class="w-full bg-purple-600 hover:bg-purple-500 transition-all text-white text-sm font-medium
                           py-2.5 rounded-lg shadow-[0_0_12px_rgba(168,85,247,0.3)]
                           hover:shadow-[0_0_20px_rgba(168,85,247,0.5)]">
                    Agregar Módulo
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         LISTA DE MÓDULOS — columna derecha (3/5)
    ══════════════════════════════════════════ --}}
    <div class="lg:col-span-3">

        {{-- Contador --}}
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-gray-500">
                {{ $modulos->count() }} {{ $modulos->count() == 1 ? 'elemento' : 'elementos' }} en el curso
            </p>
            <div class="flex items-center gap-3 text-[10px] text-gray-600">
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-purple-500/60 inline-block"></span> Contenido
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-cta/60 inline-block"></span> Evaluación
                </span>
            </div>
        </div>

        <div class="space-y-2">
            @forelse($modulos as $modulo)
            @php
                $esExamen     = isset($modulo->tipo) && $modulo->tipo === 'examen';
                $examenData   = $examenesPorModulo[$modulo->id_modulo] ?? null;
                
                // Corregir acceso a colecciones que pueden ser null
                $numPreguntas = 0;
                if ($examenData && isset($preguntasPorExamen[$examenData->id_examen])) {
                    $numPreguntas = $preguntasPorExamen[$examenData->id_examen]->count();
                }

                $tienePdf = false;
                if (isset($contenidos[$modulo->id_modulo])) {
                    $tienePdf = $contenidos[$modulo->id_modulo]->where('tipo','pdf')->count() > 0;
                }
            @endphp

            <div class="glass rounded-xl overflow-hidden transition-all
                {{ $esExamen
                    ? 'border border-cta/25 hover:border-cta/50'
                    : 'border border-white/10 hover:border-purple-500/40' }}">

                <div class="flex items-center gap-3 px-4 py-3.5">

                    {{-- Número de posición --}}
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-mono font-bold text-sm flex-shrink-0
                        {{ $esExamen
                            ? 'bg-cta/20 text-cta'
                            : 'bg-purple-500/20 text-purple-400' }}">
                        {{ $modulo->orden }}
                    </div>

                    {{-- Icono tipo --}}
                    <div class="flex-shrink-0">
                        @if($esExamen)
                            <svg class="w-4 h-4 text-cta/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-purple-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                            </svg>
                        @endif
                    </div>

                    {{-- Nombre + badges --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-medium text-white truncate">{{ $modulo->titulo }}</p>
                            @if($esExamen)
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wide
                                             bg-cta/20 text-cta border border-cta/30">
                                    Evaluación
                                </span>
                            @endif
                        </div>

                        {{-- Sub-badges de estado --}}
                        <div class="flex flex-wrap items-center gap-1.5 mt-1">
                            @if($esExamen)
                                @if($numPreguntas > 0)
                                    <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded
                                                 bg-green-500/15 border border-green-500/20 text-green-400">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $numPreguntas }} {{ $numPreguntas == 1 ? 'pregunta' : 'preguntas' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-[10px] px-2 py-0.5 rounded
                                                 bg-yellow-500/10 border border-yellow-500/20 text-yellow-500">
                                        Sin preguntas aún
                                    </span>
                                @endif
                            @else
                                @if($tienePdf)
                                    <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded
                                                 bg-red-500/15 border border-red-500/20 text-red-400">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        PDF
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-[10px] px-2 py-0.5 rounded
                                                 bg-white/5 border border-white/5 text-gray-600">
                                        Sin PDF
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Botón de acción --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('instructor.modulo.detalle', [$curso->id_curso, $modulo->id_modulo]) }}"
                            class="flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border
                                   transition-colors
                                   {{ $esExamen
                                       ? 'text-cta border-cta/40 hover:bg-cta/15'
                                       : 'text-purple-300 border-purple-500/40 hover:bg-purple-500/15' }}">
                            @if($esExamen)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Preguntas
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            @endif
                        </a>

                        {{-- Botón Eliminar --}}
                        <form action="{{ route('instructor.modulos.delete', $modulo->id_modulo) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de eliminar este módulo? Se borrarán todos sus contenidos y exámenes.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-lg border border-red-500/30 text-red-400 hover:bg-red-500/10 flex items-center justify-center transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="glass rounded-xl border border-white/10 p-14 text-center">
                <svg class="w-10 h-10 text-gray-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="text-gray-500 text-sm">El curso aún no tiene módulos.</p>
                <p class="text-gray-600 text-xs mt-1">
                    Usa el formulario para agregar el primer <strong class="text-purple-400/70">módulo</strong>
                    o la primera <strong class="text-cta/70">evaluación</strong>.
                </p>
            </div>
            @endforelse
        </div>

    </div>
</div>

<script>
const STYLES = {
    contenido: {
        btn:    'bg-purple-500/25 border-purple-500/60 text-purple-300 shadow-[0_0_10px_rgba(168,85,247,0.2)]',
        other:  'bg-white/5 border-white/10 text-gray-500',
        submit: 'bg-purple-600 hover:bg-purple-500 shadow-[0_0_12px_rgba(168,85,247,0.3)]',
        label:  'Título del Módulo',
        ph:     'Ej: Introducción a Python',
    },
    examen: {
        btn:    'bg-cta/25 border-cta/60 text-cta shadow-[0_0_10px_rgba(245,158,11,0.2)]',
        other:  'bg-white/5 border-white/10 text-gray-500',
        submit: 'bg-cta hover:bg-cta/80',
        label:  'Nombre de la Evaluación',
        ph:     'Ej: Examen Parcial · Examen Final',
    },
};

let tipoActual = 'contenido';

function setTipo(tipo) {
    tipoActual = tipo;
    const s = STYLES[tipo];
    const otro = tipo === 'contenido' ? 'examen' : 'contenido';

    document.getElementById('tipo-input').value = tipo;

    // Botones toggle
    document.getElementById('btn-' + tipo).className =
        `flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg border text-xs font-medium transition-all ${s.btn}`;
    document.getElementById('btn-' + otro).className =
        `flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg border text-xs font-medium transition-all ${STYLES[otro].other}`;

    // Label y placeholder del título
    document.getElementById('lbl-titulo').innerHTML = s.label + ' <span class="text-red-400">*</span>';
    document.getElementById('inp-titulo').placeholder = s.ph;

    // Secciones específicas
    document.getElementById('seccion-pdf').classList.toggle('hidden', tipo === 'examen');
    document.getElementById('seccion-examen').classList.toggle('hidden', tipo === 'contenido');

    // Botón submit
    const btn = document.getElementById('btn-submit');
    btn.textContent = tipo === 'contenido' ? 'Agregar Módulo' : 'Agregar Evaluación';
    btn.className = `w-full transition-all text-white text-sm font-medium py-2.5 rounded-lg ${s.submit}`;
}

function updatePdfLabel(input) {
    const label = document.getElementById('pdf-label');
    label.textContent = input.files.length > 0
        ? input.files[0].name
        : 'Haz clic o arrastra un PDF · máx 20 MB';
}
</script>
@endsection
