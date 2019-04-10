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
    {{--  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">  --}}
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
              @include('layouts.nav')
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
                                {{-- <a class="nav-link item-titulo" href="{{ route('servicios.nuevo',[$asociacion->id]) }}">SERVIVIOS</a> --}}
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
            </div>
            <div class="col-10">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
