<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')|PH en linea</title>
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Barra lateral -->
                <div class="menu">
                    <ion-icon name="menu-outline"></ion-icon>
                    <ion-icon name="close-outline"></ion-icon>
                </div>

                <div class="barra-lateral">
                    <div>
                        <div class="nombre-pagina">
                            <img src="{{ asset('img/ph.png') }}" id="cloud" alt="Imagen" width="60" height="50">
                            <span>PHenlinea</span>
                        </div>
                    </div>

                    <nav class="navegacion">
                        <ul>
                        <li>
                              
                            </li>
                           
                            <li>
                                <a id="inbox" href="{{route('superadmin.index')}}">
                                    <ion-icon name="people-outline"></ion-icon>
                                    <span>Clientes</span>
                                </a>
                            </li>

                            <BR></BR>
                            <div>
                                <li>

                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <ion-icon name="power-outline"></ion-icon>
                                        <span>Cerrar</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </div>
                        </ul>
                    </nav>

                    <div>
                        <div class="linea"></div>

                        <div class="modo-oscuro">
                            <div class="info">
                                <ion-icon name="moon-outline"></ion-icon>
                                <div class="switch">
                                    <div class="base">
                                        <div class="circulo"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="usuario">
                            <img src="/Jhampier.jpg" alt="">
                            <div class="info-usuario">
                                <div class="nombre-email">
                                    <span class="nombre">{{ Auth::user()->name }}</span>
                                    <span class="email">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!-- Contenido principal de la página -->
                <main>
                    <div class="p-3  bg-dark text-white">
                        <h2 class="text-center">Bienvenido {{ Auth::user()->name }}</h2>
                    </div>

                    @yield('content')
                </main>
            </div>
        </div>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="{{asset('js/sidebar.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('eliminar') == 'ok')
    <script>
        Swal.fire(
            '¡Eliminado!',
            'Su archivo ha sido eliminado.',
            'success'

        )
    </script>
    @endif

    <script>
        $('.eliminar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    /*Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )*/
                    this.submit();
                }
            })
        });
    </script>

</body>


</html>