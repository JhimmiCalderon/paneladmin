@extends('layouts.empleado')

@section('title','Usuarios')

@section('content')

<main>
    <h3 class="text-center"> Editar usuario</h3>
    @if ($errors->any())
    <div class="alert alert-dark alert-dismissible fade show" role="alert">
        <strong>!Revise los campos!</strong>
        @foreach ($errors->all() as $error)
        <span class="badge badge-danger">{{$error}}</span>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {!! Form::model($persona,['method'=> 'PUT','route' =>['empleado.update',$persona->id]]) !!}
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="name">Nombres</label>
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="name">Apellidos</label>
                {!! Form::text('lastname', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="name">numero celular</label>
                {!! Form::text('numero_celular', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="email">E-mail</label>
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="password">observacion</label>
                {!! Form::textarea('observacion', null, array('class' => 'form-control small-textarea', 'style' => 'resize: vertical; height: 50px;')) !!}



            </div>
        </div>
        <br>
        <div class="col-12">
            <div class="form-group">
                <br>
                <h4 style="background-color: white;  text-align: center;">Servicios</h4>
                <div class="checkbox-container">
                    @foreach ($procesos as $proceso)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('procesos[]', $proceso->proceso, false) !!}
                        {{ $proceso->proceso }}
                    </label>
                    @endforeach
                    <div class="col-12">
<br>
                        <button type="submit" class="btn btn-dark"><ion-icon name="checkmark-circle-outline"></ion-icon>
                            Guardar</button>
                        <a href="{{ route('empleado.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>

</main>
@endsection