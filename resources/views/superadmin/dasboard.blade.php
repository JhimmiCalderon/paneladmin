@extends('layouts.nuevo')

@section('title','Empleado')


@section('content')
<main>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-xl-4">

                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h5>Usuarios</h5>
                                    @php
                                    use App\Models\Empleado;
                                    $cant_usuarios = Empleado::count();
                                    @endphp
                                    <h2 class="text-right"><i class=""></i><span>{{$cant_usuarios}}</span></h2>
                                    <p class="m-b-0 text-right"><a href="/admin" class="text-white">Ver más</a></p>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h5>Procesos</h5>
                                    @php
                                    use App\Models\Proceso;
                                    $cant_procesos = Proceso::count();
                                    @endphp
                                    <h2 class="text-right"><i class=""></i><span>{{$cant_procesos}}</span></h2>
                                    <p class="m-b-0 text-right"><a href="/procesos" class="text-white">Ver más</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </main>
    <style>
      .order-card {
            color: #f5f5f5;
        }

        .bg-c-blue {
            background: linear-gradient(45deg,#808080, #808080);
        }

        .bg-c-green {
            background: linear-gradient(45deg, #808080, #808080);
        }

        .bg-c-pink {
            background: linear-gradient(45deg,#808080, #808080);
        }

        .card {
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 25px;
        }

        .order-card i {
            font-size: 26px;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }
    </style>

    @endsection
