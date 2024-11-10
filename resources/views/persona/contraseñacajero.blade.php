@extends('layouts.cajero')

@section('title','Usuarios')

@section('content')
<style>
    body{
    background: white;
   } 
   .c {
    margin: 200px auto;
   }
</style>
<meta name="csrf-token" content="{{ csrf_token()}}">
<main>
    <div class="c">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10 offset-lg-3 offset-md-2 offset-sm-1">
            <p class="login" >Cambio Contraseña</p>

            <label for="actualcajero">Contraseña actual</label>
            
            <div class="input-group in mb-3">
                <input class="form-control" type="password" id="actualcajero">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('actualcajero')">Mostrar</button>
            </div>
            <input type="hidden" value="{{$cajero->id}}" id="idcajero">

            <label for="nuevacajero">Nueva Contraseña</label>
            <div class="input-group mb-3">
                <input class="form-control" type="password" id="nuevacajero">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('nuevacajero')">Mostrar</button>
            </div>

            <label for="confirmarcajero">Confirmar Contraseña</label>
            <div class="input-group mb-3">
                <input class="form-control" type="password" id="confirmarcajero">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmarcajero')">Mostrar</button>
            </div>
            <button type="submit" class="btn btn-dark" id="btncajero">Cambiar Contraseña</button>
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
        const btncajero = document.getElementById('btncajero');
        const actualcajero = document.getElementById('actualcajero');
        const nuevacajero = document.getElementById('nuevacajero');
        const confirmarcajero = document.getElementById('confirmarcajero');

        btncajero.addEventListener('click', function(e) {
            e.preventDefault();

            const valoractualcajero = actualcajero.value;
            const valornuevacajero = nuevacajero.value;
            const valorconfirmarcajero = confirmarcajero.value;
            const idcajero = document.getElementById('idcajero').value;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/changepasswordcajero/${idcajero}`, {
                method: 'PUT',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    actualcajero: valoractualcajero,
                    nuevacajero: valornuevacajero,
                    confirmarcajero: valorconfirmarcajero,
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