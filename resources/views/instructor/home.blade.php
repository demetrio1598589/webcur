@extends('layouts.app')
@section('title', 'Panel Instructor')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-heading font-bold mb-2 text-purple-400">Panel Instructor</h1>
        <p class="text-gray-400">Gestiona tus cursos, módulos y exámenes.</p>
    </div>
    <a href="#" class="bg-purple-600 hover:bg-purple-700 py-2 px-4 rounded font-medium text-sm transition-colors text-white">
        + Nuevo Curso
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="glass p-6 rounded-2xl border border-white/5">
        <h2 class="text-xl font-heading mb-4">Tus Cursos Activos</h2>
        <div class="space-y-4">
            <div class="p-4 bg-white/5 rounded-lg flex justify-between items-center hover:bg-white/10 transition-colors">
                <div>
                    <h3 class="font-medium">Python desde cero</h3>
                    <p class="text-xs text-gray-400">3 módulos - Nivel Básico</p>
                </div>
                <button class="text-purple-400 text-sm hover:underline">Gestionar</button>
            </div>
        </div>
    </div>
    
    <div class="glass p-6 rounded-2xl border border-white/5">
        <h2 class="text-xl font-heading mb-4">Revisión de Estudiantes</h2>
        <div class="p-4 bg-white/5 rounded-lg border-l-4 border-yellow-500">
            <h3 class="font-medium text-yellow-400">Exámenes Pendientes de revisión</h3>
            <p class="text-sm mt-2 text-gray-300">No hay revisiones manuales por ahora.</p>
        </div>
    </div>
</div>
@endsection
