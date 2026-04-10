@extends('layouts.app')
@section('title', 'Mis Cursos')

@section('content')
<div class="mb-10 flex flex-wrap items-end justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2 uppercase tracking-widest">
            <a href="{{ route('estudiante.home') }}" class="hover:text-white transition-colors">Portal</a>
            <span>/</span>
            <span class="text-purple-400 font-bold">Mis Cursos</span>
        </div>
        <h1 class="text-3xl font-heading font-bold text-white">Mi Aprendizaje</h1>
        <p class="text-gray-400 mt-1">Sigue avanzando en tus metas profesionales.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cursos as $curso)
    <div class="glass rounded-3xl overflow-hidden border border-white/5 hover:border-purple-500/30 transition-all group flex flex-col relative">
        {{-- Banner superior con progreso --}}
        <div class="h-4 p-0.5 bg-white/5">
            <div class="h-full bg-purple-500 rounded-full transition-all duration-1000" style="width: {{ $curso->progreso }}%"></div>
        </div>

        <div class="p-6 flex-1 flex flex-col">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 ring-1 ring-purple-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest block">{{ $curso->nivel }}</span>
                    <span class="text-lg font-heading font-bold text-white">{{ $curso->progreso }}%</span>
                </div>
            </div>

            <h3 class="text-lg font-heading font-bold text-white mb-2 group-hover:text-purple-400 transition-colors leading-tight">{{ $curso->titulo }}</h3>
            <p class="text-xs text-gray-500 line-clamp-2 mb-6">{{ $curso->descripcion }}</p>

            <div class="mt-auto space-y-4">
                {{-- Barra de progreso --}}
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-[10px] uppercase font-bold text-gray-600">
                        <span>Progreso del Curso</span>
                        <span>{{ $curso->progreso == 100 ? 'Completado' : 'En Curso' }}</span>
                    </div>
                </div>

                <a href="{{ route('estudiante.verCurso', $curso->id_curso) }}" 
                   class="block w-full text-center bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold py-3 rounded-xl shadow-lg shadow-purple-600/20 transition-all">
                   Continuar Aprendizaje
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass rounded-3xl border border-dashed border-white/10">
        <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        <p class="text-gray-500">Aún no estás inscrito en ningún curso.</p>
        <a href="{{ route('estudiante.catalogo') }}" class="text-purple-400 text-sm mt-2 font-bold hover:underline">Ir al catálogo →</a>
    </div>
    @endforelse
</div>
@endsection
