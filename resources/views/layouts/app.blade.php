<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WebCur LMS - Plataforma Premium')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col pt-16">
    <nav class="fixed top-0 w-full z-50 glass border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <span class="text-xl font-heading text-white">Web<span class="text-primary">Cur</span></span>
            </a>
            
            <div class="flex items-center gap-4">
                @auth
                    @php
                        $dashUrl = route('dashboard');
                        if (Auth::user()->roles->count() === 1) {
                            if (Auth::user()->hasRole('gerencia')) $dashUrl = route('gerente.home');
                            elseif (Auth::user()->hasRole('instructor')) $dashUrl = route('instructor.home');
                        }
                    @endphp
                    <a href="{{ $dashUrl }}" class="text-sm hover:text-primary transition-colors">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm bg-white/10 hover:bg-white/20 transition-colors px-4 py-2 rounded-full border border-white/5 shadow-sm">
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary transition-colors bg-white/10 px-4 py-2 rounded-full">Ingresar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="mt-auto border-t border-white/10 py-8 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} WebCur LMS. Todos los derechos reservados.
    </footer>
</body>
</html>
