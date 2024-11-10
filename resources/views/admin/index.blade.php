@extends('layouts.admin')

@section('title', 'Empleado')

@section('content')
<style>
    .form-control.capitalize {
        text-transform: capitalize;
    }
</style>
<main>
    @if (auth()->user()->cambio_contraseña == false)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
        <a href="{{ route('cambiocontraseña') }}" class="alert-link">Cambiar Contraseña</a>
    </div>
    @endif


    @if ($flash = Session::get('Correcto'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Correcto</strong> {{ $flash }}
    </div>
    @elseif ($flash = Session::get('editar'))
    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Correcto</strong> {{ $flash }}
    </div>
    @elseif ($flash = Session::get('eliminar'))
    <div class="alert alert-warning alert-dismissible fade show auto-dismiss" role="alert">
        <strong>Eliminado</strong> {{ $flash }}
    </div>
    @endif

<a href="{{ route('pruebawhatsapp')}}">ir</a>
    <div class="modal fade" id="agregarEmpresaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-color: black">
                <div class="modal-header" style="background-color: white">
                    <h1 class="modal-title"><strong>Agregar Empleado </strong></h1>
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

                    {!! Form::open(array('route' => 'admin.store', 'method' => 'POST', 'files' => true)) !!}

                    @csrf
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-11 mx-3 d-flex justify-content-center align-items-center">
                                <img id="imagenSeleccionada" style="max-height: 150px;" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                {!! Form::text('name',null, array('class'=>'form-control capitalize', 'autocomplete' => 'off')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Apellido</label>
                                {!! Form::text('lastname',null, array('class'=>'form-control capitalize', 'autocomplete' => 'off')) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                {!! Form::text('email',null, array('class'=>'form-control', 'autocomplete' => 'off')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                {!! Form::password('password', array('class'=>'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="puesto_id">Puesto</label>
                                {!! Form::select('puesto', $puestos, null, array('class' => 'form-control')) !!}
                            </div>
                        </div>


                        <div class="col-md-6" id="estadoField" style="display: none;">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                {!! Form::select('estado', [ 'inactivo' => 'Inactivo'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-uppercase mb-2">Subir imagen</label>
                                <div class="d-flex align-items-center justify-content-center w-100 border p-3 rounded hover:bg-purple-600">
                                    <label class="d-flex flex-column border-4 border-dashed w-100 h-32 text-center position-relative">
                                        <div class="d-flex flex-column align-items-center justify-content-center pt-2">
                                            <ion-icon name="image-outline" class="display-4 text-muted"></ion-icon>
                                            <p class="text-sm text-gray-400">Seleccione la imagen</p>
                                        </div>
                                        <input name="imagen" id="imagen" type="file" class="visually-hidden position-absolute top-0 start-0 end-0 bottom-0 w-100 h-100">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-dark"><ion-icon name="layers-outline"></ion-icon> Guardar</button>
                            <a href="" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>




    <br>
    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 my-3">
                    <button class="Btn" data-bs-toggle="modal" data-bs-target="#agregarEmpresaModal">

                        <div class="sign">+</div>

                        <div class="text">Empleados</div>
                    </button>

                </div>

                <div class="col-md-6"><br>
                    <!-- Search Form -->
                    <form class="mb-3 mb-md-0" action="{{ route('admin.index') }}" method="get">
                        <div class="input-group">
                            <input type="text" name="text" class="form-control" placeholder="Buscar" value="{{ $text }}">
                            <button type="submit" class="btn btn-dark">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <h2 class="t">Empleados</h2>
            <div class="table-responsive" style="height:300px;">
                <table class="table table-bordered table-striped">
                    <br>
                    <thead>
                        <tr>
                            <th class="text-center">Imagen</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>E-mail</th>
                            <th>Cargo</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Historial</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (auth()->check())
                        @if ($empleados->isNotEmpty())
                        @if (count($empleados) > 0)
                        @foreach ($empleados as $empleado)
                        <tr>
                            <td style="display: none;">{{ $empleado->id }}</td>
                            <td class="text-center">
                                <img src="/imagen/{{ $empleado->imagen }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;" class="img-thumbnail" alt="Imagen de empleado">
                            </td>
                            <td>{{ $empleado->name }}</td>
                            <td>{{ $empleado->lastname }}</td>
                            <td>{{ $empleado->email }}</td>
                            <td>{{ $empleado->proceso->proceso}}</td>



                            <td class="text-center">
                                <form action="{{ route('admin.cambiarEstado', $empleado->id) }}" method="POST">
                                    @csrf
                                    <label class="switch">
                                        <input type="checkbox" id="switchActivo" name="activo" onchange="this.form.submit()" {{ $empleado->estado == 'activo' ? 'checked' : '' }}>>
                                        <div class="slider"></div>
                                        <div class="slider-card">
                                            <div class="slider-card-face slider-card-front"></div>
                                            <div class="slider-card-face slider-card-back"></div>

                                        </div>

                                    </label><br>
                                    {{ $empleado->estado }}

                                </form>
                            </td>
                            <td class="text-center">

                                <a href="{{ route('admin.show', $empleado->id) }}"><ion-icon name="eye"></ion-icon></a>


                            </td>

                            <td class="text-center">
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editar{{ $empleado->id }}">
                                    <ion-icon name="pencil-outline"></ion-icon>
                                </a>
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#borrar{{ $empleado->id }}">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="editar{{$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-color:black">
                                    <div class="modal-header" style="background-color: white">
                                        <h1 class="modal-title"><strong>Editar Empleados </strong></h1>
                                    </div>

                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('admin.update', $empleado->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="container mt-2">
                                                <div class="row">
                                                    <div class="col-11 mx-3 d-flex justify-content-center align-items-center">
                                                        <img id="imagenSeleccionada" style="max-height: 150px;" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $empleado->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Apellido</label>
                                                        <input type="text" name="lastname" class="form-control" value="{{ $empleado->lastname }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">E-mail</label>
                                                        <input type="text" name="email" class="form-control" value="{{ $empleado->email }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="puesto">Puesto</label>
                                                        <select name="puesto" class="form-control">
                                                            @foreach($puestos as $puestoId => $puestoNombre)
                                                            <option value="{{ $puestoId }}" {{ ($empleado->puesto == $puestoId) ? 'selected' : '' }}>
                                                                {{ $puestoNombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-uppercase mb-2">Subir imagen</label>
                                                        <div class="d-flex align-items-center justify-content-center w-100 border p-3 rounded hover:bg-purple-600">
                                                            <label class="d-flex flex-column border-4 border-dashed w-100 h-32 text-center position-relative">
                                                                <div class="d-flex flex-column align-items-center justify-content-center pt-2">
                                                                    <ion-icon name="image-outline" class="display-4 text-muted"></ion-icon>
                                                                    <p class="text-sm text-gray-400">Seleccione la imagen</p>
                                                                </div>
                                                                <input name="imagen" id="imagen" type="file" class="visually-hidden position-absolute top-0 start-0 end-0 bottom-0 w-100 h-100">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-dark"><ion-icon name="layers-outline"></ion-icon> Guardar</button>
                                                    <a href="{{ route('admin.index') }}" class="btn btn-danger">Cancelar</a>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="borrar{{$empleado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog  mx-auto">
                                <div class="modal-content" style="border-color:black">
                                    <div class="modal-header" style="background-color: white">
                                        <h1 class="modal-title"><strong>Eliminar</strong></h1>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="col-6 mx-auto">
                                            <p>¿Está seguro que desea eliminar?</p>
                                            <form action="{{ route('admin.destroy', $empleado->id) }}" method="POST" class="eliminar" style="display: inline;">
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

                        @endforeach

                        @else
                        <tr>
                            <td colspan="5">No hay resultados</td>
                        </tr>
                        @endif
                        @else
                        <p class="login">Sin Empleados Registrados.</p>
                        @endif
                        @endif

                    </tbody>
                </table>
                {{ $empleados->links() }}
            </div>
        </div>
    </div>

</main>
@endsection