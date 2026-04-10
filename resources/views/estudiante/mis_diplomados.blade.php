@extends('layouts.app')
@section('title', 'Mis Diplomados')

@section('content')
<div class="mb-10 flex flex-wrap items-end justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2 uppercase tracking-widest">
            <a href="{{ route('estudiante.home') }}" class="hover:text-white transition-colors">Portal</a>
            <span>/</span>
            <span class="text-cta font-bold">Mis Diplomados</span>
        </div>
        <h1 class="text-3xl font-heading font-bold text-white">Rutas de Especialización</h1>
        <p class="text-gray-400 mt-1">Programas completos de formación académica.</p>
    </div>
</div>

{{-- Lista de Diplomados Estilo Imagen Referencia --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($diplomados as $dip)
    <div class="bg-[#1a1a1a] rounded-[24px] overflow-hidden border border-white/5 shadow-2xl transition-all hover:border-cta/20 group">
        
        {{-- Imagen del Diplomado --}}
        <div class="h-48 relative overflow-hidden bg-cta/10">
            {{-- Badge estilo imagen --}}
            <div class="absolute top-4 left-4 z-10">
                <span class="bg-[#a32b2b] text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide">
                    Diplomados
                </span>
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            
            {{-- Icono central si no hay imagen --}}
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-white/10 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
        </div>

        {{-- Contenido estilo imagen --}}
        <div class="p-6 bg-white flex flex-col items-start">
            <h3 class="text-[#a32b2b] font-heading font-bold text-lg mb-6 tracking-tight leading-tight uppercase group-hover:text-red-700 transition-colors">
                {{ $dip->nombre }}
            </h3>

            {{-- Barra de progreso estilo imagen --}}
            <div class="w-full relative mb-1">
                <div class="h-2 w-full bg-[#f0f0f0] rounded-full overflow-hidden">
                    <div class="h-full bg-[#a32b2b] transition-all duration-1000" style="width: {{ $dip->progreso }}%"></div>
                </div>
            </div>

            <div class="w-full flex items-center justify-between mt-2">
                <span class="text-sm font-bold text-gray-800">{{ $dip->progreso }}% completado</span>
                
                {{-- Botón circular 3 puntos estilo imagen --}}
                <a href="#" class="w-8 h-8 rounded-full bg-[#a32b2b] text-white flex items-center justify-center hover:bg-red-800 transition-all shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm-6 0a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm12 0a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"></path></svg>
                </a>
            </div>
            
            <a href="#" class="mt-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest hover:text-[#a32b2b] transition-colors">
                Ver detalle estructural →
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass rounded-[32px] border border-dashed border-white/10">
        <svg class="w-20 h-20 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
        <p class="text-gray-500 text-lg">No te has inscrito en ningún diplomado.</p>
        <p class="text-gray-600 font-bold mt-2">Los mejores programas te esperan en el catálogo.</p>
        <a href="{{ route('estudiante.catalogo') }}" class="inline-block mt-6 bg-cta text-white font-bold px-8 py-3 rounded-2xl shadow-lg">Ir al Catálogo</a>
    </div>
    @endforelse
</div>
@endsection
