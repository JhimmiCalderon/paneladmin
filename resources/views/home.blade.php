<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio Web</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Encabezado (Header) -->
    <div class="container-fluid mt-4 mb-4">
        <section>
            
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                        <img src="{{asset('img/ph.png')}}" alt="" style="width: 60px;">
                            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="navegacio" aria-current="page" href="">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="navegacio" aria-current="page" href="#somos">Quienes Somos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="navegacio" aria-current="page" href="#servicio">Servicios</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="navegacio" aria-current="page" href="#contacto">Contacto</a>
                                    </li>

                                </ul>
                                <a href="{{ route('login') }}" class="hola">Iniciar Sesión</a>
                            </div>
                </div>
            </nav>
            </section>
            <section>
                <div id="slider-carousel" class="carousel slide " data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="img-fluid d-block" src="{{ asset('img/1.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid d-block" src="{{ asset('img/2.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid d-block" src="{{ asset('img/3.jpg') }}" alt="">
                        </div>
                    </div>
                    <button class="carousel-control-prev" data-bs-target="#slider-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" data-bs-target="#slider-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
         
            </section>     
               <!-- Sección de Quienes somos) -->
        <section id="somos" class="about">
            <div class="main">
                <img src="" alt="">
                <div class="about-text ">
                    <h2>
                        Quienes Somos
                    </h2>
                    <h6>administración<span> & software </span></h6>
                    <p>Entidades que requieran una estructura administrativa con economía auto sostenible por una cuota de administración,
                        generada dentro de la misma entidad sin ánimo de lucro.
                        Queremos proyectarnos a ser la primera red de copropiedades que ofrezca todos los mejores servicios informáticos para cada uno de sus integrantes; incluidos en estos cada uno de los individuos que componen la copropiedad.
                        por esto estamos en constate seguimiento e investigación de nuevos procesos administrativos y operativos que pueden ser integrados en nuestras soluciones de software.
                        Lo invitamos a escribirnos con sugerencias que ayuden a crecer nuestros productos de tal manera que haya una retroalimentación y requerimientos y soluciones a estos.</p>
                </div>
            </div>
        </section>

        <!-- Sección de "Servicios" -->
        <section>
            <div class="service" id="servicio">
                <div class="title">
                    <h2>Nuestros Servicios</h2>
                </div>
                <div class="box">
                    <div class="card text-white bg-dark mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                        <h6>PHENLINEA PLUS</h6>
                        <div class="pra">
                            <p>Cuenta de cobro disponible en sitio web para el propietario, Recibo de caja, Estado de cuenta, certificado</p>
                            <p style="text-align: center;">
                                <a class="button" href="">Leer Mas</a>
                            </p>
                        </div>
                    </div>

                    <div class="card text-white bg-dark mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z" />
                        </svg>
                        <h6>PAGOS EN LÍNEA PSE</h6>
                        <div class="pra">
                            <p>Cuenta de cobro disponible en sitio web para el propietario, Recibo de caja, Estado de cuenta, certificado</p>
                            <p style="text-align: center;">
                                <a class="button" href="">Leer Mas</a>
                            </p>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z" />
                        </svg>
                        <h6>MENSAJES SMS</h6>
                        <div class="pra">
                            <p>Cuenta de cobro disponible en sitio web para el propietario, Recibo de caja, Estado de cuenta, certificado</p>
                            <p style="text-align: center;">
                                <a class="button" href="">Leer Mas</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="ctm" id="contacto">
            <div class="contact-me">
                <h1 class="font-weight-bold">Únete a nosotros<span> hoy mismo</span></h1>
                <h2>Descubre cómo podemos ayudarte a lograr tus objetivos.</h2>
                <div class="newslatter">
                    <form>
                        <input type="email" name="email" id="email" placeholder="Ingrese Su correo">
                        <input type="submit" name="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </section>
        <!-- Pie de Página (Footer) -->
        <footer>

            <p>Contacto</h3>
            <p>Correo: info@misitioweb.com</p>
            <p>Teléfono: +123 456 789</p>
            <div class="social">
                <a href="https://m.facebook.com/p/PH-en-l%C3%ADnea-100044558785975/"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                    </svg></a>
                <a href=""><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M224,202.66A53.34,53.34,0,1,0,277.36,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54,54,0,0,0-30.41-30.41c-21-8.29-71-6.43-94.3-6.43s-73.25-1.93-94.31,6.43a54,54,0,0,0-30.41,30.41c-8.28,21-6.43,71.05-6.43,94.33S91,329.26,99.32,350.33a54,54,0,0,0,30.41,30.41c21,8.29,71,6.43,94.31,6.43s73.24,1.93,94.3-6.43a54,54,0,0,0,30.41-30.41c8.35-21,6.43-71.05,6.43-94.33S357.1,182.74,348.75,161.67ZM224,338a82,82,0,1,1,82-82A81.9,81.9,0,0,1,224,338Zm85.38-148.3a19.14,19.14,0,1,1,19.13-19.14A19.1,19.1,0,0,1,309.42,189.74ZM400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM382.88,322c-1.29,25.63-7.14,48.34-25.85,67s-41.4,24.63-67,25.85c-26.41,1.49-105.59,1.49-132,0-25.63-1.29-48.26-7.15-67-25.85s-24.63-41.42-25.85-67c-1.49-26.42-1.49-105.61,0-132,1.29-25.63,7.07-48.34,25.85-67s41.47-24.56,67-25.78c26.41-1.49,105.59-1.49,132,0,25.63,1.29,48.33,7.15,67,25.85s24.63,41.42,25.85,67.05C384.37,216.44,384.37,295.56,382.88,322Z" />
                    </svg></a>
                <a href=""><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z" />
                    </svg></a>

            </div>
        </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>