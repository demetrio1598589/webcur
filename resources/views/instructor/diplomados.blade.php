@extends('layouts.app')
@section('title', 'Gestión de Diplomados')

@section('content')

{{-- ── CABECERA ── --}}
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-heading font-bold text-white">Gestión de Diplomados</h1>
        <p class="text-sm text-gray-400 mt-0.5">
            Crea programas de especialización agrupando tus mejores cursos.
        </p>
    </div>
    <button onclick="toggleModal('modal-create')"
        class="bg-cta hover:bg-cta/80 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-lg transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Diplomado
    </button>
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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($diplomados as $dip)
    <div class="glass rounded-2xl border border-white/5 overflow-hidden hover:border-cta/40 transition-all group flex flex-col">
        <div class="p-6 flex-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-cta/20 text-cta rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <span class="text-[10px] bg-cta/10 text-cta px-2 py-1 rounded-full font-bold uppercase border border-cta/20">
                    {{ $conteoCursos[$dip->id_diplomado]->total ?? 0 }} Cursos
                </span>
            </div>
            
            <h3 class="text-lg font-heading font-bold text-white mb-2">{{ $dip->nombre }}</h3>
            <p class="text-xs text-gray-500 line-clamp-3 mb-4">{{ $dip->descripcion ?? 'Sin descripción.' }}</p>
        </div>

        <div class="px-6 py-4 bg-white/5 border-t border-white/5 flex items-center justify-between">
            <a href="{{ route('instructor.diplomados.detalle', $dip->id_diplomado) }}"
                class="text-xs font-bold text-white hover:text-cta transition-colors flex items-center gap-1">
                Gestionar Cursos
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            
            <div class="flex items-center gap-2">
                <button onclick="editDiplomado({{ json_encode($dip) }})" class="p-1.5 text-gray-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </button>
                <form action="{{ route('instructor.diplomados.delete', $dip->id_diplomado) }}" method="POST" onsubmit="return confirm('¿Eliminar diplomado?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 text-gray-500 hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass rounded-2xl border border-white/5">
        <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
        </svg>
        <p class="text-gray-500">No has creado ningún diplomado aún.</p>
        <button onclick="toggleModal('modal-create')" class="text-cta text-sm mt-2 hover:underline">Empieza creando el primero →</button>
    </div>
    @endforelse
</div>

{{-- MODAL CREATE --}}
<div id="modal-create" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="glass w-full max-w-md rounded-2xl border border-white/10 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-lg font-heading font-bold text-white">Nuevo Diplomado</h2>
            <button onclick="toggleModal('modal-create')" class="text-gray-500 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('instructor.diplomados.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-gray-400 mb-1">Nombre del Diplomado</label>
                <input type="text" name="nombre" required placeholder="Ej: Especialista en Ciberseguridad"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-cta transition-colors">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3" placeholder="Resumen de lo que incluye este programa..."
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-cta transition-colors resize-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-cta text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-cta/20 transition-all">
                Crear Diplomado
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modal-edit" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="glass w-full max-w-md rounded-2xl border border-white/10 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-lg font-heading font-bold text-white">Editar Diplomado</h2>
            <button onclick="toggleModal('modal-edit')" class="text-gray-500 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="form-edit" method="POST" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs text-gray-400 mb-1">Nombre del Diplomado</label>
                <input type="text" name="nombre" id="edit-nombre" required
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cta transition-colors">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Descripción</label>
                <textarea name="descripcion" id="edit-descripcion" rows="3"
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-cta transition-colors resize-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white font-bold py-3 rounded-xl shadow-lg transition-all">
                Actualizar Diplomado
            </button>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    function editDiplomado(dip) {
        document.getElementById('edit-nombre').value = dip.nombre;
        document.getElementById('edit-descripcion').value = dip.descripcion || '';
        document.getElementById('form-edit').action = `/instructor/diplomados/${dip.id_diplomado}`;
        toggleModal('modal-edit');
    }
</script>

@endsection
