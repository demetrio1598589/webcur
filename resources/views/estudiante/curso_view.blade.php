@extends('layouts.app')
@section('title', $curso->titulo)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2 uppercase tracking-widest">
            <a href="{{ route('estudiante.mis-cursos') }}" class="hover:text-white transition-colors">Mis Cursos</a>
            <span>/</span>
            <span class="text-white">{{ $curso->titulo }}</span>
        </div>
        <h1 class="text-2xl font-heading font-bold text-white">{{ $curso->titulo }}</h1>
    </div>
    
    <a href="{{ route('estudiante.mis-cursos') }}" class="text-xs text-gray-500 hover:text-white flex items-center gap-2 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Volver a la lista
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

    {{-- ─ Columna Lateral: Índice de Módulos (1/4) ─ --}}
    <div class="lg:col-span-1 space-y-4">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest pl-2">Contenido del Curso</h3>
        
        <div class="space-y-2">
            @foreach($modulos as $idx => $mod)
            <button onclick="selectModulo({{ $idx }})" id="mod-btn-{{ $idx }}"
               class="w-full text-left p-4 rounded-2xl glass border transition-all duration-300 flex items-center justify-between group
               {{ $idx == 0 ? 'border-purple-500 bg-purple-500/10' : 'border-white/5 hover:border-white/20' }}">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full border border-white/20 flex items-center justify-center text-[10px] font-bold text-gray-500 group-hover:text-white transition-colors
                        {{ $mod->completado ? 'bg-green-500 border-green-500 text-white' : '' }}">
                        @if($mod->completado)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $mod->orden }}
                        @endif
                    </div>
                    <span class="text-sm font-medium {{ $idx == 0 ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition-colors line-clamp-1">
                        {{ $mod->titulo }}
                    </span>
                </div>
            </button>
            @endforeach
        </div>
    </div>

    {{-- ─ Columna Principal: Player / Visualizador (3/4) ─ --}}
    <div class="lg:col-span-3">
        @foreach($modulos as $idx => $mod)
        <div id="mod-content-{{ $idx }}" class="{{ $idx == 0 ? '' : 'hidden' }} space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
            
            {{-- Material de Estudio --}}
            <div class="glass rounded-[32px] border border-white/5 overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div>
                        <span class="text-[10px] text-purple-400 font-bold uppercase tracking-widest mb-1 block">Módulo {{ $mod->orden }}</span>
                        <h2 class="text-xl font-heading font-bold text-white">{{ $mod->titulo }}</h2>
                    </div>
                    
                    @if(!$mod->completado)
                        <form action="{{ route('estudiante.completarModulo', $mod->id_modulo) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-green-600/20 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Marcar como Completado
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-2 text-green-400 font-bold text-xs bg-green-500/10 px-4 py-2 rounded-xl border border-green-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Módulo Completado
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    <p class="text-gray-400 text-sm mb-8 leading-relaxed">{{ $mod->descripcion ?? 'Este módulo contiene el material necesario para tu formación teórica.' }}</p>

                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Material Didáctico</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($mod->contenidos as $cont)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5 hover:border-purple-500/30 transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center">
                                    @if($cont->tipo == 'pdf')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-white block">{{ $cont->titulo }}</span>
                                    <span class="text-[10px] text-gray-600 uppercase">{{ $cont->tipo }}</span>
                                </div>
                            </div>
                            <a href="{{ asset('storage/'.$cont->url) }}" target="_blank" 
                               class="text-[10px] font-bold text-purple-400 hover:text-white bg-purple-500/10 px-3 py-1.5 rounded-lg border border-purple-500/20 transition-all">
                                Ver Recurso
                            </a>
                        </div>
                        @empty
                        <div class="col-span-full py-4 text-center border border-dashed border-white/5 rounded-2xl">
                            <span class="text-xs text-gray-700 italic">No hay archivos cargados para este módulo.</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sección de Evaluación si existe --}}
            @if($mod->examen)
            <div class="bg-gradient-to-br from-cta/10 to-transparent p-1 rounded-[32px]">
                <div class="glass rounded-[31px] p-8 border border-cta/20 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6 text-center md:text-left">
                        <div class="w-20 h-20 bg-cta/20 text-cta rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-heading font-bold text-white mb-2">Evaluación del Módulo</h3>
                            <p class="text-sm text-gray-400">Pon a prueba tus conocimientos sobre {{ $mod->titulo }}. Al finalizar, tus notas se guardarán automáticamente.</p>
                        </div>
                    </div>
                    <button class="w-full md:w-auto bg-cta hover:bg-cta/80 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-cta/20 transition-all transform hover:scale-105">
                        Empezar Examen
                    </button>
                </div>
            </div>
            @endif

        </div>
        @endforeach
    </div>
</div>

<script>
    function selectModulo(idx) {
        // Ocultar todos los contenidos
        document.querySelectorAll('[id^="mod-content-"]').forEach(el => el.classList.add('hidden'));
        // Mostrar el seleccionado
        document.getElementById('mod-content-' + idx).classList.remove('hidden');

        // Actualizar estilos de botones
        document.querySelectorAll('[id^="mod-btn-"]').forEach(btn => {
            btn.classList.remove('border-purple-500', 'bg-purple-500/10');
            btn.classList.add('border-white/5');
            btn.querySelector('span').classList.remove('text-white');
            btn.querySelector('span').classList.add('text-gray-400');
        });

        const activeBtn = document.getElementById('mod-btn-' + idx);
        activeBtn.classList.add('border-purple-500', 'bg-purple-500/10');
        activeBtn.classList.remove('border-white/5');
        activeBtn.querySelector('span').classList.remove('text-gray-400');
        activeBtn.querySelector('span').classList.add('text-white');
    }
</script>
@endsection
