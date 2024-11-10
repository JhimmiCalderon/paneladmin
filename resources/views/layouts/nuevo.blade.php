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
      <link rel="stylesheet" href="{{asset('css/main.css')}}">
      <title>@yield('title')|PHenlinea</title>
   </head>
   <body>
      <!-- Sidebar bg -->
      <img src="assets/img/sidebar-bg.jpg" alt="sidebar img" class="bg-image">

      <!--=============== HEADER ===============-->
      <header class="header">
      <div class="header__container container d-flex justify-content-between align-items-center">
         <a href="{{route('persona.index')}}" class="header__logo">
            <img src="{{ asset('img/ph.png') }}" id="cloud" alt="Imagen" width="60" height="50">
         </a>
         <a class="sidebar__link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="ri-logout-box-r-line"></i>
            <span class="sidebar__link-name"></span>
            <span class="sidebar__link-floating"></span>
         </a>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
         </form>


         <div class="ml-auto" style="margin-left: auto; display: flex; align-items: center;">
         
            <div id="casillita" style="display: none; margin-right: 10px;">
               <div class="sidebar__names">
                  
                  <h3 class="sidebar__name">{{ Auth::user()->name }}</h3>
                  <span class="sidebar__email">{{ Auth::user()->email }}</span>
               </div>
               
            </div>

            <a href="#" id="desplegarBoton">
               <i class="ri-arrow-right-s-line"></i>
            </a>
         
            </div>
    
      
      </div>
      

         </div>



      


      </header>

      <!--=============== SIDEBAR ===============-->


           

      <!--=============== MAIN ===============-->
      <main class="main container" id="main">
         
         

                    @yield('content')           
      </main>
      
      <!--=============== MAIN JS ===============-->
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="{{asset('js/sidebar.js')}}"></script>
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
<script>
      document.getElementById('desplegarBoton').addEventListener('click', function() {
         var casillita = document.getElementById('casillita');
         casillita.style.display = (casillita.style.display === 'none' || casillita.style.display === '') ? 'block' : 'none';
      });
   </script>

<script>
    $(document).ready(function() {
        // Escucha el evento de envío del formulario
        $('form').submit(function() {
            // Obtiene el valor del campo y lo convierte a mayúscula inicial
            var inputValue = $('input[name="name"]').val();
            var capitalizedValue = inputValue.charAt(0).toUpperCase() + inputValue.slice(1);

            // Actualiza el valor del campo con la versión en mayúscula inicial
            $('input[name="name"]').val(capitalizedValue);
        });
    });
</script>

   </body>
</html>