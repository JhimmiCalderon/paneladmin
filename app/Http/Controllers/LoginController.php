<?php

namespace App\Http\Controllers;

use App\Models\Historialcajero;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Historialempleado;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('login');
    }
    

    public function ingreso(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $guards = ['web', 'admin', 'empleado', 'cajero'];
       
        foreach ($guards as $guard) {
            
            if (Auth::guard($guard)->attempt($credentials + ['estado' => 'activo'])) {
                // Usuario autenticado y activo
                switch ($guard) {
                    case 'web':
                        return redirect()->route('superadmin.index');
                    case 'admin':
                        return redirect()->route('admin.index');
                    case 'empleado':
                        Historialempleado::create([
                            'empleado_id' => Auth::guard('empleado')->user()->id,
                            'accion' => 'Ingreso al sistema'
,
                        ]);
                        return redirect()->route('empleado.index');
                    case 'cajero':
                        Historialcajero::create([
                            'cajero_id' => Auth::guard('cajero')->user()->id,
                            'accion' => 'Ingreso al sistema'

                        ]);
                        return redirect()->route('persona.index');
                }
            }
        }
    
        // Si llegamos aquí, significa que las credenciales no son válidas para ningún guard
        session()->flash('error', 'Su cuenta es incorrecta o no está activa');
        return redirect()->route('login');
    }
    

    

    public function logout(Request $request)
{
    // Registrar el deslogueo del empleado si está autenticado
    if (Auth::guard('empleado')->check()) {
        Historialempleado::create([
            'empleado_id' => Auth::guard('empleado')->user()->id,
            'accion' => 'Finalización de la sesión'

        ]);
    }

    // Registrar el deslogueo del cajero si está autenticado
    if (Auth::guard('cajero')->check()) {
        Historialcajero::create([
            'cajero_id' => Auth::guard('cajero')->user()->id,
            'accion' => 'Finalización de la sesión'

        ]);
    }

    // Realizar el logout
    Auth::logout();

    // Invalidar la sesión y regenerar el token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirigir al usuario a la página de login
    return redirect('/login');
}
}
