@extends('layouts.admin')

@section('title','Procesos')

@section('content')


<main>
    @if (auth()->user()->cambio_contraseña == 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
        <a href="{{ route('cambiocontraseña') }}" class="alert-link">Cambiar Contraseña</a>
    </div>
    @endif

    @if($flash = Session::get('Correcto'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Correcto</strong> {{$flash}}
    </div>
    @elseif($flash = Session::get('editar'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Correcto</strong> {{$flash}}
    </div>
    @elseif($flash = Session::get('eliminar'))
    <div class="alert alert-warning alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Eliminado</strong> {{$flash}}
    </div>
    @endif

    <div class="modal fade" id="agregarEmpresaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-color: black">
                <div class="modal-header" style="background-color: white">
                    <h1 class="modal-title"><strong>Nuevo Servicio</strong></h1>
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

                    <form action="{{ route('servicios.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nombre">Servicio</label>
                                    <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Nombre del servicio">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="text" name="precio" class="form-control" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="contenido">Contenido</label>
                                    <textarea class="form-control" name="contenido" style="height: 30px"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <br>
                                    <h4 style="background-color: white; text-align: center;">Agregar procesos</h4>
                                    <br>
                                    <div class="checkbox-container" id="original-checkboxes">
                                        @foreach ($procesos as $proceso)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="id_procesos[]" value="{{ $proceso->id }}" class="original-checkbox">
                                            {{ $proceso->proceso }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-12">
                                <div>
                                    <br><br>
                                    <button type="submit" class="btn btn-dark">
                                        <ion-icon name="checkmark-outline"></ion-icon> Guardar
                                    </button>
                                    <a href="" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <div class="card-body">
            <div class="col-md-6 my-3">
                <button class="Btn" data-bs-toggle="modal" data-bs-target="#agregarEmpresaModal">

                    <div class="sign">+</div>

                    <div class="text">servicios</div>
                </button>

            </div>
            <h2 class="t">Mis servicios</h2>
            <br>
            <div class="table-responsive" style="height:300px;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th>Servicio</th>
                            <th>Precios</th>
                            <th>Procesos</th>
                            <th>Observacion</th>
                            <th class="text-center">Historial</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (auth()->check())

                        @if ($serviciospropios->isNotEmpty())
                        @foreach ($serviciospropios as $serviciopropio)
                        <tr>

                            <td>
                                <h6>{{ $serviciopropio->name }}</h6>
                            </td>
                            <td>${{ $serviciopropio->precio }}</td>
                            <td> @foreach ($serviciopropio->procesos as $persoproceso)
                                <h6>{{ $loop->iteration }}. {{ $persoproceso->proceso }} </h6>
                                @endforeach

                            </td>
                            <td>{{ $serviciopropio->contenido}}</td>
                            <td class="text-center">

                                <a href="{{ route('servicios.show', $serviciopropio->id) }}">
                                    <ion-icon name="eye"></ion-icon>
                                </a>


                            </td>
                            <td class="text-center">
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editar{{$serviciopropio->id}}">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                </a>
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#borrar{{$serviciopropio->id}}">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a>
                            </td>
                            <div class="modal fade" id="editar{{$serviciopropio->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border-color:black">
                                        <div class="modal-header" style="background-color: white">
                                            <h1 class="modal-title"><strong>Editar </strong></h1>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ route('servicios.update', $serviciopropio->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="nombre">Servicio</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $serviciopropio->name }}" >
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="precio">Precio</label>
                                                            <input type="text" name="precio" class="form-control" value="{{ $serviciopropio->precio }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="contenido">Contenido</label>
                                                            <textarea class="form-control" name="contenido" style="height: 100px">{{ $serviciopropio->contenido }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group text-center">
                                                            <br>
                                                            <h4 style="background-color: white; text-align: center;">Agregar procesos</h4>
                                                            <br>
                                                            <div class="checkbox-container" id="original-checkboxes">
                                                                @foreach ($procesos as $proceso)
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" name="id_procesos[]" value="{{ $proceso->id }}" class="original-checkbox">
                                                                    {{ $proceso->proceso }}
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <br>
                                                    <div class="col-12">
                                                        <div>
                                                            <br><br>
                                                            <button type="submit" class="btn btn-dark">
                                                                <ion-icon name="checkmark-outline"></ion-icon> Guardar
                                                            </button>
                                                            <a href="" class="btn btn-danger">Cancelar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
            <div class="modal fade" id="borrar{{$serviciopropio->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog mx-auto">
                    <div class="modal-content" style="border-color:black">
                        <div class="modal-header text-center" style="background-color: white">
                            <h1 class="modal-title"><strong>Eliminar</strong></h1>
                        </div>
                        <div class="modal-body text-center">
                            <div class="col-6 mx-auto">
                                <p>¿Está seguro que desea eliminar?</p>
                                <form action="{{ route('servicios.destroy',$serviciopropio->id) }}" method="POST" class="eliminar" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark">
                                        <ion-icon name="trash-outline"></ion-icon> Eliminar
                                    </button>
                                    <a href="" class="btn btn-danger">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </td>

            </tr>
            @endforeach

            @else
            <p>Sin Servicios registrados.</p>
            @endif
            @endif
            </tbody>

            </table>

            </body>

            </html>
</main>
@endsection