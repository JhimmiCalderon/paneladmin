<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historialservicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;

use App\Models\Proceso;
use App\Models\Servicio;

class ServicioController extends Controller
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
   
  
        $procesos = Proceso::all();
        $serviciospropios = Servicio::where('id_empresa', auth()->user()->id)->get();
    
        // Obtener todos los servicios con sus procesos relacionados
        $servicios = Servicio::with('procesos')->get();
        return view('servicios.index', compact('serviciospropios','servicios','procesos'));
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
        'name' => 'required|string',
        'precio' => 'required|numeric',
        'contenido' => 'required|string',
        
    ]);

    $procesosSeleccionados = $request->input('id_procesos', []);

    // Convierte los valores de $procesosSeleccionados en una cadena para almacenarlos en la columna 'procesos'
    $procesosString = implode(',', $procesosSeleccionados);
    $company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();

    $servicio = Servicio::create([
        'name' => $request->input('name'),
        'precio' => $request->input('precio'),
        'contenido' => $request->input('contenido'),
        'id_empresa' => $company,
        'id_procesos' => $procesosString,
    ]);

  
     // Obtener el ID de la persona recién creada
     $servicioId = $servicio->id;

     // Asociar la servicio a los procesos seleccionados en la tabla pivot
     foreach ($procesosSeleccionados as $procesoId) {
         // Verificar si el proceso existe antes de agregar la relación
         $proceso = Proceso::find($procesoId);
         if ($proceso) {
            $tipo = $servicio->name;  // Ajusta esto según la estructura de tu modelo de servicio

        $servicio->procesos()->attach($procesoId, ['tipo' => $tipo]);
         }
     }

     $servicio->save();

    session()->flash('Correcto', 'Se creó correctamente');
    return redirect()->route('servicios.index', compact('proceso'));
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
    public function edit(Servicio $servicio)
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
    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'name' => 'required|string',
            'precio' => 'required|numeric',
            'contenido' => 'required|string',
        ]);
    
        $procesosSeleccionados = $request->input('id_procesos', []);
    
        // Convierte los valores de $procesosSeleccionados en una cadena para almacenarlos en la columna 'procesos'
        $procesosString = implode(',', $procesosSeleccionados);
        
        $company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();
    
        $servicio->update([
            'name' => $request->input('name'),
            'precio' => $request->input('precio'),
            'contenido' => $request->input('contenido'),
            'id_empresa' => $company,
            'id_procesos' => $procesosString,
        ]);
    
        // Desvincular todos los procesos existentes antes de asociar los nuevos
        $servicio->procesos()->detach();
    
        // Asociar la servicio a los procesos seleccionados en la tabla pivot
        foreach ($procesosSeleccionados as $procesoId) {
            // Verificar si el proceso existe antes de agregar la relación
            $proceso = Proceso::find($procesoId);
            if ($proceso) {
                $tipo = $servicio->name;  // Ajusta esto según la estructura de tu modelo de servicio
    
                $servicio->procesos()->attach($procesoId, ['tipo' => $tipo]);
            }
        }
    
        session()->flash('editar', '¡Servicio editado correctamente!');
        return redirect()->route('servicios.index', compact('proceso'));
    }
    
 

    public function show($procesoId)
    {
       

       
        
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('servicios.index');
    }
}
