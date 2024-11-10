<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cajero;
use App\Models\Historialcajero;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class CajeroController extends Controller
{
    public function cambiarEstado(Request $request, $id)
    {
        $cajero = Cajero::findOrFail($id);

        // Obtener el valor del checkbox y asignarlo directamente al estado del cajero
        $cajero->estado = $cajero->estado === 'activo' ? 'inactivo' : 'activo';
        $cajero->save();

        // Puedes redirigir a una página específica o simplemente regresar
        return back()->with('success', 'Estado del cajero actualizado correctamente.');
    }

    public function nombre()
    {
        $nombre = Auth::user()->name;
        return $nombre;
    }

    public function index(Request $request)
    {
        $text = trim($request->get('text'));

        $query = Cajero::where('id_empresa', auth()->user()->id)
            ->where(function ($query) use ($text) {
                $query->where('name', 'LIKE', '%' . $text . '%')
                    ->orWhere('email', 'LIKE', '%' . $text . '%');
            })
            ->orderBy('name', 'asc');

        $cajeros = $query->paginate(5);

        return view('cajero.index', compact('cajeros', 'text'));
    }

    public function create()
    {
        return view('cajero.crear');
    }

    public function store(Request $request)
    {
        $estado = $request->input('estado', 'inactivo');
        $request->validate([
    'name' => 'required|string',
    'lastname' => 'required|string',
    'imagen' => 'required|image|max:1024',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6',
    'estado' => 'required',
]);

$perfil = $request->all();

// Asigna el valor de 'cambio_contraseña'
$perfil['cambio_contraseña'] = 0;

// Resto de tu lógica para manejar la imagen y otros campos
if ($imagen = $request->file('imagen')) {
    $rutaGuardarImg = 'imagen/';
    $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
    $imagen->move($rutaGuardarImg, $imagenPerfil);
    $perfil['imagen'] = $imagenPerfil;
}

$company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();

// Asigna el valor de 'id_empresa'
$perfil['id_empresa'] = $company;

// Crea el cajero
$cajero = Cajero::create([
    'name' => $perfil['name'],
    'lastname' => $perfil['lastname'],
    'imagen' => $perfil['imagen'],
    'email' => $perfil['email'],
    'password' => bcrypt($perfil['password']),
    'estado' => $perfil['estado'],
    'cambio_contraseña' => $perfil['cambio_contraseña'],
    'id_empresa' => $perfil['id_empresa'],
]);

session()->flash('Correcto', 'Se creó correctamente');
return redirect()->route('cajero.index', compact('cajero'));
    }

    public function show($cajeroId)
    {
        $historialCajero = Historialcajero::where('cajero_id', $cajeroId)->get();
        return view('cajero.show', ['historialCajero' => $historialCajero]);
    }

    public function edit(string $id)
    {
        $cajero = Cajero::find($id);

        return view('cajero.editar', compact('cajero'));
    }

    public function update(Request $request, string $id)
 
        {
            
        
            $request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:users,email,' . $id,
                'imagen' => 'required|image|max:1024',
                
              
            ]);
        
            
            $cajero = Cajero::find($id);

          
        
           
            // Handle image upload
            if ($imagen = $request->file('imagen')) {
               
                if (file_exists(public_path('imagen/' . $cajero->imagen))) {
                    unlink(public_path('imagen/' . $cajero->imagen));
                }
        
                // Save the new image
                $rutaGuardarImg = 'imagen/';
                $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
                $imagen->move($rutaGuardarImg, $imagenPerfil);
        
                $input['imagen'] = $imagenPerfil;
            }
        
            // Update the employee record
            $cajero->save();
            session()->flash('editar', '¡Usuario editado correctamente!');
            return redirect()->route('cajero.index');
        }
        
        

    public function destroy(string $id)
    {
        $cajero = Cajero::find($id);
    
        // Optionally, you can delete the associated image if it exists
        if ($cajero->imagen && file_exists(public_path('imagen/' . $cajero->imagen))) {
            unlink(public_path('imagen/' . $cajero->imagen));
        }
    
        $cajero->delete();
        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('cajero.index');
    }
    

    public function actualizaresta(string $id)
    {
        // Implementa la lógica para actualizar el estado si es necesario
    }
    public function cambiocontraseñacajero(){
        $cajero = Auth::guard('cajero')->user();
        

        return view('persona.contraseñacajero', compact('cajero'));
    }
    public function changepasswordcajero(Request $request, string $idcajero)
    {
        $cajero= Cajero::find($idcajero);

        $valoractual= $request->input('actualcajero');
        $valornueva=$request->input('nuevacajero');
        $valorconfirmar=$request->input('confirmarcajero');

        if($valornueva === $valorconfirmar)
        {
            if(Hash::check($valoractual, $cajero->password))
            {
                $cajero->password= bcrypt($valornueva);
                $cajero->cambio_contraseña = true;
                $cajero->save();

                return response()->json(['exito' => 'Se ha cambiado correctamente']);
            }
            else{

                return response()->json(['error' => 'la clave actual no es valida']);
            }
            
        }else{

            return response()->json(['error' => 'Las claves no coinciden']);
        }

    }
    
}
