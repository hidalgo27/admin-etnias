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
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div id="wrapper" class="toggled">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="nav nav-pills flex-column pl-1">
                    <li class="nav-item item-menu">
                      <a class="nav-link item-titulo" data-toggle="collapse" href="#item-1">
                            <i class="fas fa-database"></i> BASE DE DATOS</a></li>
                      <div id="item-1" class="collapse">
                        <ul class="nav flex-column ml-3">
                          <li class="nav-item item-menu">
                            <a class="nav-link item-titulo active" href="{{ route('comunidad_lista_path') }}">COMUNIDADES</a>
                          </li>
                          <li class="nav-item item-menu">
                            <a class="nav-link item-titulo" href="{{ route('asociacion.lista') }}">ASOCIACION</a>
                          </li>
                          <li class="nav-item item-menu">
                            <a class="nav-link item-titulo" href="{{ route('servicios.nuevo') }}">SERVIVIOS</a>
                          </li>
                          <li class="nav-item item-menu">
                            <a class="nav-link item-titulo" href="#">SERVIVIOS</a>
                          </li>
                          <li class="nav-item item-menu">
                            <a class="nav-link item-titulo" href="#">OTROS SERVICIOS</a>
                          </li>
                        </ul>
                      </div>
                    <li class="nav-item item-menu">
                      <a class="nav-link item-titulo" href="#">
                            <i class="fas fa-book-reader"></i> RESERVAS</a>
                    </li>
                    <li class="nav-item item-menu">
                      <a class="nav-link item-titulo" href="#">
                            <i class="fas fa-file"></i> REPORTES</a>
                    </li>
                  </ul>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <a href="#menu-toggle" class="btn btn-secondary d-none" id="menu-toggle"><i class="fas fa-caret-left"></i></a>
                    <div class="row">
                        <div class="col p-0 m-0">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->
    </div>
    <!-- Menu Toggle Script -->
    <script>
    $('.toast').toast(option);
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>
