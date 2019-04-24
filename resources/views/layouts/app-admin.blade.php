<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/funciones.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
            <div id="wrapper" class="toggled">

                <!-- Sidebar -->
                @include('layouts.nav')

                <!-- /#sidebar-wrapper -->
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="row">
                        <div class="col-1 ">
                            <a href="#menu-toggle" id="menu-toggle" class="navbar-brand">
                                <i class="fas fa-bars fa-2x"></i>
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                        </div>
                        <div class="col-8">
                            <nav  aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="#">Editar</a>
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                      {{ __('Cerrar') }}
                                  </a>

                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                                </div>
                              </div>

                        </div>
                    </div>

                    @yield('content')
                </div> <!-- /#page-content-wrapper -->
            </div> <!-- /#wrapper -->
            <!-- Bootstrap core JavaScript -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script> <!-- Menu Toggle Script -->
            <script>
              $(function(){
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });

                $(window).resize(function(e) {
                  if($(window).width()<=768||$(window).width()<=1024){
                    $("#wrapper").removeClass("toggled");
                  }else{
                    $("#wrapper").addClass("toggled");
                  }
                });
              });

            </script>




</body>

</html>
