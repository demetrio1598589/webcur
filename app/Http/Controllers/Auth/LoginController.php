<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request) {
        // 1. Validar la entrada
        $credentials = $request->validate([
            'dni' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Intentar autenticar (con validación de estado activo)
        if (Auth::attempt(['dni' => $credentials['dni'], 'password' => $credentials['password'], 'estado' => 'activo'])) {
            $request->session()->regenerate(); // Seguridad contra fijación de sesión
            $user = Auth::user();
            
            // Redirect inteligente si solo tiene 1 rol
            if ($user->roles->count() === 1) {
                if ($user->hasRole('gerencia')) return redirect()->intended(route('gerente.home'));
                if ($user->hasRole('instructor')) return redirect()->intended(route('instructor.home'));
            }
            
            return redirect()->intended('dashboard');
        }

        // 3. Si falla
        return back()->withErrors([
            'dni' => 'Las credenciales no coinciden con nuestros registros o el usuario está inactivo.',
        ])->onlyInput('dni');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
