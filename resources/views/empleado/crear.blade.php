@extends('layouts.app')

@section('title','Servicio')

@section('content')
<main>
<h3 class="text-center">Crear usuario</h3>
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

    {!! Form::open(array('route'=>'empleado.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nombre</label>
                {!! Form::text('name',null, array('class'=>'form-control')) !!}
            </div>
   
        <div class="col-12">
            <div class="form-group">
                <label for="name">numero celular</label>
                {!! Form::text('numero_celular',null, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="email">E-mail</label>
                {!! Form::text('email',null, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="password">Password</label>
                {!! Form::password('password', array('class'=>'form-control')) !!}
            </div>
        </div>
        
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="">Rol</label>
                {!! Form::select('roles[]',$roles, [], array('class'=>'form-control')) !!}
            </div>
        </div>
    </div>
    <br>
    <div class="col-12">
    <button type="submit" class="btn btn-dark"><ion-icon name="checkmark-circle-outline"></ion-icon> Guardar</button>
    </div>
    {!! Form::close() !!}
    </main>
    @endsection