@extends('layouts.cajero')

@section('title', 'Servicios')

@section('content')
<style>
        body{
    background: white;
   } 
 
</style>

<body class="d-flex align-items-center justify-content-center min-vh-100">

    <main class="card border-0">
        <div class="card-body">
            <h1 class="mt-4 mb-4 text-center">Personas con Relaciones Completas</h1>

            <div class="list-group">
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
            </div>
        </div>
    </main>
@endsection