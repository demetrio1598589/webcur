<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    // ─────────────────────────────────────────────
    //  CURSOS
    // ─────────────────────────────────────────────

    public function cursos()
    {
        $instructor = Auth::user();
        $cursos = DB::table('cursos')
            ->where('id_instructor', $instructor->id_usuario)
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return view('instructor.cursos', compact('cursos'));
    }

    public function storeCurso(Request $request)
    {
        $validated = $request->validate([
            'titulo'         => 'required|string|max:200',
            'descripcion'    => 'nullable|string',
            'nivel'          => 'required|in:basico,intermedio,avanzado',
            'duracion_horas' => 'nullable|integer|min:1',
        ]);

        DB::table('cursos')->insert([
            'titulo'          => $validated['titulo'],
            'descripcion'     => $validated['descripcion'] ?? null,
            'nivel'           => $validated['nivel'],
            'duracion_horas'  => $validated['duracion_horas'] ?? null,
            'estado'          => 'activo',
            'id_instructor'   => Auth::user()->id_usuario,
            'fecha_creacion'  => now(),
        ]);

        return back()->with('success', 'Curso creado correctamente.');
    }

    public function updateCurso(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo'         => 'required|string|max:200',
            'descripcion'    => 'nullable|string',
            'nivel'          => 'required|in:basico,intermedio,avanzado',
            'duracion_horas' => 'nullable|integer|min:1',
            'estado'         => 'required|in:activo,inactivo',
        ]);

        DB::table('cursos')
            ->where('id_curso', $id)
            ->where('id_instructor', Auth::user()->id_usuario)
            ->update([
                'titulo'         => $validated['titulo'],
                'descripcion'    => $validated['descripcion'] ?? null,
                'nivel'          => $validated['nivel'],
                'duracion_horas' => $validated['duracion_horas'] ?? null,
                'estado'         => $validated['estado'],
            ]);

        return back()->with('success', 'Curso actualizado correctamente.');
    }

    // ─────────────────────────────────────────────
    //  MÓDULOS
    // ─────────────────────────────────────────────

    public function modulos($id_curso)
    {
        $instructor = Auth::user();

        // Verificar que el curso pertenece al instructor
        $curso = DB::table('cursos')
            ->where('id_curso', $id_curso)
            ->where('id_instructor', $instructor->id_usuario)
            ->first();

        if (!$curso) {
            abort(403, 'No tienes permisos sobre este curso.');
        }

        $modulos = DB::table('modulos')
            ->where('id_curso', $id_curso)
            ->orderBy('orden')
            ->get();

        // Traer contenidos de cada módulo
        $contenidos = DB::table('contenidos')
            ->whereIn('id_modulo', $modulos->pluck('id_modulo'))
            ->get()
            ->groupBy('id_modulo');

        // Exámenes por módulo (para badges)
        $examenesPorModulo = DB::table('examenes')
            ->whereIn('id_modulo', $modulos->pluck('id_modulo'))
            ->get()
            ->keyBy('id_modulo');

        // Preguntas por examen (para contar)
        $preguntasPorExamen = DB::table('preguntas')
            ->whereIn('id_examen', $examenesPorModulo->pluck('id_examen'))
            ->get()
            ->groupBy('id_examen');

        return view('instructor.modulos', compact(
            'curso', 'modulos', 'contenidos', 'examenesPorModulo', 'preguntasPorExamen'
        ));
    }

    public function storeModulo(Request $request, $id_curso)
    {
        $instructor = Auth::user();

        $curso = DB::table('cursos')
            ->where('id_curso', $id_curso)
            ->where('id_instructor', $instructor->id_usuario)
            ->first();

        if (!$curso) abort(403);

        $validated = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'orden'       => 'required|integer|min:1',
            'tipo'        => 'required|in:contenido,examen',
            'pdf'         => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Insertar módulo con su tipo
        $id_modulo = DB::table('modulos')->insertGetId([
            'titulo'      => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'orden'       => $validated['orden'],
            'tipo'        => $validated['tipo'],
            'id_curso'    => $id_curso,
        ]);

        if ($validated['tipo'] === 'contenido') {
            // Guardar PDF si se adjuntó
            if ($request->hasFile('pdf')) {
                $path = $request->file('pdf')->store('pdfs', 'public');
                DB::table('contenidos')->insert([
                    'tipo'      => 'pdf',
                    'url'       => $path,
                    'titulo'    => $validated['titulo'] . ' - Material',
                    'id_modulo' => $id_modulo,
                ]);
            }
            $msg = 'Módulo de contenido agregado.';
        } else {
            // tipo = examen → crear automáticamente el registro en examenes
            DB::table('examenes')->insert([
                'titulo'      => $validated['titulo'],
                'descripcion' => $validated['descripcion'] ?? null,
                'id_modulo'   => $id_modulo,
            ]);
            $msg = 'Módulo de examen creado. Ahora agrega las preguntas.';
        }

        return redirect()->route('instructor.modulos', $id_curso)
            ->with('success', $msg);
    }
    public function updateModulo(Request $request, $id)
    {
        $instructor = Auth::user();

        $modulo = DB::table('modulos')->where('id_modulo', $id)->first();
        if (!$modulo) abort(404);

        // Verificar ownership del curso
        $curso = DB::table('cursos')
            ->where('id_curso', $modulo->id_curso)
            ->where('id_instructor', $instructor->id_usuario)
            ->first();
        if (!$curso) abort(403);

        $validated = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'orden'       => 'required|integer|min:1',
            'pdf'         => 'nullable|file|mimes:pdf|max:20480',
        ]);

        DB::table('modulos')->where('id_modulo', $id)->update([
            'titulo'      => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'orden'       => $validated['orden'],
        ]);

        // Si es contenido y subió un nuevo PDF
        if ($modulo->tipo === 'contenido' && $request->hasFile('pdf')) {
            // Buscar contenido anterior para borrar archivo físico
            $contenidoAnterior = DB::table('contenidos')->where('id_modulo', $id)->where('tipo', 'pdf')->first();
            if ($contenidoAnterior) {
                Storage::disk('public')->delete($contenidoAnterior->url);
                DB::table('contenidos')->where('id_contenido', $contenidoAnterior->id_contenido)->delete();
            }

            $path = $request->file('pdf')->store('pdfs', 'public');
            DB::table('contenidos')->insert([
                'tipo'      => 'pdf',
                'url'       => $path,
                'titulo'    => $validated['titulo'] . ' - Material',
                'id_modulo' => $id,
            ]);
        }

        // Si es examen, actualizar también el título del examen si lo deseamos (opcional)
        if ($modulo->tipo === 'examen') {
            DB::table('examenes')->where('id_modulo', $id)->update([
                'titulo' => $validated['titulo']
            ]);
        }

        return back()->with('success', 'Módulo actualizado correctamente.');
    }

    public function deleteModulo($id)
    {
        $instructor = Auth::user();

        $modulo = DB::table('modulos')->where('id_modulo', $id)->first();
        if (!$modulo) abort(404);

        // Verificar ownership
        $curso = DB::table('cursos')
            ->where('id_curso', $modulo->id_curso)
            ->where('id_instructor', $instructor->id_usuario)
            ->first();
        if (!$curso) abort(403);

        // Borrar archivos PDF físicos
        $contenidos = DB::table('contenidos')->where('id_modulo', $id)->get();
        foreach ($contenidos as $con) {
            if ($con->tipo === 'pdf') {
                Storage::disk('public')->delete($con->url);
            }
        }

        // Borrar registros (la BD debería tener cascade, pero lo hacemos explícito o confiamos en cascade)
        // Como estamos usando Query Builder, el cascade de BD es vital.
        // Si no hay cascade, tendríamos que borrar preguntas, opciones, etc.
        // Asumiremos integridad referencial en la BD o borraremos manualmente.
        
        DB::table('modulos')->where('id_modulo', $id)->delete();

        return redirect()->route('instructor.modulos', $modulo->id_curso)
            ->with('success', 'Módulo eliminado correctamente.');
    }


    // ─────────────────────────────────────────────
    //  DETALLE DE MÓDULO
    // ─────────────────────────────────────────────

    public function moduloDetalle($id_curso, $id_modulo)
    {
        $instructor = Auth::user();

        $curso = DB::table('cursos')
            ->where('id_curso', $id_curso)
            ->where('id_instructor', $instructor->id_usuario)
            ->first();

        if (!$curso) abort(403);

        $modulo = DB::table('modulos')
            ->where('id_modulo', $id_modulo)
            ->where('id_curso', $id_curso)
            ->first();

        if (!$modulo) abort(404);

        // Contenidos (PDF) del módulo
        $contenidos = DB::table('contenidos')
            ->where('id_modulo', $id_modulo)
            ->get();

        // Examen del módulo (uno a uno)
        $examen = DB::table('examenes')
            ->where('id_modulo', $id_modulo)
            ->first();

        // Preguntas y opciones del examen
        $preguntas = collect();
        $opciones   = collect();
        if ($examen) {
            $preguntas = DB::table('preguntas')
                ->where('id_examen', $examen->id_examen)
                ->orderBy('id_pregunta')
                ->get();

            $opciones = DB::table('opciones')
                ->whereIn('id_pregunta', $preguntas->pluck('id_pregunta'))
                ->get()
                ->groupBy('id_pregunta');
        }

        return view('instructor.modulo', compact(
            'curso', 'modulo', 'contenidos', 'examen', 'preguntas', 'opciones'
        ));
    }

    public function storeExamenModulo(Request $request, $id_curso, $id_modulo)
    {
        // Verificar ownership
        $curso = DB::table('cursos')
            ->where('id_curso', $id_curso)
            ->where('id_instructor', Auth::user()->id_usuario)
            ->first();
        if (!$curso) abort(403);

        // Solo se permite un examen por módulo
        $yaExiste = DB::table('examenes')->where('id_modulo', $id_modulo)->exists();
        if ($yaExiste) {
            return redirect()->route('instructor.modulo.detalle', [$id_curso, $id_modulo])
                ->with('error', 'Este módulo ya tiene un examen asignado.');
        }

        $validated = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('examenes')->insert([
            'titulo'      => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'id_modulo'   => $id_modulo,
        ]);

        return redirect()->route('instructor.modulo.detalle', [$id_curso, $id_modulo])
            ->with('success', 'Examen creado. Ahora agrega las preguntas.');
    }

    public function deletePregunta($id_pregunta)
    {
        // Borrar la pregunta (cascade elimina sus opciones)
        DB::table('preguntas')->where('id_pregunta', $id_pregunta)->delete();
        return back()->with('success', 'Pregunta eliminada.');
    }

    // ─────────────────────────────────────────────
    //  DIPLOMADOS (REEMPLAZA A EVALUACIONES)
    // ─────────────────────────────────────────────

    public function diplomados()
    {
        $instructor = Auth::user();
        $diplomados = DB::table('diplomados')->get();

        $conteoCursos = DB::table('diplomado_cursos')
            ->select('id_diplomado', DB::raw('count(*) as total'))
            ->groupBy('id_diplomado')
            ->get()
            ->keyBy('id_diplomado');

        return view('instructor.diplomados', compact('diplomados', 'conteoCursos'));
    }

    public function storeDiplomado(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:200',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('diplomados')->insert([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        return back()->with('success', 'Diplomado creado correctamente.');
    }

    public function updateDiplomado(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:200',
            'descripcion' => 'nullable|string',
        ]);

        DB::table('diplomados')->where('id_diplomado', $id)->update([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        return back()->with('success', 'Diplomado actualizado.');
    }

    public function deleteDiplomado($id)
    {
        // Limpiar pivot manualmente por si no hay cascade en DB
        DB::table('diplomado_cursos')->where('id_diplomado', $id)->delete();
        DB::table('diplomados')->where('id_diplomado', $id)->delete();
        
        return redirect()->route('instructor.diplomados')->with('success', 'Diplomado eliminado.');
    }

    public function diplomadoDetalle($id)
    {
        $diplomado = DB::table('diplomados')->where('id_diplomado', $id)->first();
        if (!$diplomado) abort(404);

        $cursosAsignados = DB::table('diplomado_cursos')
            ->join('cursos', 'diplomado_cursos.id_curso', '=', 'cursos.id_curso')
            ->where('id_diplomado', $id)
            ->get();

        $instructor = Auth::user();
        $idsAsignados = $cursosAsignados->pluck('id_curso');
        
        $cursosDisponibles = DB::table('cursos')
            ->where('id_instructor', $instructor->id_usuario)
            ->whereNotIn('id_curso', $idsAsignados->isNotEmpty() ? $idsAsignados : [0])
            ->get();

        return view('instructor.diplomado_detalle', compact('diplomado', 'cursosAsignados', 'cursosDisponibles'));
    }

    public function addCursoDiplomado(Request $request, $id)
    {
        $validated = $request->validate([
            'id_curso' => 'required|exists:cursos,id_curso'
        ]);

        $existe = DB::table('diplomado_cursos')
            ->where('id_diplomado', $id)
            ->where('id_curso', $validated['id_curso'])
            ->exists();

        if (!$existe) {
            DB::table('diplomado_cursos')->insert([
                'id_diplomado' => $id,
                'id_curso'     => $validated['id_curso']
            ]);
        }

        return back()->with('success', 'Curso agregado al diplomado.');
    }

    public function removeCursoDiplomado($id_diplomado, $id_curso)
    {
        DB::table('diplomado_cursos')
            ->where('id_diplomado', $id_diplomado)
            ->where('id_curso', $id_curso)
            ->delete();

        return back()->with('success', 'Curso removido del diplomado.');
    }

    // ─────────────────────────────────────────────
    //  CALIFICACIONES
    // ─────────────────────────────────────────────

    public function calificaciones()
    {
        $instructor = Auth::user();

        $cursos = DB::table('cursos')
            ->where('id_instructor', $instructor->id_usuario)
            ->pluck('id_curso');

        $modulos = DB::table('modulos')
            ->whereIn('id_curso', $cursos)
            ->pluck('id_modulo');

        $examenes_ids = DB::table('examenes')
            ->whereIn('id_modulo', $modulos)
            ->pluck('id_examen');

        $notas = DB::table('notas')
            ->join('usuarios', 'notas.id_usuario', '=', 'usuarios.id_usuario')
            ->join('examenes', 'notas.id_examen', '=', 'examenes.id_examen')
            ->join('modulos', 'examenes.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->whereIn('notas.id_examen', $examenes_ids)
            ->select(
                'notas.id_nota',
                'notas.puntaje_obtenido',
                'notas.fecha_examen',
                'usuarios.nombre',
                'usuarios.apellido',
                'usuarios.dni',
                'examenes.titulo as examen_titulo',
                'cursos.titulo as curso_titulo'
            )
            ->orderBy('notas.fecha_examen', 'desc')
            ->get();

        return view('instructor.calificaciones', compact('notas'));
    }

    public function updateNota(Request $request, $id)
    {
        $validated = $request->validate([
            'puntaje_obtenido' => 'required|integer|min:0',
        ]);

        DB::table('notas')
            ->where('id_nota', $id)
            ->update(['puntaje_obtenido' => $validated['puntaje_obtenido']]);

        return back()->with('success', 'Calificación actualizada.');
    }
}

