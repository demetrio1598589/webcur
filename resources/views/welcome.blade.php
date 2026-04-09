@extends('layouts.app')

@section('title', 'WebCur LMS - Aprende a tu ritmo')

@section('content')
<div class="space-y-24">
    <!-- Hero Section -->
    <section class="relative pt-20 pb-32 flex flex-col items-center text-center">
        <div class="absolute inset-0 top-1/2 -translate-y-1/2 bg-cta/20 blur-[120px] rounded-full w-[600px] h-[600px] mx-auto -z-10"></div>
        <h1 class="text-5xl md:text-7xl font-heading font-bold mb-6 tracking-tight">
            Desbloquea tu <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-[#6366f1]">Potencial Profesional</span>
        </h1>
        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10">
            Cursos online creados por expertos, diseñados para impulsar tu carrera al siguiente nivel. Accede a más de 100+ recursos, proyectos reales y certificaciones.
        </p>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="bg-cta hover:bg-cta-hover text-white font-medium px-8 py-3 rounded-full transition-all shadow-[0_0_20px_rgba(234,88,12,0.3)]">
                Empezar a Aprender
            </a>
            <a href="#cursos" class="glass px-8 py-3 rounded-full font-medium hover:bg-white/5 transition-colors">
                Explorar Catálogo
            </a>
        </div>
    </section>

    <!-- Planes y Suscripción -->
    <section id="planes" class="py-12">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-heading font-semibold mb-4">Planes diseñados para ti</h2>
            <p class="text-gray-400">Elige cómo quieres aprender. Sin ataduras.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Plan Individual -->
            <div class="glass p-8 rounded-2xl hover:-translate-y-2 transition-transform duration-300">
                <h3 class="text-xl font-heading font-medium mb-2">Por Curso</h3>
                <p class="text-gray-400 mb-6 text-sm">Pago único, acceso de por vida.</p>
                <div class="mb-8">
                    <span class="text-4xl font-bold">Variable</span>
                </div>
                <ul class="space-y-3 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-2">✓ Acceso 100% de por vida</li>
                    <li class="flex items-center gap-2">✓ Proyectos descargables</li>
                    <li class="flex items-center gap-2">✓ Certificado incluido</li>
                </ul>
            </div>
            
            <!-- Plan Mensual -->
            <div class="glass p-8 rounded-2xl border-cta/50 relative hover:-translate-y-2 transition-transform duration-300 shadow-[0_0_30px_rgba(234,88,12,0.1)]">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-cta text-white text-xs font-bold px-3 py-1 rounded-full">
                    MÁS POPULAR
                </div>
                <h3 class="text-xl font-heading font-medium mb-2">Mensual</h3>
                <p class="text-gray-400 mb-6 text-sm">Acceso total a la plataforma.</p>
                <div class="mb-8">
                    <span class="text-4xl font-bold">S/ 50</span><span class="text-gray-500">/mes</span>
                </div>
                <ul class="space-y-3 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-2">✓ Acceso full a cursos premium</li>
                    <li class="flex items-center gap-2">✓ Exámenes y cuestionarios</li>
                    <li class="flex items-center gap-2">✓ Cancela cuando quieras</li>
                </ul>
            </div>
            
            <!-- Plan Anual -->
            <div class="glass p-8 rounded-2xl hover:-translate-y-2 transition-transform duration-300">
                <h3 class="text-xl font-heading font-medium mb-2">Anual</h3>
                <p class="text-gray-400 mb-6 text-sm">El mejor valor para tu carrera.</p>
                <div class="mb-8">
                    <span class="text-4xl font-bold">S/ 400</span><span class="text-gray-500">/año</span>
                </div>
                <ul class="space-y-3 mb-8 text-sm text-gray-300">
                    <li class="flex items-center gap-2">✓ Ahorra un 33% al año</li>
                    <li class="flex items-center gap-2">✓ Acceso full a cursos premium</li>
                    <li class="flex items-center gap-2">✓ Mentorías comunitarias</li>
                </ul>
            </div>
        </div>
    </section>
</div>
@endsection
