<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GerenteController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('gerente.usuarios', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'dni' => 'required|string|unique:usuarios,dni|max:20',
            'password' => 'required|string|min:3',
            'telefono' => 'nullable|string|max:20',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id_rol',
        ]);

        $user = User::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'password' => Hash::make($validated['password']),
            'telefono' => $validated['telefono'] ?? null,
            'estado' => 'activo'
        ]);

        $user->roles()->sync($validated['roles']);

        return back()->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('usuarios', 'email')->ignore($user->id_usuario, 'id_usuario')],
            'dni' => ['required', 'string', 'max:20', Rule::unique('usuarios', 'dni')->ignore($user->id_usuario, 'id_usuario')],
            'telefono' => 'nullable|string|max:20',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id_rol',
            'password' => 'nullable|string|min:3',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $updateData = [
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'telefono' => $validated['telefono'] ?? null,
            'estado' => $validated['estado']
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        $user->roles()->sync($validated['roles']);

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    public function estadisticas()
    {
        $counts = \DB::table('usuario_roles')
            ->join('roles', 'usuario_roles.id_rol', '=', 'roles.id_rol')
            ->select('roles.nombre', \DB::raw('count(*) as total'))
            ->groupBy('roles.nombre')
            ->get();
        
        $totalUsuarios = User::count();
        $totalCursos = \DB::table('cursos')->count();
        
        return view('gerente.estadisticas', compact('counts', 'totalUsuarios', 'totalCursos'));
    }
}
