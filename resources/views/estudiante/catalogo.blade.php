@extends('layouts.app')
@section('title', 'Catálogo de Cursos')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h1 class="text-3xl font-heading font-bold text-white mb-2">Catálogo Premium</h1>
        <p class="text-gray-400">Encuentra tu próximo desafío profesional.</p>
    </div>

    {{-- Buscador --}}
    <form action="{{ route('estudiante.catalogo') }}" method="GET" class="w-full md:w-96 relative group">
        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar diplomado o curso..."
               class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition-all placeholder-gray-600">
        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-hover:text-blue-400 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </button>
    </form>
</div>

{{-- Mensajes Flash --}}
@if(session('success'))
    <div class="mb-8 px-5 py-4 bg-green-500/10 border border-green-500/20 text-green-300 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
@endif

{{-- ════ SECCIÓN 1: DIPLOMADOS ════ --}}
<div class="mb-12">
    <div class="flex items-center gap-4 mb-8">
        <h2 class="text-sm font-bold text-cta uppercase tracking-widest">Diplomados de Especialización</h2>
        <div class="h-px bg-cta/20 flex-1"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($diplomados as $dip)
        <div class="glass rounded-3xl overflow-hidden border border-white/5 hover:border-cta/30 transition-all group flex flex-col">
            <div class="h-48 bg-cta/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                {{-- Badge --}}
                <span class="absolute top-4 left-4 bg-cta text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Certificado</span>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-xl font-heading font-bold text-white mb-2">{{ $dip->nombre }}</h3>
                <p class="text-sm text-gray-500 mb-6 line-clamp-3 leading-relaxed">{{ $dip->descripcion ?? 'Programa de alta especialización pedagógica con certificación oficial.' }}</p>
                
                <div class="mt-auto">
                    <form action="{{ route('estudiante.inscribir') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_diplomado" value="{{ $dip->id_diplomado }}">
                        <button type="submit" class="w-full bg-cta hover:bg-cta/80 text-white font-bold py-3 rounded-xl shadow-[0_4px_15px_rgba(245,158,11,0.2)] transition-all">
                            Adquirir Diplomado
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-600 italic">No se encontraron diplomados que coincidan con la búsqueda.</div>
        @endforelse
    </div>
</div>

{{-- ════ SECCIÓN 2: CURSOS ════ --}}
<div>
    <div class="flex items-center gap-4 mb-8">
        <h2 class="text-sm font-bold text-blue-400 uppercase tracking-widest">Cursos Individuales</h2>
        <div class="h-px bg-blue-500/20 flex-1"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($cursos as $curso)
        <div class="glass rounded-2xl overflow-hidden border border-white/5 hover:border-blue-500/30 transition-all group flex flex-col">
            <div class="h-32 bg-white/5 relative overflow-hidden">
                @if($curso->imagen)
                    <img src="{{ asset('storage/'.$curso->imagen) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-700">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div class="absolute top-2 right-2 bg-blue-500/20 text-blue-400 text-[9px] font-bold px-2 py-0.5 rounded border border-blue-500/30 uppercase tracking-widest">{{ $curso->nivel }}</div>
            </div>
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-sm font-bold text-white mb-1 group-hover:text-blue-400 transition-colors line-clamp-1">{{ $curso->titulo }}</h3>
                <p class="text-[11px] text-gray-500 line-clamp-2 mb-4 leading-relaxed">{{ $curso->descripcion }}</p>

                <div class="mt-auto">
                    <form action="{{ route('estudiante.inscribir') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_curso" value="{{ $curso->id_curso }}">
                        <button type="submit" class="w-full bg-white/5 hover:bg-blue-600 text-white text-[10px] font-bold py-2 rounded-lg border border-white/10 transition-all">
                            Adquirir Curso
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-600 italic">No se encontraron cursos que coincidan con la búsqueda.</div>
        @endforelse
    </div>
</div>
@endsection
