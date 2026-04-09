@extends('layouts.app')

@section('title', 'Ingresar - WebCur LMS')

@section('content')
<div class="flex items-center justify-center py-16">
    <div class="glass p-10 rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden">
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/20 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-purple-500/20 blur-3xl rounded-full"></div>
        
        <div class="text-center mb-8 relative z-10">
            <h2 class="text-3xl font-heading font-bold mb-2">Bienvenido de nuevo</h2>
            <p class="text-gray-400">Ingresa a tu cuenta para continuar aprendiendo.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-lg mb-6 text-sm relative z-10">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6 relative z-10">
            @csrf
            <div>
                <label for="dni" class="block text-sm font-medium text-gray-300 mb-2">Documento de Identidad (DNI)</label>
                <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                    placeholder="Ej. 13">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                    <a href="#" class="text-xs text-primary hover:underline">¿Olvidaste tu contraseña?</a>
                </div>
                <input type="password" name="password" id="password" required
                    class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-3 rounded-lg shadow-[0_0_15px_rgba(37,99,235,0.3)] transition-colors mt-4">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-gray-400 relative z-10">
            ¿DNI de prueba?<br/> 
            Admin: <span class="text-white">0000</span> | Gerencia: <span class="text-white">10</span> | Instructor: <span class="text-white">11</span><br/>
            Estudiante: <span class="text-white">13</span> (Pass: 123)
        </p>
    </div>
</div>
@endsection