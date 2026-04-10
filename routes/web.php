<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', function () { return view('admin.home'); })->name('admin.home');
    });

    Route::middleware(['role:gerencia'])->prefix('gerente')->group(function () {
        Route::get('/', function() { return view('gerente.hub'); })->name('gerente.home');
        
        Route::get('/usuarios', [\App\Http\Controllers\GerenteController::class, 'index'])->name('gerente.users.index');
        Route::post('/usuarios', [\App\Http\Controllers\GerenteController::class, 'store'])->name('gerente.users.store');
        Route::put('/usuarios/{id}', [\App\Http\Controllers\GerenteController::class, 'update'])->name('gerente.users.update');
        
        Route::get('/estadisticas', [\App\Http\Controllers\GerenteController::class, 'estadisticas'])->name('gerente.estadisticas');
    });

    Route::middleware(['role:instructor'])->prefix('instructor')->group(function () {
        Route::get('/', function() { return view('instructor.hub'); })->name('instructor.home');

        // ── CURSOS ──
        Route::get('/cursos', [\App\Http\Controllers\InstructorController::class, 'cursos'])->name('instructor.cursos');
        Route::post('/cursos', [\App\Http\Controllers\InstructorController::class, 'storeCurso'])->name('instructor.cursos.store');
        Route::put('/cursos/{id}', [\App\Http\Controllers\InstructorController::class, 'updateCurso'])->name('instructor.cursos.update');

        // ── MÓDULOS ──
        Route::get('/cursos/{id_curso}/modulos', [\App\Http\Controllers\InstructorController::class, 'modulos'])->name('instructor.modulos');
        Route::post('/cursos/{id_curso}/modulos', [\App\Http\Controllers\InstructorController::class, 'storeModulo'])->name('instructor.modulos.store');
        Route::put('/modulos/{id}', [\App\Http\Controllers\InstructorController::class, 'updateModulo'])->name('instructor.modulos.update');
        Route::delete('/modulos/{id}', [\App\Http\Controllers\InstructorController::class, 'deleteModulo'])->name('instructor.modulos.delete');

        // ── DETALLE DE MÓDULO (contenido + examen + preguntas) ──
        Route::get('/cursos/{id_curso}/modulos/{id_modulo}', [\App\Http\Controllers\InstructorController::class, 'moduloDetalle'])->name('instructor.modulo.detalle');
        Route::post('/cursos/{id_curso}/modulos/{id_modulo}/examen', [\App\Http\Controllers\InstructorController::class, 'storeExamenModulo'])->name('instructor.modulo.examen.store');

        // ── PREGUNTAS ──
        Route::post('/examenes/{id_examen}/preguntas', [\App\Http\Controllers\InstructorController::class, 'storePregunta'])->name('instructor.preguntas.store');
        Route::delete('/preguntas/{id_pregunta}', [\App\Http\Controllers\InstructorController::class, 'deletePregunta'])->name('instructor.preguntas.delete');

        // ── DIPLOMADOS ──
        Route::get('/diplomados', [\App\Http\Controllers\InstructorController::class, 'diplomados'])->name('instructor.diplomados');
        Route::post('/diplomados', [\App\Http\Controllers\InstructorController::class, 'storeDiplomado'])->name('instructor.diplomados.store');
        Route::get('/diplomados/{id}', [\App\Http\Controllers\InstructorController::class, 'diplomadoDetalle'])->name('instructor.diplomados.detalle');
        Route::put('/diplomados/{id}', [\App\Http\Controllers\InstructorController::class, 'updateDiplomado'])->name('instructor.diplomados.update');
        Route::delete('/diplomados/{id}', [\App\Http\Controllers\InstructorController::class, 'deleteDiplomado'])->name('instructor.diplomados.delete');
        Route::post('/diplomados/{id}/cursos', [\App\Http\Controllers\InstructorController::class, 'addCursoDiplomado'])->name('instructor.diplomados.addCurso');
        Route::delete('/diplomados/{id_diplomado}/cursos/{id_curso}', [\App\Http\Controllers\InstructorController::class, 'removeCursoDiplomado'])->name('instructor.diplomados.removeCurso');

        // ── CALIFICACIONES ──
        Route::get('/calificaciones', [\App\Http\Controllers\InstructorController::class, 'calificaciones'])->name('instructor.calificaciones');
        Route::put('/calificaciones/{id}', [\App\Http\Controllers\InstructorController::class, 'updateNota'])->name('instructor.calificaciones.update');
    });

    Route::middleware(['role:colaborador'])->prefix('colaborador')->group(function () {
        Route::get('/', function () { return view('colaborador.home'); })->name('colaborador.home');
    });

    Route::middleware(['role:estudiante'])->prefix('estudiante')->group(function () {
        Route::get('/', [\App\Http\Controllers\StudentController::class, 'hub'])->name('estudiante.home');
        
        // Catálogo
        Route::get('/catalogo', [\App\Http\Controllers\StudentController::class, 'catalogo'])->name('estudiante.catalogo');
        Route::post('/inscribir', [\App\Http\Controllers\StudentController::class, 'inscribir'])->name('estudiante.inscribir');

        // Mis Cursos y Diplomados
        Route::get('/mis-cursos', [\App\Http\Controllers\StudentController::class, 'misCursos'])->name('estudiante.mis-cursos');
        Route::get('/mis-diplomados', [\App\Http\Controllers\StudentController::class, 'misDiplomados'])->name('estudiante.mis-diplomados');

        // Visualización de Contenido
        Route::get('/curso/{id}', [\App\Http\Controllers\StudentController::class, 'verCurso'])->name('estudiante.verCurso');
        Route::post('/modulo/{id}/completar', [\App\Http\Controllers\StudentController::class, 'completarModulo'])->name('estudiante.completarModulo');
    });
});
