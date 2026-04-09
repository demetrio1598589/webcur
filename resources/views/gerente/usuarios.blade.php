@extends('layouts.app')
@section('title', 'Panel Gerencial')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
    <div>
        <h1 class="text-3xl font-heading font-bold mb-2 text-yellow-500">Panel Gerencial</h1>
        <p class="text-gray-400">Gestiona usuarios y asignación de múltiples roles.</p>
    </div>
    <button onclick="openModal('create')" class="mt-4 md:mt-0 bg-yellow-600 hover:bg-yellow-700 py-2 px-4 rounded font-medium text-sm transition-colors text-white shadow-[0_0_15px_rgba(234,179,8,0.2)]">
        + Nuevo Usuario
    </button>
</div>

@if(session('success'))
<div class="mb-4 bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-lg text-sm relative">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-6 text-sm relative">
    <ul class="list-disc pl-4 space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass rounded-xl overflow-hidden shadow-lg border border-white/5">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/10 text-sm uppercase text-gray-400">
                    <th class="p-4 font-semibold">Usuario</th>
                    <th class="p-4 font-semibold">Documento</th>
                    <th class="p-4 font-semibold">Teléfono</th>
                    <th class="p-4 font-semibold">Estado</th>
                    <th class="p-4 font-semibold">Roles</th>
                    <th class="p-4 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($users as $u)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="p-4">
                        <div class="font-medium text-white">{{ $u->nombre }} {{ $u->apellido }}</div>
                        <div class="text-gray-500 text-xs">{{ $u->email }}</div>
                    </td>
                    <td class="p-4 text-gray-300">{{ $u->dni }}</td>
                    <td class="p-4 text-gray-300">{{ $u->telefono ?? '-' }}</td>
                    <td class="p-4">
                        @if($u->estado == 'activo')
                            <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1 shadow-[0_0_5px_#22c55e]"></span> Activo
                        @else
                            <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-1 shadow-[0_0_5px_#ef4444]"></span> Inactivo
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($u->roles as $role)
                                <span class="inline-block px-2 py-0.5 bg-yellow-500/20 text-yellow-400 rounded text-xs border border-yellow-500/30">
                                    {{ $role->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <button onclick="openModal('edit', {{ $u->toJson() }})" class="text-[#0ea5e9] hover:text-white transition-colors text-xs mr-2">Editar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal CRUD (Create/Edit) -->
<div id="userModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-gray-900 border border-white/10 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl relative">
        <div class="p-6 border-b border-white/10 flex justify-between items-center sticky top-0 bg-gray-900 z-10">
            <h2 id="modalTitle" class="text-xl font-heading font-bold text-white">Nuevo Usuario</h2>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-white text-2xl leading-none">&times;</button>
        </div>
        
        <div class="p-6">
            <form id="userForm" method="POST" action="{{ route('gerente.users.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Nombre</label>
                        <input type="text" name="nombre" id="in_nombre" required class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Apellido</label>
                        <input type="text" name="apellido" id="in_apellido" required class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">DNI</label>
                        <input type="text" name="dni" id="in_dni" required class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="in_telefono" class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" id="in_email" required class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Contraseña <span id="pass_hint" class="text-xs text-gray-500"></span></label>
                    <input type="password" name="password" id="in_password" class="w-full bg-white/5 border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 focus:bg-white/10 transition-colors">
                </div>

                <div id="estado_container" class="hidden">
                    <label class="block text-sm text-gray-400 mb-1">Estado</label>
                    <select name="estado" id="in_estado" class="w-full bg-[#1a1a1a] border border-white/10 rounded p-2 text-white outline-none focus:border-yellow-500 transition-colors">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Asignar Roles</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($roles as $rol)
                        <label class="flex items-center space-x-2 bg-white/5 p-2 rounded border border-white/5 cursor-pointer hover:bg-white/10 transition-colors">
                            <input type="checkbox" name="roles[]" value="{{ $rol->id_rol }}" class="custom-checkbox w-4 h-4 text-yellow-500 bg-gray-800 border-gray-600 rounded focus:ring-yellow-500 focus:ring-2">
                            <span class="text-sm text-gray-300">{{ ucfirst($rol->nombre) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="pt-4 flex justify-end gap-3 border-t border-white/10 mt-6">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded text-gray-400 hover:text-white transition-colors">Cancelar</button>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded font-medium transition-colors shadow-[0_0_10px_rgba(234,179,8,0.2)]">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(mode, user = null) {
        const modal = document.getElementById('userModal');
        const form = document.getElementById('userForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('formMethod');
        const passHint = document.getElementById('pass_hint');
        const estadoContainer = document.getElementById('estado_container');

        // Reset form
        form.reset();
        
        // Uncheck all
        document.querySelectorAll('input[name="roles[]"]').forEach(cb => cb.checked = false);

        if (mode === 'create') {
            title.innerText = 'Nuevo Usuario';
            form.action = "{{ route('gerente.users.store') }}";
            methodInput.value = "POST";
            document.getElementById('in_password').required = true;
            passHint.innerText = '';
            estadoContainer.classList.add('hidden');
        } else {
            title.innerText = 'Editar Usuario';
            form.action = `/gerente/users/${user.id_usuario}`;
            methodInput.value = "PUT";
            document.getElementById('in_password').required = false;
            passHint.innerText = '(Dejar en blanco para mantener la actual)';
            estadoContainer.classList.remove('hidden');

            // Populate fields
            document.getElementById('in_nombre').value = user.nombre;
            document.getElementById('in_apellido').value = user.apellido;
            document.getElementById('in_dni').value = user.dni;
            document.getElementById('in_email').value = user.email;
            document.getElementById('in_telefono').value = user.telefono || '';
            document.getElementById('in_estado').value = user.estado;

            // Check roles
            if(user.roles) {
                user.roles.forEach(r => {
                    const cb = document.querySelector(`input[name="roles[]"][value="${r.id_rol}"]`);
                    if(cb) cb.checked = true;
                });
            }
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }
</script>
@endsection
