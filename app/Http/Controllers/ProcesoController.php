<?php

namespace App\Http\Controllers;

use App\Models\Historialservicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Persona;



use App\Models\Proceso;

class ProcesoController extends Controller
{


    public function nombre()
    {
        $nombre = Auth::user()->name;
        return $nombre;
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $personas = Persona::all();
        $procesospropios = Proceso::where('id_empresa', auth()->user()->id)
                            ->get();
        
        $procesos = Proceso::with('personas')->get();
        
        return view('procesos/index', compact('procesospropios', 'personas','procesos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        return view('procesos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'proceso' => 'required|string',
     
        'contenido' => 'required|string',
    ]);

    $company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();

    $proceso = Proceso::create([
        'proceso' => $request->input('proceso'),
       
        'contenido' => $request->input('contenido'),
        'id_empresa' => $company,
    ]);

    session()->flash('Correcto', 'Se creó correctamente');
    return redirect()->route('procesos.index', compact('proceso'));
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceso $proceso)
    {
        return view('procesos.editar', compact('proceso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proceso $proceso)
{

    // Validar los datos del formulario
    $request->validate([
        'proceso' => 'required',
   
        'contenido' => 'required',
    ]);

    // Actualizar los campos específicos del modelo
    $proceso->update([
        'proceso' => $request->input('proceso'),
       
        'contenido' => $request->input('contenido'),
        // Agrega más campos si es necesario
    ]);
    session()->flash('editar', '¡Servicio editado correctamente!');
    // Redirigir a la ruta de índice después de la actualización
    return redirect()->route('procesos.index');
}


    public function show($procesoId)
    {
       

        $historialServicio = Historialservicio::where('proceso_id', $procesoId)->get();
            return view('procesos.show',['historialServicio' => $historialServicio]);
        
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('procesos.index');
    }

}
