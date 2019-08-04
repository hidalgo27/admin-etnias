@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">ENCUESTA</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('encuesta.lista')}}">LISTA</a></li>
<li class="breadcrumb-item active" aria-current="page">DETALLE</li>

@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col 12">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {!! session()->get('success') !!}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {!! session()->get('error') !!}
                        </div>
                    @endif
            </div>
        </div>
        <div class="row">
                @php
                    $i=0;
                @endphp
                <div class="col-12">
                    Codigo: <b class="text-success">{{ $reserva->codigo }}</b> |
                    Titular: <b class="text-success">{{ $reserva->nombre }}</b> |
                    Nro. Pax.: <b class="text-success">{{ $reserva->nro_pax }}</b> |
                    Fecha Reserva: <b class="text-success">
                    @php
                        $fecha_reserva ='no tiene';
                    @endphp
                    @if($reserva->created_at)
                        @php
                            $fecha_reserva = Carbon::createFromFormat("Y-m-d H:i:s", $reserva->created_at);
                        @endphp
                    @endif

                    @if($reserva->created_at){{ $fecha_reserva->format('d-m-Y H:i:s') }}@endif </b> |
                    Fecha Llegada: <b class="text-success">
                    @php
                        $fecha_llegada = Carbon::createFromFormat("Y-m-d", $reserva->fecha_llegada);
                    @endphp
                        {{ $fecha_llegada->format('d-m-Y')}}</b>

                    @if($reserva->estado=='2')
                        <b class="bg-danger text-white px-1">Reserva cancelada !</b>
                    @endif
                </div>
                <div class="col-12 d-none">
                    <b>DATOS DE LOS PASAJEROS</b>
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>GENERO</th>
                                <th>PASAPORTE / DNI</th>
                                <th>NACIONALIDAD</th>
                                <th>RESTRICCIONES</th>
                                <th>EMAIL</th>
                                <th>CELULAR</th>
                                <th>COMENTARIOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reserva->clientes as $cliente)
                                @php
                            $i++;
                                @endphp
                                <tr>
                                    <th>{{ $i }}</th>
                                    <th>{{ $cliente->nombres }}</th>
                                    <th>{{ $cliente->apellidos }}</th>
                                    <th>{{ $cliente->sexo }}</th>
                                    <th>{{ $cliente->pasaporte }}</th>
                                    <th>{{ $cliente->nacionalidad }}</th>
                                    <th>{{ $cliente->restricciones }}</th>
                                    <th>{{ $cliente->email }}</th>
                                    <th>{{ $cliente->telefono }}</th>
                                    <th>{{ $cliente->comentarios }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 d-none">
                    <b>PAGOS DEL PASAJERO</b>
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>GENERO</th>
                                <th>PASAPORTE / DNI</th>
                                <th>NACIONALIDAD</th>
                                <th>RESTRICCIONES</th>
                                <th>EMAIL</th>
                                <th>CELULAR</th>
                                <th>COMENTARIOS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($reserva->clientes as $cliente)
                                @php
                            $i++;
                                @endphp
                                <tr>
                                    <th>{{ $i }}</th>
                                    <th>{{ $cliente->nombres }}</th>
                                    <th>{{ $cliente->apellidos }}</th>
                                    <th>{{ $cliente->sexo }}</th>
                                    <th>{{ $cliente->pasaporte }}</th>
                                    <th>{{ $cliente->nacionalidad }}</th>
                                    <th>{{ $cliente->restricciones }}</th>
                                    <th>{{ $cliente->email }}</th>
                                    <th>{{ $cliente->telefono }}</th>
                                    <th>{{ $cliente->comentarios }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-2">
                    @php
                        $total_asociacion=0;
                        $total_transporte_externo=0;
                        $total_guias=0;
                        $nro_col_span=0;
                        $total_comision=0;
                    @endphp
                    <table class="table table-striped table-hover table-sm table-responsive">
                        <thead>
                            <tr class="bg-dark text-white"><th colspan="11">ENCUESTA</th></tr>
                        </thead>
                        <thead>
                            <tr class="bg-secondary text-white mb-0">
                                <th>PREGUNTA</th>
                                <th>VALORACION <i class="fas fa-star text-warning"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($reserva->encuestas)
                                @foreach ($reserva->encuestas as $encuesta)
                                <tr>
                                        <td>{{ $encuesta->pregunta }}</td>
                                        <td>
                                            @if($encuesta->valoracion!='0')
                                                {{ $encuesta->valoracion }}
                                            @else
                                                Sin repuesta
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                    <div class="div">
                        <div class="col-12">
                            <form action="{{route('encuesta.enviar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reserva_id" value="{{ $reserva->id }}">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane"></i> Generar y Enviar encuesta</button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


@endsection
