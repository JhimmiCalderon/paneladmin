@extends('layouts.nuevo')

@section('title','Empresas')


@section('content')
<style>
    .form-control.capitalize {
        text-transform: capitalize;
    }
</style>
<main>
    <h1 class="login">PHenlinea</h1>


    <div class="modal fade" id="agregarEmpresaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-color:black">
                <div class="modal-header" style="background-color: white">
                    <h1 class="modal-title"><strong>Agregar Empresa </strong></h1>
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

                    {!! Form::open(['id' => 'registroForm', 'route' => 'superadmin.store', 'method' => 'POST', 'files' => true]) !!}
                    @csrf

                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-11 mx-3 d-flex justify-content-center align-items-center">
                                <img id="imagenSeleccionada" style="max-height: 150px; width: auto; border-radius: 50%;" alt="">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Empresa</label>
                                {!! Form::text('name', null, array('class'=>'form-control capitalize','autocomplete' => 'off')) !!}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                {!! Form::text('email', null, array('class'=>'form-control', 'autocomplete' => 'off')) !!}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="direccion">Direccion</label>
                                {!! Form::text('direccion',null,array('class'=>'form-control','autocomplete'=>'off'))!!}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nit">Nit</label>
                                {!! Form::text('nit',null,array('class'=>'form-control','autocomplete'=>'off'))!!}
                            </div>
                        </div>
                        <div class="col-6" id="estadoField" style="display: none;">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                {!! Form::select('estado', [ 'inactivo' => 'Inactivo'], null, ['class' => 'form-control'])!!}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group" style="display: none;">
                                <label for="password">Password</label>
                                {!! Form::password('password', array('class'=>'form-control')) !!}
                            </div>
                        </div>
                        <div class="container mt-5">
                            <div class="row mx-3">
                                <div class="col-11">
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
                        </div>
                        <div class="col-6">
                            <br>
                            <button id="submitBtn" type="submit" class="btn btn-dark">
                                Registrar
                            </button>
                            <a href="" class="btn btn-danger">Cancelar</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="card">

        <div class="card-body">
            <!-- "Agregar Empresa" Button -->
            <div class="row">
                <div class="col-md-6 my-3">
                    <button class="Btn" data-bs-toggle="modal" data-bs-target="#agregarEmpresaModal">

                        <div class="sign">+</div>

                        <div class="text">Agregar</div>
                    </button>

                </div>

                <div class="col-md-6"><br>
                    <!-- Search Form -->
                    <form class="mb-3 mb-md-0" action="{{ route('superadmin.index') }}" method="get">
                        <div class="input-group">
                            <input type="text" name="text" class="form-control" placeholder="Buscar" value="{{ $text }}">
                            <button type="submit" class="btn btn-dark">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <br>
            <h2 class="t">Empresas</h2>
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
            <div class="table-responsive" style="height:300px;">

                <table class="table table-bordered table-striped">

                    <br>
                    <thead>
                        <tr>
                            <th class="text-center">Imagen</th>
                            <th>Nombre</th>
                            <th>Nit</th>
                            <th>Direccion</th>
                            <th>E-mail</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($usuarios) > 0)
                        @foreach ($usuarios as $usuario)
                        <tr>
                            <td style="display: none;">{{ $usuario->id }}</td>
                            <td class="text-center">
                                <img src="/imagen/{{ $usuario->imagen }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;" class="img-thumbnail" alt="Imagen de empleado">
                            </td>

                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->nit }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->email }}</td>


                            <td class="text-center">
                                <form action="{{ route('superadmin.cambiarEstado', $usuario->id) }}" method="POST">
                                    @csrf
                                    <label class="switch">
                                        <input type="checkbox" id="switchActivo" name="activo" onchange="this.form.submit()" {{ $usuario->estado == 'activo' ? 'checked' : '' }}>>
                                        <div class="slider"></div>
                                        <div class="slider-card">
                                            <div class="slider-card-face slider-card-front"></div>
                                            <div class="slider-card-face slider-card-back"></div>

                                        </div>

                                    </label><br>
                                    {{ $usuario->estado }}

                                </form>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editar{{$usuario->id}}"><ion-icon name="pencil-outline"></ion-icon></a>
                                <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#borrar{{$usuario->id}}"> <ion-icon name="trash-outline"></ion-icon></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="editar{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-color:black">
                                    <div class="modal-header" style="background-color: white">
                                        <h1 class="modal-title"><strong>Editar Empresa</strong></h1>
                                    </div>
                                    {!! Form::model($usuario,['method'=>'PUT','route'=>['superadmin.update',$usuario->id],'files'=>true])!!}
                                    @csrf
                                 
                                    <div class="modal-body">
                                        <div class="container mt-2">
                                            <div class="row">
                                                <div class="col-11 mx-3 d-flex justify-content-center align-items-center">
                                                    <img id="imagenSeleccionada" style="max-height: 150px; width: auto; border-radius: 50%;" alt="">
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="name">Empresa</label>
                                                        {!! Form::text('name', null, array('class'=>'form-control capitalize','autocomplete' => 'off')) !!}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="nit">Nit</label>
                                                        {!! Form::text('nit', null, array('class'=>'form-control capitalize','autocomplete' => 'off')) !!}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="direccion">Direccion</label>
                                                        {!! Form::text('direccion', null, array('class'=>'form-control capitalize','autocomplete' => 'off')) !!}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email">E-mail</label>
                                                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="password">Contraseña</label>
                                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Confirmar Contraseña</label>
                                                        {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="container mt-5">
                                                    <div class="row mx-3">
                                                        <div class="col-11">
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
                                                </div>
                                                <div class="col-6">
                                                    <br>
                                                    <button id="submitBtn" type="submit" class="btn btn-dark">Guardar</button>
                                                    <a href="{{ route('superadmin.index') }}" class="btn btn-danger">Cancelar</a>
                                                </div>
                                            </div>
                                            {!!Form::close()!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="modal fade" id="borrar{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog mx-auto">
                                    <div class="modal-content" style="border-color:black">
                                        <div class="modal-header text-center" style="background-color: white">
                                            <h1 class="modal-title"><strong>¿Está seguro que desea eliminar?</strong></h1>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="col-6 mx-auto">
                                                <p>
                                                    *Se eliminara todo lo relacionado con esta Empresa.
                                                </p>
                                                <form action="{{ route('superadmin.destroy', $usuario->id) }}" method="POST" class="eliminar" style="display: inline;">
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
                                <td colspan="7">No hay resultados</td>
                            </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>





</main>
@endsection