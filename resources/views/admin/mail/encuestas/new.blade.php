<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mietnia</title>
</head>
<body>
<h2>@lang('admin.hola') {{ $reserva->email}} </h2>
<p>@lang('admin.estamos')</p>
    @php
        $url='';
    @endphp
    @if(App::isLocale('en'))
        @php
            $url='http://mietnia.com';
        @endphp
    @else
        @php
            $url='http://mietnia.pe';
        @endphp
    @endif
<p>@lang('admin.para') <a target="_blank" href="{{ $url }}/valuation/{{ base64_encode($reserva->id) }}">Mietnia</a>.</p>
</body>
</html>
