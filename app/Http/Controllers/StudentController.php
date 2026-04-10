<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Hub principal del estudiante con las 3 tarjetas interactivas.
     */
    public function hub()
    {
        return view('estudiante.hub');
    }

    /**
     * Catálogo de cursos y diplomados disponibles.
     */
    public function catalogo(Request $request)
    {
        $search = $request->input('search');

        // Diplomados con sus cursos
        $diplomados = DB::table('diplomados')
            ->when($search, function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            })
            ->get();

        // Cursos individuales (que no sean parte de la agrupación principal necesariamente)
        $cursos = DB::table('cursos')
            ->where('estado', 'activo')
            ->when($search, function($q) use ($search) {
                $q->where('titulo', 'like', "%$search%");
            })
            ->get();

        return view('estudiante.catalogo', compact('diplomados', 'cursos', 'search'));
    }

    /**
     * Inscripción (simulación de compra).
     */
    public function inscribir(Request $request)
    {
        $usuario = Auth::user();
        $id_curso = $request->id_curso;
        $id_diplomado = $request->id_diplomado;

        if ($id_curso) {
            DB::table('inscripciones')->updateOrInsert(
                ['id_usuario' => $usuario->id_usuario, 'id_curso' => $id_curso],
                ['estado' => 'activo', 'fecha_inscripcion' => now()]
            );
        }

        if ($id_diplomado) {
            // Inscribir en el diplomado
            DB::table('inscripciones')->updateOrInsert(
                ['id_usuario' => $usuario->id_usuario, 'id_diplomado' => $id_diplomado],
                ['estado' => 'activo', 'fecha_inscripcion' => now()]
            );

            // También inscribir en todos los cursos del diplomado automáticamente
            $cursosDiplomado = DB::table('diplomado_cursos')
                ->where('id_diplomado', $id_diplomado)
                ->pluck('id_curso');

            foreach ($cursosDiplomado as $cid) {
                DB::table('inscripciones')->updateOrInsert(
                    ['id_usuario' => $usuario->id_usuario, 'id_curso' => $cid],
                    ['estado' => 'activo', 'fecha_inscripcion' => now()]
                );
            }
        }

        return back()->with('success', '¡Inscripción exitosa! Ya puedes comenzar tu aprendizaje.');
    }

    /**
     * Lista de cursos adquiridos con su progreso.
     */
    public function misCursos()
    {
        $usuario = Auth::user();

        $cursos = DB::table('inscripciones')
            ->join('cursos', 'inscripciones.id_curso', '=', 'cursos.id_curso')
            ->where('inscripciones.id_usuario', $usuario->id_usuario)
            ->whereNotNull('inscripciones.id_curso')
            ->select('cursos.*', 'inscripciones.fecha_inscripcion')
            ->get();

        // Calcular progreso para cada curso
        foreach ($cursos as $curso) {
            $modulos = DB::table('modulos')->where('id_curso', $curso->id_curso)->get();
            $totalModulos = $modulos->count();
            
            if ($totalModulos > 0) {
                $completados = DB::table('progreso_modulo')
                    ->where('id_usuario', $usuario->id_usuario)
                    ->whereIn('id_modulo', $modulos->pluck('id_modulo'))
                    ->where('completado', 1)
                    ->count();
                
                $curso->progreso = round(($completados / $totalModulos) * 100);
            } else {
                $curso->progreso = 0;
            }
        }

        return view('estudiante.mis_cursos', compact('cursos'));
    }

    /**
     * Lista de diplomados adquiridos con progreso agregado.
     */
    public function misDiplomados()
    {
        $usuario = Auth::user();

        $diplomados = DB::table('inscripciones')
            ->join('diplomados', 'inscripciones.id_diplomado', '=', 'diplomados.id_diplomado')
            ->where('inscripciones.id_usuario', $usuario->id_usuario)
            ->whereNotNull('inscripciones.id_diplomado')
            ->get();

        foreach ($diplomados as $dip) {
            // Cursos que componen este diplomado
            $cursosIds = DB::table('diplomado_cursos')
                ->where('id_diplomado', $dip->id_diplomado)
                ->pluck('id_curso');

            if ($cursosIds->isNotEmpty()) {
                // Calcular promedio de progreso de los cursos del diplomado
                $progresos = [];
                foreach ($cursosIds as $cid) {
                    $modulos = DB::table('modulos')->where('id_curso', $cid)->pluck('id_modulo');
                    $total = $modulos->count();
                    if ($total > 0) {
                        $comp = DB::table('progreso_modulo')
                            ->where('id_usuario', $usuario->id_usuario)
                            ->whereIn('id_modulo', $modulos)
                            ->where('completado', 1)
                            ->count();
                        $progresos[] = ($comp / $total) * 100;
                    } else {
                        $progresos[] = 0;
                    }
                }
                $dip->progreso = round(array_sum($progresos) / count($progresos));
            } else {
                $dip->progreso = 0;
            }
        }

        return view('estudiante.mis_diplomados', compact('diplomados'));
    }

    /**
     * Reproductor de curso (Contenido y Módulos).
     */
    public function verCurso($id)
    {
        $usuario = Auth::user();
        $curso = DB::table('cursos')->where('id_curso', $id)->first();
        if (!$curso) abort(404);

        $modulos = DB::table('modulos')
            ->where('id_curso', $id)
            ->orderBy('orden')
            ->get();

        // Enriquecer módulos con estado de completado
        foreach ($modulos as $modulo) {
            $comp = DB::table('progreso_modulo')
                ->where('id_usuario', $usuario->id_usuario)
                ->where('id_modulo', $modulo->id_modulo)
                ->first();
            $modulo->completado = $comp ? $comp->completado : 0;

            // Contenidos
            $modulo->contenidos = DB::table('contenidos')
                ->where('id_modulo', $modulo->id_modulo)
                ->get();
            
            // Exámenes
            $modulo->examen = DB::table('examenes')
                ->where('id_modulo', $modulo->id_modulo)
                ->first();
        }

        return view('estudiante.curso_view', compact('curso', 'modulos'));
    }

    /**
     * Marcar un módulo como completado.
     */
    public function completarModulo($id)
    {
        $usuario = Auth::user();
        
        DB::table('progreso_modulo')->updateOrInsert(
            ['id_usuario' => $usuario->id_usuario, 'id_modulo' => $id],
            ['completado' => 1]
        );

        return back()->with('success', '¡Buen trabajo! Has completado este módulo.');
    }
}
