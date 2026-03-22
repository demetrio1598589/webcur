<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Cursos Online</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-bold mb-6">Bienvenido, {{ Auth::user()->nombre }}</h1>
            <p>Has iniciado sesión correctamente.</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mt-4 inline-block bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Cerrar Sesión</button>
            </form>
        </div>
    </body>
</html>