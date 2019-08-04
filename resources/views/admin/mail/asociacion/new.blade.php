<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>Hola {{$asociacion->nombre}} </h2>
<p>Te damos la bienvenida a MiEtnias estamos muy contentos de tenerte como nuestro aliado...</p>
<p>
    Producto de una minuciosa evaluacion a cargo de nuetro personal...
</p>
<b>Tu cuenta de acceso es:</b>
<table>
    <tbody>
        <tr>
        <td>Usuario</td><td>{{$asociacion->email}}</td>
        </tr>
        <tr>
        <td>Password</td><td>{{$asociacion->password_2}}</td>
    </tr>
    </tbody>
</table>
<p>
    @php
        $url='';
    @endphp
    @if(App::isLocale('en'))
        @php
            $url='http://admin.mietnia.com';
        @endphp
    @else
        @php
            $url='http://admin.mietnia.pe';
        @endphp
    @endif
<a href="{{ $url }}" target="_blank">Ingresa a este link para empezar a trabajar.</a>
</p>
</body>
</html>
