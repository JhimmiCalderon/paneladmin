<?php

namespace App\Http\Controllers;

use App\Models\Historialcajero;
use App\Models\Historialpersona;
use App\Models\Historialempleado;
use App\Models\Historialservicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Proceso;

use App\Models\Persona;
use App\Models\Servicio;
use Exception;
use Illuminate\Support\Facades\Http;

class PersonaController extends Controller
{
    public function nombre()
    {
        $nombre = Auth::user()->name;
        return $nombre;
    }

    public function idEmpresa()
    {
        $id_empresa = Auth::user()->id; // Reemplaza 'id_empresa' con el nombre real del campo en tu tabla.
        return $id_empresa;
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Proceso $proceso)
    {

        $procesos = Proceso::all();
        $empleado = Auth::guard('empleado')->user();
        $idempresa = $empleado->id_empresa;
        $estado = "disponible";
        $idproceso = $proceso->id;

        // Obtener el proceso del empleado autenticado
        $puestoAutenticado =  $empleado->puesto;

        // Obtener las personas que tienen el mismo proceso que el empleado autenticado y estado no completo
        $personas = Persona::where('id_empresa', $idempresa)

            ->whereHas('procesos', function ($query) use ($puestoAutenticado) {
                $query->where('proceso_id', $puestoAutenticado)
                    ->where('estado', '!=', 'completo'); // Supongamos que el campo es 'estado'
            })
            ->get();

        $procesosSeleccionados = $request->input('procesos', []);
        $procesosString = implode(', ', $procesosSeleccionados);



        return view('empleado.index', compact('personas', 'empleado', 'procesos', 'puestoAutenticado', 'procesosSeleccionados', 'proceso'));
    }


    public function indexcajero()
    {
        $empleado = Auth::guard('cajero')->user();
        $idempresa = $empleado->id_empresa;

        // Obtener personas con la relación de procesos y contar relaciones completas
        $personas = Persona::withCount([
            'procesos',
            'procesos as relaciones_completas' => function ($query) {
                $query->where('estado', 'Completo');
            }
        ])
            ->whereColumn('contador', '=', 'relaciones_completas')
            ->get();

        // Obtener procesos de la empresa del cajero
        $procesos = Proceso::where('id_empresa', $idempresa)->get();

        // Obtener servicios propios de la empresa del cajero
        $serviciospropios = Servicio::where('id_empresa', $idempresa)->get();

        return view('persona.index', compact('empleado', 'procesos', 'personas', 'serviciospropios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleado = Auth::guard('cajero')->user();
        $idempresa = $empleado->id_empresa;
        $procesos = Proceso::where('id_empresa', $idempresa)->get();
        return view('persona.crear', compact('empleado', 'procesos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'observacion' => 'required',
            'numero_celular' => 'required',
            'email' => 'required|email|unique:users,email',
            'estado' => 'required',
            'id_empresa' => 'required',

        ]);
        $procesosSeleccionados = $request->input('id_procesos', []);

        // Convierte los valores de $procesosSeleccionados en una cadena para almacenarlos en la columna 'procesos'
        $procesosString = implode(',', $procesosSeleccionados);


        $company = DB::table('admins')->where('name', $this->nombre())->select('id')->pluck('id')->first();

        $persona = Persona::create([
            'name' => $request->input('name', 'required'),
            'lastname' => $request->input('lastname', 'required'),
            'observacion' => $request->input('observacion', 'required'),
            'numero_celular' => $request->input('numero_celular', 'required'),
            'email' => $request->input('email', 'required|unique:users,email'),
            'estado' => $request->input('estado'),
            'entregar' => false,
            'id_empresa' => $request->input('id_empresa'),
            'id_procesos' => $procesosString, // Almacenar los procesos como una cadena separada por comas


        ]);

        // Obtener el ID de la persona recién creada
        $personaId = $persona->id;

        // Asociar la persona a los procesos seleccionados en la tabla pivot
        foreach ($procesosSeleccionados as $procesoId) {
            // Verificar si el proceso existe antes de agregar la relación
            $proceso = Proceso::find($procesoId);
            if ($proceso) {
                // Agregar la persona al proceso en la tabla pivot con el estado 'pendiente'
                $persona->procesos()->attach($procesoId, ['estado' => 'Pendiente', 'activar' => false]);
            }
        }
        $persona->contador = count($procesosSeleccionados);
        $persona->save();

        $cajeroId = Auth::guard('cajero')->id();
        Historialcajero::create([
            'cajero_id' => $cajeroId,
            'accion' => 'Registro a: ' . $persona,
        ]);

        session()->flash('Correcto', 'se creo correctamente');
        return redirect()->route('persona.index', compact('persona'));
    }


    /**
     * Display the specified resource.
     */
    public function show($personaId)
    {
        $historialPersona = Historialpersona::where('persona_id', $personaId)->get();
        return view('empleado.show', ['historialPersona' => $historialPersona]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empleado = Auth::guard('empleado')->user();
        $persona =  Persona::find($id);
        $idempresa = $empleado->id_empresa;
        $procesos = Proceso::where('id_empresa', $idempresa)->get();

        return view('empleado.editar', compact('persona', 'procesos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $procesosSeleccionados = $request->input('id_procesos', []);
        $procesosString = implode(', ', $procesosSeleccionados);

        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'observacion' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'numero_celular' => 'required',

        ]);

        $input = $request->all();


        // Actualiza el campo 'procesos' con la cadena generada a partir del array
        $input['id_procesos'] = $procesosString;

        $persona = Persona::find($id);
        $persona->update($input);
        session()->flash('editar', '¡Usuario editado correctamente!');
        return redirect()->route('empleado.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Persona::find($id)->delete();
        session()->flash('eliminar', 'Se eliminó correctamente');
        return redirect()->route('empleado.index');
    }



    public function entregar($id)
    {

        $persona = Persona::find($id);

        $nombre = Persona::find($id)?->name;
        $apellido = Persona::find($id)?->lastname;
        $nombre = Persona::find($id)?->name;

        if (!$persona) {
            return redirect()->route('persona .index')->with('error', 'Empleado no encontrado');
        }
        $cajeroId = Auth::guard('cajero')->id();
        Historialcajero::create([
            'cajero_id' => $cajeroId,
            'accion' => 'Registro a: ' . $nombre, $apellido,
        ]);
        $persona->delete();
        session()->flash('Finalizo', 'Se eliminó correctamente');
        return redirect()->route('persona.index');
    }
    public function agregarPersona(string $id, Request $request)
    {

        $persona = Persona::find($id);


        if (!$persona) {
            return redirect()->route('empleado.index')->with('error', 'Persona no encontrada');
        }

        $procesoId = $request->input('proceso_id');



        DB::transaction(function () use ($persona, $procesoId) {
            // Actualizar el estado de la persona a 'ocupado'
            $persona->estado = 'ocupado';
            $persona->save();
            $proceso = Proceso::find($procesoId);
            $empleadoId = auth()->user()->id;
            // Activar la persona en el proceso
            $persona->procesos()->updateExistingPivot($procesoId, ['activar' => true]);

            Historialservicio::create([
                'proceso_id' => $procesoId,
                'accion' => 'Se agregó a la persona: ' . $persona->name,
            ]);

            // Registrar la acción en el historial
            Historialempleado::create([
                'empleado_id' => Auth::guard('empleado')->user()->id,
                'accion' => 'Agregó a: ' . $persona->name . ' en el servicio: ' . $proceso->proceso,
            ]);

            Historialpersona::create([
                'persona_id' => $persona->id,
                'proceso_id' => $procesoId,
                'accion' => 'Agregó al proceso: ' . $proceso->proceso . ' por ' . Auth::guard('empleado')->user()->name,
            ]);
        });

        return redirect()->route('empleado.index')->with('success', 'Persona actualizada en el proceso con éxito');
    }


    public function Completo($procesoId, $personaId)
    {

        $proceso = Proceso::find($procesoId);
        $nombreproceso = $proceso->proceso;
        $message = "Pasaste el proceso de: " . $nombreproceso;
        $access_token = "6487dcb986ce6";
        $type = "text";
        $instance_id = "91148509e38e";

        if (!$proceso) {
            return redirect()->route('empleado.index')->with('error', 'Proceso no encontrado');
        }
        $persona = Persona::find($personaId);
        $proceso = Proceso::find($procesoId);
        $proceso->personas()->updateExistingPivot($personaId, ['estado' => 'completo']);

        // Actualizar el estado de la persona en la tabla pivot a 'Completo'
        $proceso->personas()->updateExistingPivot($personaId, ['activar' => false]);

        // Recuperar la persona y establecer su estado como "disponible"
        $persona = Persona::find($personaId);
        $numeroPersona = $persona->numero_celular;
        if ($persona) {
            $persona->estado = 'disponible';
            $persona->save();

            // Calcular la cantidad de personas con estado 'completo'
            $Completas = DB::table('persona_proceso')
            ->where('persona_id', $personaId)
            ->where('estado', 'completo')
            ->count();
    
            // Asignar la cantidad al atributo 'relaciones_completas' del modelo
            $persona->relaciones_completas = $Completas;
            $persona->save();
            }
        

        $this->enviarMsm($numeroPersona, $message, $access_token, $type, $instance_id);


        // Registrar la acción en el historial
        Historialempleado::create([
            'empleado_id' => Auth::guard('empleado')->user()->id,
            'accion' => 'ha Completo a ' . $persona->name . ' En el servicio:' . $proceso->proceso,
        ]);
        Historialpersona::create([

            'persona_id' => $personaId,
            'proceso_id' => $procesoId,
            'accion' => "Actualización de estado:  El servicio '.$proceso->proceso.'  ha sido marcado como 'Completo' por " . Auth::guard('empleado')->user()->name,
        ]);

        return redirect()->route('empleado.index')->with('success', 'Persona marcada como completa y disponible.');
    }

    public function enviarMsm($numeroPersona, $message, $access_token, $type, $instance_id)
    {
        $numeroPersona = '57' . $numeroPersona;
        $url = "http://137.184.93.41/send?number=$numeroPersona&type=$type&instance_id=$instance_id&access_token=$access_token&message=$message";

        $response = Http::get($url);
        try {
            if ($response->successful()) {
                $data = $response->json();
                return ($data);
            }
        } catch (Exception $e) {
            return dd($e);
        }
    }

    public function Rechazado($procesoId, $personaId)

    {

        $proceso = Proceso::find($procesoId);
        $nombreproceso = $proceso->proceso;
        $message = "El proceso de: " . $nombreproceso . "Actuaizo su estado a Rechazado";
        $access_token = "6487dcb986ce6";
        $type = "text";
        $instance_id = "91148509e38e";

        $persona = Persona::find($personaId);
        $proceso = Proceso::find($procesoId);
        $numeroPersona = $persona->numero_celular;
        $proceso->personas()->updateExistingPivot($personaId, ['estado' => 'Rechazado']);
        $this->enviarMsm($numeroPersona, $message, $access_token, $type, $instance_id);
        // Registrar la acción en el historial
        Historialempleado::create([
            'empleado_id' => Auth::guard('empleado')->user()->id,
            'accion' =>  'ha Rachazado a ' . $persona->name . ' En el servicio: ' . $proceso->proceso,
        ]);
        Historialpersona::create([

            'persona_id' => $personaId,
            'proceso_id' => $procesoId,
            'accion' => "Actualización de estado: El servicio '.$proceso->proceso.' ha sido marcado como 'Rechazado' por " . Auth::guard('empleado')->user()->name,
        ]);

        return redirect()->back()->with('success', 'Persona marcada como rechazada.');
    }
    public function detachPersonaFromProceso($procesoId, $personaId)
    {
        $proceso = Proceso::find($procesoId);

        if (!$proceso) {
            return redirect()->route('empleado.index')->with('error', 'Proceso no encontrado');
        }

        // Actualizar la relación en la tabla pivot
        $proceso->personas()->updateExistingPivot($personaId, ['activar' => false]);

        // Recuperar la persona y establecer su estado como "disponible"
        $persona = Persona::find($personaId);
        if ($persona) {
            $persona->estado = 'disponible';
            $persona->save();
        }
        Historialempleado::create([
            'empleado_id' => Auth::guard('empleado')->user()->id,
            'accion' => 'Elimino a la persona: ' . $persona->name . ' Del servicio: ' . $proceso->proceso,
        ]);
        Historialpersona::create([

            'persona_id' => $personaId,
            'proceso_id' => $procesoId,
            'accion' => "Actualización de estado: El servicio '.$proceso->proceso. ha sido  'Eliminado' por " . Auth::guard('empleado')->user()->name,
        ]);

        return redirect()->route('empleado.index')->with('success', 'Persona eliminada y marcada como disponible correctamente');
    }
}
