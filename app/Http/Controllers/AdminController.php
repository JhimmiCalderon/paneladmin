<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Proceso;
use Exception;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Cajero;
use App\Models\Empleado;
use App\Models\Persona;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{

    public function cambiarEstado(Request $request, $id)
    {
        $usuario = Admin::findOrFail($id);

        // Obtener el valor del checkbox y asignarlo directamente al estado del usuario
        $usuario->estado = $usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $usuario->save();

        // Puedes redirigir a una página específica o simplemente regresar
        return back()->with('success', 'Estado del usuario actualizado correctamente.');
    }



    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)

    {

        $text = trim($request->get('text'));

        $usuarios = DB::table('admins')->select('id', 'imagen', 'nit', 'direccion', 'name', 'email', 'estado')
            ->where('name', 'LIKE', '%' . $text . '%')
            ->orWhere('email', 'LIKE', '%' . $text . '%')
            ->orderBy('name', 'asc')
            ->paginate();

        $procesos = Proceso::All();


        return view('superadmin.index', compact('usuarios', 'text'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('superadmin.crear');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $estado = $request->input('estado', 'inactivo');

        $request->validate([
            'name' => 'required|string',
            'nit' => 'required|string',
            'direccion' => 'required|string',
            'imagen' => 'required|max:1024',
            'email' => 'required|email|unique:users,email',
            'estado' => 'required',
        ]);

        $contraseña = $request->nit;
        $perfil = $request->all();
        $perfil['cambio_contraseña'] = 0;

        if ($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'imagen/';
            $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPerfil);
            $perfil['imagen'] = $imagenPerfil;
        }


        $empresa = Admin::create([
            'name' => $perfil['name'],
            'imagen' => $perfil['imagen'],
            'direccion' => $perfil['direccion'],
            'nit' => $perfil['nit'],
            'email' => $perfil['email'],
            'password' => bcrypt($perfil['password'] ?? $contraseña),
            'estado' => $perfil['estado'],
            'cambio_contraseña' => $perfil['cambio_contraseña'],
        ]);

        session()->flash('Correcto', 'Se creó correctamente');
        return redirect()->route('superadmin.index', compact('empresa'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('superadmin.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user =  Admin::find($id);

        return view('superadmin.editar', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

      
        $user = Admin::find($id);
        $this->validate($request, [
            'name' => 'required',
            'direccion' => 'required',
            'nit' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'imagen' => 'image|max:1024',

        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
        if ($imagen = $request->file('imagen')) {

            if (file_exists(public_path('imagen/' . $user->imagen))) {
                unlink(public_path('imagen/' . $user->imagen));
            }
            $rutaGuardarImg = 'imagen/';
            $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPerfil);

            $input['imagen'] = $imagenPerfil;
        }

      $user->update([
            'name' => $request->input('name'),
            'direccion' => $request->input('direccion'),
            'nit' => $request->input('nit'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'imagen' => $request->file('imagen')
        ]);

    
        session()->flash('editar', '¡Usuario editado correctamente!');
        return redirect()->route('superadmin.index');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(string $id)
    {
        $user = Admin::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->route('superadmin.index')->withErrors(['message' => 'User not found']);
        }

        // Eliminar la imagen asociada al usuario si existe
        if ($user->imagen && file_exists(public_path('imagen/' . $user->imagen))) {
            unlink(public_path('imagen/' . $user->imagen));
        }

        // Check and delete related empleados
        if ($user->empleados()->count() > 0) {
            $user->empleados()->delete();
        }

        // Check and delete related cajero
        if ($user->cajero) {
            $user->cajero->delete();
        }

        // Check and delete related proceso
        if ($user->proceso()->count() > 0) {
            $user->proceso()->delete();
        }
        if ($user->servicio()->count() > 0) {
            $user->servicio()->delete();
        }

        // Delete the user
        $user->delete();

        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('superadmin.index');
    }

    public function cambiocontraseña()
    {
        $admin = Auth::guard('admin')->user();


        return view('admin.contraseña', compact('admin'));
    }
    public function changepassword(Request $request, string $idadmin)
    {
        $admin = Admin::find($idadmin);

        $valoractual = $request->input('actual');
        $valornueva = $request->input('nueva');
        $valorconfirmar = $request->input('confirmar');

        if ($valornueva === $valorconfirmar) {
            if (Hash::check($valoractual, $admin->password)) {
                $admin->password = bcrypt($valornueva);
                $admin->cambio_contraseña = true;
                $admin->save();

                return response()->json(['exito' => 'Se ha cambiado correctamente']);
            } else {

                return response()->json(['error' => 'la clave actual no es valida']);
            }
        } else {

            return response()->json(['error' => 'Las claves no coinciden']);
        }
    }

    public function pruebawhatsapp(){

        $numero= "573214451930";
        $message="termino este proceso";
        $access_token= "6487dcb986ce6";
        $type= "text";
        $instance_id="91148509e38e";
        $url = "http://137.184.93.41/send?number=$numero&type=$type&instance_id=$instance_id&access_token=$access_token&message=$message";

        $response= Http::get($url);
        try{
            if($response->successful()){
                $data = $response->json();
                dd($data);
        }
        
    }catch(Exception $e)
    {
        return dd($e);
    }
    }
}
