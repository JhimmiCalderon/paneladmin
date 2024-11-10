@extends('layouts.admin')

@section('title', 'Empleado¿')

@section('content')
<style>
    body {
        background: white;
        
    }
    .login {
    color: #000;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    font-weight: bold;
    font-size: x-large;
    display: flex;
  justify-content: center;
  align-items: center;
  margin: 0; /
  }
</style>
<meta name="csrf-token" content="{{ csrf_token()}}">
<main>
    <div class="card">
        <div class="card-body">
        <div class="col-md-10 ">
        <p class="login">Cambiar Contraseña</p>
        <div class="table-responsive"  style="height:300px;">
     
                   
                        <label for="actual">Contraseña actual</label>
                        <div class="input-group mb-6">
                            <input class="form-control" type="password" id="actual">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('actual')">Mostrar</button>
                            </div>
                        </div>

                        <input type="hidden" value="{{$admin->id}}" id="idadmin">

                        <label for="nueva">Nueva Contraseña</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="password" id="nueva">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('nueva')">Mostrar</button>
                            </div>
                        </div>

                        <label for="confirmar">Confirmar Contraseña</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="password" id="confirmar">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmar')">Mostrar</button>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-dark" id="btn">Cambiar Contraseña</button>
                    </div>
                </div>
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
                const btn = document.getElementById('btn');
                const actual = document.getElementById('actual');
                const nueva = document.getElementById('nueva');
                const confirmar = document.getElementById('confirmar');


                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const valoractual = actual.value;
                    const valornueva = nueva.value;
                    const valorconfirmar = confirmar.value;
                    const idadmin = document.getElementById('idadmin').value;
                    const token = document.querySelector('meta[name="csrf-token"]').content;



                    fetch(`/changepassword/${idadmin}`, {
                            method: 'PUT',
                            headers: {
                                'Content-type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: JSON.stringify({
                                actual: valoractual,
                                nueva: valornueva,
                                confirmar: valorconfirmar,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.exito) {
                                alert(data.exito)
                            } else if (data.error) {
                                alert(data.error)
                            }
                        })
                        .catch(error => {
                            console.log('Error en la solicitud', error);
                        });




                });
            </script>
</main>
@endsection