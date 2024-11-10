@extends('layouts.empleado')

@section('title', 'Empleados')


@section('content')
<main >
@if (auth()->user()->cambio_contraseña == false)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
    <a href="{{ route('cambiocontraseñaempleado') }}" class="alert-link">Cambiar Contraseña</a>
</div>
@endif
    <div class="card">
        <div class="card-body">
            <ul class="list-group">
                @if ($historialPersona->isNotEmpty())
                @php
                $currentDate = null;
                @endphp

                @foreach ($historialPersona as $historial)
                @php
                $fecha = \Carbon\Carbon::parse($historial->created_at)->format('Y-m-d');
                @endphp

                @if ($fecha != $currentDate)
                @if ($currentDate !== null)
            </ul> <!-- Cerrar la lista anterior -->
            @endif

            <h3>{{ $fecha }}</h3>
            <ul class="list-group">
                @endif

                <li class="list-group-item">
                    {{ \Carbon\Carbon::parse($historial->created_at)->format('H:i') }}
                    - {{ $historial->accion }}
                </li>

                @php
                $currentDate = $fecha;
                @endphp
                @endforeach

            </ul> <!-- Cerrar la última lista -->
            @else
            <li class="list-group-item">
                <p class="mb-0">No hay historial disponible.</p>
            </li>
            @endif
            </ul>
        </div>
    </div>
</main>


@endsection|