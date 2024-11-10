@extends('layouts.inicio')

@section('title','Login')

@section('content')

<main>

    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">

                    <!-------------      image     ------------->

                    <img src="img/.jpg" alt="">
                    <div class="text">
                        <p>Join the community of developers <i>- Phenlinea</i></p>
                    </div>

                </div>
                <div class="col-md-6 right">

                    <div class="input-box">

                        <header class="login">Log in</header>
                        @if($flash = Session::get('error'))
                        <div class="alert alert-danger alert-simissible fade show auto-dismiss" role="alert">
                            <strong>Error</strong> {{$flash}}
                        </div>
                        @endif
                        <form  action="{{ route('login') }}" method="POST">
                            @csrf
                            <div  class="inputBox">
                                <input type="text" class="input" id="email" name="email" required="required" >
                                <span class="user">Email</span>
                            </div>
                            <br>
                            <div  class="inputBox">
                                <input type="password" class="input" id="password" name="password" required="required">
                                <span class="user">Password</span>
                            </div>
                            <div class="input-field"><br>

                                <input type="submit" class="enter" value="Sign Up">
                            </div>
                            <div class="signin">
                                <span>Already have an account? <a href="#">Log in here</a></span>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




</main>
@endsection
