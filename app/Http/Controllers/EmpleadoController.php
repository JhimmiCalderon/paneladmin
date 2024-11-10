<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\Empleado;
use App\Models\Proceso;
use App\Models\Historialempleado;
use App\Models\Historialservicio;

class EmpleadoController extends Controller
{
    public function cambiarEstado(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        // Obtener el valor del checkbox y asignarlo directamente al estado del usuario
        $empleado->estado = $empleado->estado === 'activo' ? 'inactivo' : 'activo';
        $empleado->save();

        // Puedes redirigir a una página específica o simplemente regresar
        return back()->with('success', 'Estado del usuario actualizado correctamente.');
    }

    public function nombre()
    {
        $nombre = Auth::user()->name;
        return $nombre;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $text = trim($request->get('text'));

        $query = Empleado::where('id_empresa', auth()->user()->id)
            ->where(function ($query) use ($text) {
                $query->where('name', 'LIKE', '%' . $text . '%')
                    ->orWhere('email', 'LIKE', '%' . $text . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $text . '%')
                    ->orWhere('puesto', 'LIKE', '%' . $text . '%')
                   ;
            })
            ->orderBy('name', 'asc');

        $empleados = $query->paginate();


        $id_empresa = auth()->user()->id;
        $puestos = Proceso::where('id_empresa', $id_empresa)->pluck('proceso', 'id');
                

        return view('admin.index', compact('empleados', 'puestos', 'text'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $puestos = Proceso::pluck('proceso', 'id');
        return view('admin.crear', compact('puestos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'puesto' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'estado' => 'required',
        ]);

       

        $perfil = $request->all();
        $perfil['cambio_contraseña'] = 0;
        if ($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'imagen/';
            $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPerfil);
            $perfil['imagen'] = $imagenPerfil;
        }
        $company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();
        $perfil['id_empresa'] = $company;
     
   
$empleado = Empleado::create([
    'name' => $perfil['name'],
    'lastname' => $perfil['lastname'],
    'imagen' => $perfil['imagen'],
    'email' => $perfil['email'],
    'password' => bcrypt($perfil['password']),
    'puesto' => $perfil['puesto'],
    'estado' => $perfil['estado'],
    'cambio_contraseña' => $perfil['cambio_contraseña'],
    'id_empresa' => $perfil['id_empresa'],
]);
$proceso_id = $request->input('puesto');
    $name = $request->input('name');
    $lastname = $request->input('lastname');
Historialservicio::create([
    'proceso_id' => $proceso_id,
    'accion' => "Registro de incorporación del empleado $name $lastname en este puesto de trabajo"

]);
        session()->flash('Correcto', 'Se creó correctamente');
        return redirect()->route('admin.index', compact('empleado'));
    }



    /**
     * Display the specified resource.
     */
    public function show($empleadoId)
    {
        $historialEmpleado = HistorialEmpleado::where('empleado_id', $empleadoId)->get();
        return view('admin.show', ['historialEmpleado' => $historialEmpleado]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado =  Empleado::find($id);


        return view('admin.editar', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request);
        $request->validate([
            'name' => 'required',
            'puesto' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'imagen' => 'image|mimes:jpeg,png,svg|max:1024',
            'lastname' => 'required', 
        ]);


        $input = $request->all();
        $empleado = Empleado::find($id);

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        // Handle image upload
        if ($imagen = $request->file('imagen')) {
            // Delete the old image if it exists
            if (file_exists(public_path('imagen/' . $empleado->imagen))) {
                unlink(public_path('imagen/' . $empleado->imagen));
            }

            // Save the new image
            $rutaGuardarImg = 'imagen/';
            $imagenPerfil = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenPerfil);

            $input['imagen'] = $imagenPerfil;
        }

        // Update the employee record
        $empleado->update($input);
        session()->flash('editar', '¡Usuario editado correctamente!');
        return redirect()->route('admin.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);

        // Optionally, you can delete the associated image if it exists
        if ($empleado->imagen && file_exists(public_path('imagen/' . $empleado->imagen))) {
            unlink(public_path('imagen/' . $empleado->imagen));
        }

        $empleado->delete();
        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('admin.index');
    }


    public function actualizaresta(string $id)
    {
        $empleado = Empleado::find($id);
        $empleado->estado = 'ocupado';

        $empleado->save();

        return redirect()->route('proceso.show');
    }

    public function cambiocontraseñaempleado()
    {
        $empleado = Auth::guard('empleado')->user();


        return view('empleado.contraseñaempl', compact('empleado'));
    }
    public function changepasswordempleado(Request $request, string $idempleado)
    {
        $empleado = Empleado::find($idempleado);

        $valoractual = $request->input('actualempleado');
        $valornueva = $request->input('nuevaempleado');
        $valorconfirmar = $request->input('confirmarempleado');

        if ($valornueva === $valorconfirmar) {
            if (Hash::check($valoractual, $empleado->password)) {
                $empleado->password = bcrypt($valornueva);
                $empleado->cambio_contraseña = true;
                $empleado->save();

                return response()->json(['exito' => 'Se ha cambiado correctamente']);
            } else {

                return response()->json(['error' => 'la clave actual no es valida']);
            }
        } else {

            return response()->json(['error' => 'Las claves no coinciden']);
        }
    }
}
