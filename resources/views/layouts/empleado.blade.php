<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

      <!--=============== CSS ===============-->
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">  
      <link rel="stylesheet" href="{{asset('css/empleado.css')}}">
      <title>@yield('title')|PH en linea</title>
   </head>
   <body>
      <!-- Sidebar bg -->
      <img src="assets/img/sidebar-bg.jpg" alt="sidebar img" class="bg-image">

      <!--=============== HEADER ===============-->
      <header class="header">
         <div class="header__container container">
            <div class="header__toggle" id="header-toggle">
               <i class="ri-menu-line"></i>
            </div>

            <a href="#" class="header__logo">
            <img src="{{ asset('img/ph.png') }}" id="cloud" alt="Imagen" width="60" height="50">
            </a>
         </div>
      </header>

      <!--=============== SIDEBAR ===============-->
      <div class="sidebar" id="sidebar">
         <nav class="sidebar__container">
            <div class="sidebar__logo">
            <img src="{{ asset('img/ph.png') }}" id="cloud" alt="Imagen" width="60" height="50">
            <span>PHenlinea</span>
            </div>

            <div class="sidebar__content">
               <div class="sidebar__list">
            
                  <a href="{{route('empleado.index')}}" class="sidebar__link">
                  <i class="ri-user-3-line"></i>
                     <span class="sidebar__link-name">Mis Pendientes</span>
                     <span class="sidebar__link-floating">Mis Pendientes</span>
                  </a>
                  

               
               </div>

              

               <h3 class="sidebar__title">
                  <span>General</span>
               </h3>

               <div class="sidebar__list">
                  <a href="#" class="sidebar__link">
                     <i class="ri-notification-2-line"></i>
                     <span class="sidebar__link-name">Notifications</span>
                     <span class="sidebar__link-floating">Notifications</span>
                  </a>

                  <a  href="{{route('cambiocontraseñaempleado')}}" class="sidebar__link">
                     <i class="ri-settings-3-line"></i>
                     <span class="sidebar__link-name">Configuracion</span>
                     <span class="sidebar__link-floating">Configuracion</span>
                  </a>

                  <a class="sidebar__link"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="ri-logout-box-r-line"></i>
                     <span class="sidebar__link-name">Salir</span>
                     <span class="sidebar__link-floating">Salir</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
               </div>
            </div>
<div class="sidebar__account">
    @if(Auth::user()->imagen)
        {{-- Asumiendo que el nombre de la imagen está almacenado en la columna 'imagen' --}}
        <img src="{{ asset('imagen/' . Auth::user()->imagen) }}" alt="sidebar image" class="sidebar__perfil" style="width: 50px; height: 50px;">
    @else
        {{-- En caso de que el usuario no tenga una imagen asignada --}}
        <img src="{{ asset('img/ph.png') }}" alt="sidebar image" class="sidebar__perfil" style="width: 50px; height: 50px;">
    @endif

               <div class="sidebar__names">
                  <h3 class="sidebar__name">{{ Auth::user()->name }}</h3>
                  <span class="sidebar__email">{{ Auth::user()->email }}</span>
                  <br>
                  
                  <span class="sidebar__email">{{ Auth::user()->proceso->proceso }}</span>
               </div>

             
            </div>
         </nav>
      </div>

      <!--=============== MAIN ===============-->
      <main class="main container" id="main">
         
       
                    @yield('content')           
      </main>
      
      <!--=============== MAIN JS ===============-->
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="{{asset('js/sidebar.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JavaScript (popper.js and bootstrap.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Tu script de cerrado automático -->

<script>
   
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);
</script>

<!-- Tu script de cerrado automático -->
<script>
   $(document).ready(function(e){
      $('#imagen').change(function(){
         let reader = new FileReader();
         reader.onload = (e) =>{
            $('#imagenSeleccionada').attr('src', e.target.result);
         }
         reader.readAsDataURL(this.files[0]);
      });
   });
</script>

   </body>
