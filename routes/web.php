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
        
        Route::get('/cursos', [\App\Http\Controllers\InstructorController::class, 'cursos'])->name('instructor.cursos');
        Route::post('/cursos', [\App\Http\Controllers\InstructorController::class, 'storeCurso'])->name('instructor.cursos.store');
        Route::put('/cursos/{id}', [\App\Http\Controllers\InstructorController::class, 'updateCurso'])->name('instructor.cursos.update');
        
        Route::get('/cursos/{id_curso}/modulos', [\App\Http\Controllers\InstructorController::class, 'modulos'])->name('instructor.modulos');
        Route::post('/cursos/{id_curso}/modulos', [\App\Http\Controllers\InstructorController::class, 'storeModulo'])->name('instructor.modulos.store');

        Route::get('/evaluaciones', [\App\Http\Controllers\InstructorController::class, 'evaluaciones'])->name('instructor.evaluaciones');
        Route::get('/calificaciones', [\App\Http\Controllers\InstructorController::class, 'calificaciones'])->name('instructor.calificaciones');
    });

    Route::middleware(['role:colaborador'])->prefix('colaborador')->group(function () {
        Route::get('/', function () { return view('colaborador.home'); })->name('colaborador.home');
    });

    Route::middleware(['role:estudiante'])->prefix('estudiante')->group(function () {
        Route::get('/', function () { return view('estudiante.home'); })->name('estudiante.home');
    });
});
