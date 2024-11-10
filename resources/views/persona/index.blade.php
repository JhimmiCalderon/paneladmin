@extends('layouts.cajero')

@section('title', 'Servicios')

@section('content')

<style>
    .hidden{
        display: none;
    }
    .form-control.capitalize {
        text-transform: capitalize;
    }

    body {
        background: white;
    }

    .c {
        margin: 200px auto;
    }

    .black-background {
        background-color: white;
        /* Código de color negro */
        padding: 10px;
        /* Ajusta el relleno según sea necesario */
    }

    /* === removing default button style ===*/
    .button {
        margin: 0;
        height: auto;
        background: transparent;
        padding: 0;
        border: none;
    }

    /* button styling */
    .button {
        --border-right: 6px;
        --text-stroke-color: rgba(201, 187, 187, 0.6);
        --animation-color: #00B7ED;
        --fs-size: 2em;
        letter-spacing: 3px;
        text-decoration: none;
        font-size: var(--fs-size);
        font-family: "Arial";
        position: relative;
        text-transform: uppercase;
        color: black;
        -webkit-text-stroke: 1px var(--text-stroke-color);
    }

    /* this is the text, when you hover on button */
    .hover-text {
        position: absolute;
        box-sizing: border-box;
        content: attr(data-text);
        color: var(--animation-color);
        width: 0%;
        inset: 0;
        border-right: var(--border-right) solid var(--animation-color);
        overflow: hidden;
        transition: 0.5s;
        -webkit-text-stroke: 1px var(--animation-color);
    }

    /* hover */
    .button:hover .hover-text {
        width: 100%;
        filter: drop-shadow(0 0 23px var(--animation-color))
    }
</style>
<div class="modal fade" id="agregarPersonaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-color: black;">
            <div class="modal-header" style="background-color: white; ">
                <h1 style=" text-align: center;" class="modal-title"><strong>Agregar Persona</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Revise los campos del formulario!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                {!! Form::open(array('route' => 'empleado.store', 'method' => 'POST')) !!}
                @csrf

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Nombres</label>
                            {!! Form::text('name', null, array('class'=>'form-control capitalize', 'autocomplete' => 'off')) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="lastname">Apellidos</label>
                            {!! Form::text('lastname', null, array('class'=>'form-control capitalize', 'autocomplete' => 'off')) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="numero_celular">Número Celular</label>
                            {!! Form::text('numero_celular', null, array('class'=>'form-control capitalize', 'autocomplete' => 'off')) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            {!! Form::text('email', null, array('class' => 'form-control','autocomplete' => 'off')) !!}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            {!! Form::textarea('observacion', null, array('class' => 'form-control small-textarea', 'style' => 'resize: vertical; height: 50px;')) !!}
                            <input type="hidden" value="disponible" name="estado">
                            <input type="hidden" value="{{ $empleado->id_empresa }}" name="id_empresa">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <br>
                            <h4 style="background-color: white; text-align: center;">Servicios</h4>
                            <div class="checkbox-container" id="original-checkboxes">
                                @foreach ($serviciospropios as $servicio)
                                <label class="checkbox-inline">
                                    @php
                                    // Convierte la cadena de IDs a un array
                                    $procesosIds = explode(',', $servicio->id_procesos);
                                    @endphp

                                    {{-- Mostrar solo un cuadro de selección --}}
                                    {!! Form::checkbox('select_all', 1, false, ['class' => 'select-all-checkbox', 'data-servicio' => $servicio->id]) !!}
                                    {!! Form::label( '' ) !!}

                                    @foreach ($procesosIds as $procesoId)
                                    {{-- Cuadros de selección ocultos --}}
                                    {!! Form::checkbox('id_procesos[]', $procesoId, false, ['class' => 'original-checkbox servicio-' . $servicio->id, 'data-procesos' => $procesoId, 'style' => 'display: none;']) !!}
                                    @endforeach

                                    {{ $servicio->name }}
                                </label>
                                @endforeach
                            </div>
                            <br>
                        </div>
                    </div>

                </div>
<div id="campoInput" class="hidden">
    <label for="cantidad">Cantidad:</label>
    <input type="number" id="cantidad" name="cantidad">
  </div>
                <div class="col-12">
                    <br>
                    <button type="submit" class="btn btn-dark"><ion-icon name="checkmark-circle-outline"></ion-icon>
                        Guardar</button>
                    <a href="{{ route('persona.index') }}" class="btn btn-danger">Cancelar</a>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-color: black;">
            <div class="modal-header" style="background-color: white; ">
                <h1 style=" text-align: center;" class="modal-title"><strong>Entregar Servicio</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @foreach($personas as $persona)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $persona->name }}</h5>
                        <small>{{ $persona->contador }} relaciones</small>
                    </div>
                    <p class="mb-1">Todas completas: {{ $persona->relaciones_completas }}</p>
                    <a href="{{ route('persona.entregar', ['id' => $persona->id]) }}" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Entregar</a>
                </div>
                @endforeach

                @if ($personas->isEmpty())
                <p class="login">Sin Servicios completos.</p>
                @endif

            </div>
        </div>
    </div>
</div>

<main class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container text-center">
        @if (auth()->user()->cambio_contraseña == false)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
            <a href="{{ route('cambiocontraseñacajero') }}" class="alert-link">Cambiar Contraseña</a>
        </div>
        @endif
        @if ($flash = Session::get('Correcto'))
        <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
            <strong>Correcto</strong> {{ $flash }}
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between black-background">
                            <button class="button" data-text="Awesome" data-bs-toggle="modal" data-bs-target="#agregarPersonaModal" id="Button">
                                <span class="actual-text">&nbsp;Agregar&nbsp;</span>
                                <span aria-hidden="true" class="hover-text">&nbsp;Agregar&nbsp;</span>
                            </button>

                            <button class="button" data-text="Awesome" data-bs-toggle="modal" data-bs-target="#Modal" id="Button">
                                <span class="actual-text">&nbsp;Entregar&nbsp;</span>
                                <span aria-hidden="true" class="hover-text">&nbsp;Entregar&nbsp;</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Agregar un evento de cambio a todos los cuadros de selección "Seleccionar Todo"
        $('.select-all-checkbox').change(function () {
            // Obtener el servicio asociado al cuadro de selección
            var servicioId = $(this).data('servicio');

            // Obtener los cuadros de selección originales para ese servicio
            var originalCheckboxes = $('.original-checkbox.servicio-' + servicioId);

            // Marcar o desmarcar todos los cuadros de selección originales para ese servicio
            originalCheckboxes.prop('checked', $(this).prop('checked'));

            // Mostrar u ocultar el campo de entrada en función de si al menos un checkbox está marcado
            if (originalCheckboxes.filter(':checked').length > 0) {
                $('#campoInput').removeClass('hidden');
            } else {
                $('#campoInput').addClass('hidden');
            }
        });

        // Agregar un evento de cambio a los cuadros de selección originales
        $('.original-checkbox').change(function () {
            // Obtener el servicio asociado al cuadro de selección original
            var servicioId = $(this).data('procesos');

            // Obtener todos los cuadros de selección originales para ese servicio
            var originalCheckboxes = $('.original-checkbox.servicio-' + servicioId);

            // Mostrar u ocultar el campo de entrada en función de si al menos un checkbox está marcado
            if (originalCheckboxes.filter(':checked').length > 0) {
                $('#campoInput').removeClass('hidden');
            } else {
                $('#campoInput').addClass('hidden');
            }
        });
    });
</script>


@endsection