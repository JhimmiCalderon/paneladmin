@extends('layouts.empleado')

@section('title','Usuarios')

@section('content')
<style>
    #view {
        display: block;
    }

    .carde {
        overflow: hidden;
        position: relative;
        text-align: left;
        border-radius: 0.5rem;
        max-width: 290px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        background-color: #fff;
    }

    .dismisss {
        position: absolute;
        right: 10px;
        top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        background-color: #fff;
        color: black;
        border: 2px solid #D1D5DB;
        font-size: 1rem;
        font-weight: 300;
        width: 30px;
        height: 30px;
        border-radius: 7px;
        transition: .3s ease;
    }

    .dismisss:hover {
        background-color: #ee0d0d;
        border: 2px solid #ee0d0d;
        color: #fff;
    }


    .images {
        display: flex;
        margin-left: auto;
        margin-right: auto;
        background-color: #e2feee;
        flex-shrink: 0;
        justify-content: center;
        align-items: center;
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        animation: animate .6s linear alternate-reverse infinite;
        transition: .6s ease;
    }

    .images svg {
        color: #0afa2a;
        width: 2rem;
        height: 2rem;
    }

    .contents {
        margin-top: 0.75rem;
        text-align: center;
    }

    .titles {
        color: #066e29;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5rem;
    }

    .messages {
        margin-top: 0.5rem;
        color: #595b5f;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .actionss {
        margin: 0.75rem 1rem;
    }

    .historys {
        display: inline-flex;
        padding: 0.5rem 1rem;
        background-color: #1aa06d;
        color: #ffffff;
        font-size: 1rem;
        line-height: 1.5rem;
        font-weight: 500;
        justify-content: center;
        width: 100%;
        border-radius: 0.375rem;
        border: none;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .tracks {
        display: inline-flex;
        margin-top: 0.75rem;
        padding: 0.5rem 1rem;
        color: #242525;
        font-size: 1rem;
        line-height: 1.5rem;
        font-weight: 500;
        justify-content: center;
        width: 100%;
        border-radius: 0.375rem;
        border: 1px solid #D1D5DB;
        background-color: #fff;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    @keyframes animate {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.09);
        }
    }
</style>
@if (auth()->user()->cambio_contraseña == false)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
    <a href="{{ route('cambiocontraseñaempleado') }}" class="alert-link">Cambiar Contraseña</a>
</div>
@endif

<main class="container">
    <div class="text-center">
        <h3 class="login">Personas Pendientes</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Observación</th>
                            <th>Procesos</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Historial</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personas as $persona)
                        @if($persona->procesos != 'Completo')
                        <tr>
                            <td>{{ $persona->name }} {{ $persona->lastname }}</td>
                            <td>{{ $persona->observacion }}</td>
                            <td>
                                @foreach ($persona->procesos as $persoproceso)
                                @if($persoproceso->pivot->estado === 'Completo')
                                <span>{{ $persoproceso->proceso }}<ion-icon name="checkmark-outline"></ion-icon></span>
                                @else
                                <h6>{{$persoproceso->proceso}} <ion-icon name="alert-circle-outline"></ion-icon></h6>
                                @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if($persona->estado === 'disponible')
                                <span class="badge bg-success">{{ $persona->estado }}</span>
                                @elseif($persona->estado === 'ocupado')

                                <span class="badge bg-info">En proceso</span>
                                @else
                                <span class="badge bg-danger">{{ $persona->estado }}</span>
                                @endif
                            </td>

                            </td>
                            <td class="text-center">

                                <a href="{{ route('empleado.show', $persona->id) }}"><ion-icon name="eye"></ion-icon></a>
                            </td>
                            <td class="text-center">
                                @foreach ($procesos as $proceso)
                                <form action="{{ route('proceso.agregarPersona', [$persona->id, $proceso->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="proceso_id" value="{{ $proceso->id }}">
                                    <input type="hidden" name="persona_id" value="{{ $persona->id }}">

                                    @if ($proceso->id == auth()->user()->puesto)
                                    <div id="container-{{$persona->id}}">
                                        <button>
                                            <span class="circle" aria-hidden="true">
                                                <span class="icon arrow"></span>
                                            </span>
                                            <span class="button-text">Agregar</span>
                                        </button>
                                        @endif
                                </form>
                                @endforeach
                                <div id="view" >
                                    <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#agregar{{$persona->id}}">
                                        
                                    </a>
                                </div>
            </div>
            </td>


            </tr>

            @endif

            @foreach ($procesos as $proceso)
            @if (Auth::user()->puesto == $proceso->id)
            @foreach ($proceso->personas as $personaProceso)
            @if ($personaProceso->pivot->activar)
            <div class="modal fade" id="agregar{{$personaProceso->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog mx-auto">
                    <div class="modal-content" style="border-color:black">
                        <div class="modal-header" style="background-color: white">
                            <h1 class="modal-title"><strong>{{ $proceso->proceso }}</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <h5 class="login"></h5>
                            <div class="card" style="margin-top: 30px;">
                                <form action="{{ route('proceso.persona.detach', ['procesoId' => $proceso->id, 'personaId' => $personaProceso->id]) }}" method="POST">
                                    @csrf
                                    <button class="dismisss" type="submit">x</button>
                                </form>
                                <div class="images"></div>
                                <div class="contents">
                                    <span class="titles">{{ $personaProceso->name }} {{ $personaProceso->lastname }}</span>
                                    <p class="messages">{{ $personaProceso->observacion }}</p>
                                    <p>Estado: {{ $personaProceso->pivot->estado }}</p>
                                </div>
                                <div class="actionss">
                                    <form action="{{ route('proceso.persona.Completo', ['procesoId' => $proceso->id, 'personaId' => $personaProceso->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button class="historys" type="submit">Completo</button>
                                    </form>
                                    <form action="{{ route('proceso.persona.Rechazado', ['procesoId' => $proceso->id, 'personaId' => $personaProceso->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button class="tracks" type="submit">Rechazado</button>
                                    </form>
                                </div>
                            </div>
                            @if ($personaProceso->pivot->estado == 'Pendiente')
                            <!-- Código específico si el estado es 'Pendiente' -->
                            @elseif ($personaProceso->pivot->estado == 'Rechazado')
                            <!-- Código específico si el estado es 'Rechazado' -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
            @endforeach

            @endforeach

            </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <!-- Aquí puedes agregar controles de paginación si es necesario -->
    </div>
    </div>

</main>


@endsection