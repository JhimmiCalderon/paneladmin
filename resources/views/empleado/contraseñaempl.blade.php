@extends('layouts.empleado')
@section('title','Contraseña')

@section('content')
<meta name="csrf-token" content="{{ csrf_token()}}">
<main>
<div class="container">
@if (auth()->user()->cambio_contraseña == false)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Cambiar Contraseña:</strong> Por favor, cambie su contraseña para continuar utilizando la plataforma.
    <a href="{{ route('cambiocontraseñaempleado') }}" class="alert-link">Cambiar Contraseña</a>
</div>
@endif
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10 offset-lg-3 offset-md-2 offset-sm-1">
            <p class="login">Cambiar Contraseña</p>

            <label for="actualempleado">Contraseña actual</label>
            <div class="input-group mb-3">
                <input class="form-control" type="text" id="actualempleado">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('actualempleado')">Mostrar</button>
            </div>
            <input type="hidden" value="{{$empleado->id}}" id="idempleado">

            <label for="nuevaempleado">Nueva Contraseña</label>
            <div class="input-group mb-3">
                <input class="form-control" type="text" id="nuevaempleado">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('nuevaempleado')">Mostrar</button>
                
            </div>

            <label for="confirmarempleado">Confirmar Contraseña</label>
            <div class="input-group mb-3">
                <input class="form-control" type="text" id="confirmarempleado">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmarempleado')">Mostrar</button>
            </div>
            <button type="submit" class="btn btn-dark" id="btnempleado">Cambiar Contraseña</button>
        </div>
        
    </div>
</div>

   

    <script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = (input.type === 'password') ? 'text' : 'password';
    }
</script>
    <script>
        const btnempleado = document.getElementById('btnempleado');
        const actualempleado = document.getElementById('actualempleado');
        const nuevaempleado = document.getElementById('nuevaempleado');
        const confirmarempleado = document.getElementById('confirmarempleado');

        btnempleado.addEventListener('click', function(e) {
            e.preventDefault();

            const valoractualempleado = actualempleado.value;
            const valornuevaempleado = nuevaempleado.value;
            const valorconfirmarempleado = confirmarempleado.value;
            const idempleado = document.getElementById('idempleado').value;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/changepasswordempleado/${idempleado}`, {
                method: 'PUT',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    actualempleado: valoractualempleado,
                    nuevaempleado: valornuevaempleado,
                    confirmarempleado: valorconfirmarempleado,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.exito) {
                    alert(data.exito);
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.log('Error en la solicitud', error);
            });
        });
    </script>
</main>

@endsection