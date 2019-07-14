<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mietnia</title>
</head>
<body>
<h2>Hola {{ $reserva->email}} </h2>
<p>Estamos muy contentos por habernos elegido como tu plataforma de viajes ...</p>
<p>Para poder mejorar nuestra atencion nos gustaria que respondas a una breve encuesta en <a target="_blank" href="https://www.mietnia.com/valuation/{{ base64_encode($reserva->id) }}">Mi encuesta</a>.</p>
</body>
</html>
