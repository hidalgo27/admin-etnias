@extends('layouts.app-admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">RESERVAS</a></li>
                <li class="breadcrumb-item active" aria-current="page">DETALLE</li>
            </ol>
        </nav>
    </div>
    <div class="col-12">
        <div class="row">
                @php
                    $i=0;
                @endphp
                <div class="col-12">
                    Codigo: <b class="text-success">{{ $reserva->codigo }}</b> |
                    Titulo: <b class="text-success">{{ $reserva->nombre }}</b> |
                    Nro. Pax.: <b class="text-success">{{ $reserva->nro_pax }}</b> |
                    Fecha Reserva: <b class="text-success">{{ $reserva->fecha_reserva }}</b> |
                    Fecha Llegada: <b class="text-success">{{ $reserva->fecha_llegada }}</b>
                </div>
                <div class="col-12">
                    <b>DATOS DEL PASAJERO</b>
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
                <div class="col-12">
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
                <div class="col-12">
                        <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>TITULO</th>
                                        <th>PAX</th>
                                        <th>P.U.</th>
                                        <th>SUBTOTAL</th>
                                        <th>ASOCIACION</th>
                                        <th>ESTADO</th>
                                        <th>OPERACIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($reserva->actividades)
                                        @foreach ($reserva->actividades as $actividad)
                                        <tr>
                                                <td><i class="fas fa-map text-primary"></i> {{ $actividad->titulo }}</td>
                                                <td>{{ $reserva->nro_pax }}</td>
                                                <td>{{ $actividad->precio }}</td>
                                                <td>{{ $reserva->nro_pax*$actividad->precio }}</td>
                                                <td>
                                                    {{ $actividad->asociacion->ruc }}
                                                    {{ $actividad->asociacion->nombre }}
                                                    {{ $actividad->asociacion->contacto }}
                                                </td>
                                                <td>
                                                    @if ($actividad->estado==0)
                                                        <span class="badge badge-dark" id="estado_span_actividad_{{ $actividad->id }}">Pendiente</span>
                                                    @elseif($actividad->estado==1)
                                                        <span class="badge badge-success" id="estado_span_actividad_{{ $actividad->id }}">Confirmado</span>
                                                    @elseif($actividad->estado==2)
                                                        <span class="badge badge-danger" id="estado_span_actividad_{{ $actividad->id }}">Anulado</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="hidden" id="estado_actividad_{{ $actividad->id }}" value="{{ $actividad->estado }}">
                                                    @if ($actividad->estado==0)
                                                        <button class="btn btn-primary" id="confirmar_actividad_{{ $actividad->id }}" onclick="confirmar('actividad','{{ $actividad->id }}',$('#estado_actividad_{{ $actividad->id }}').val())">Confirmar</button>
                                                    @elseif($actividad->estado==1)
                                                        <button class="btn btn-danger" id="confirmar_actividad_{{ $actividad->id }}" onclick="confirmar('actividad','{{ $actividad->id }}',$('#estado_actividad_{{ $actividad->id }}').val())">Cancelar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($reserva->comidas)
                                        @foreach ($reserva->comidas as $valor)
                                        <tr>
                                                <td><i class="fas fa-utensils text-danger"></i> {{ $valor->titulo }}</td>
                                                <td>{{ $reserva->nro_pax }}</td>
                                                <td>{{ $valor->precio }}</td>
                                                <td>{{ $reserva->nro_pax*$valor->precio }}</td>
                                                <td>
                                                    {{ $valor->asociacion->ruc }}
                                                    {{ $valor->asociacion->nombre }}
                                                    {{ $valor->asociacion->contacto }}
                                                </td>
                                                <td>
                                                    @if ($valor->estado==0)
                                                        <span class="badge badge-dark">Pendiente</span>
                                                    @elseif($valor->estado==1)
                                                        <span class="badge badge-success">Tomado</span>
                                                    @elseif($valor->estado==2)
                                                        <span class="badge badge-danger">Anulado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($reserva->hospedaje)
                                        @foreach ($reserva->hospedaje as $valor)
                                            <tr>
                                                <td><i class="fas fa-bed"></i> {{ $valor->titulo }}</td>
                                                <td>{{ $reserva->nro_pax }}</td>
                                                <td>{{ $valor->precio }}</td>
                                                <td>{{ $reserva->nro_pax*$valor->precio }}</td>
                                                <td>
                                                    {{ $valor->asociacion->ruc }}
                                                    {{ $valor->asociacion->nombre }}
                                                    {{ $valor->asociacion->contacto }}
                                                </td>
                                                <td>
                                                    @if ($valor->estado==0)
                                                        <span class="badge badge-dark">Pendiente</span>
                                                    @elseif($valor->estado==1)
                                                        <span class="badge badge-success">Tomado</span>
                                                    @elseif($valor->estado==2)
                                                        <span class="badge badge-danger">Anulado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($reserva->transporte)
                                        @foreach ($reserva->transporte as $valor)
                                            <tr>
                                                <td><i class="fas fa-bus"></i> {{ $valor->titulo }}</td>
                                                <td>{{ $reserva->nro_pax }}</td>
                                                <td>{{ $valor->precio }}</td>
                                                <td>{{ $reserva->nro_pax*$valor->precio }}</td>
                                                <td>
                                                    {{ $valor->asociacion->ruc }}
                                                    {{ $valor->asociacion->nombre }}
                                                    {{ $valor->asociacion->contacto }}
                                                </td>
                                                <td>
                                                    @if ($valor->estado==0)
                                                        <span class="badge badge-dark">Pendiente</span>
                                                    @elseif($valor->estado==1)
                                                        <span class="badge badge-success">Tomado</span>
                                                    @elseif($valor->estado==2)
                                                        <span class="badge badge-danger">Anulado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($reserva->servicio)
                                        @foreach ($reserva->servicio as $valor)
                                            <tr>
                                                <td><i class="fas fa-concierge-bell"></i> {{ $valor->titulo }}</td>
                                                <td>{{ $reserva->nro_pax }}</td>
                                                <td>{{ $valor->precio }}</td>
                                                <td>{{ $reserva->nro_pax*$valor->precio }}</td>
                                                <td>
                                                    {{ $valor->asociacion->ruc }}
                                                    {{ $valor->asociacion->nombre }}
                                                    {{ $valor->asociacion->contacto }}
                                                </td>
                                                <td>
                                                    @if ($valor->estado==0)
                                                        <span class="badge badge-dark">Pendiente</span>
                                                    @elseif($valor->estado==1)
                                                        <span class="badge badge-success">Tomado</span>
                                                    @elseif($valor->estado==2)
                                                        <span class="badge badge-danger">Anulado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                </div>
        </div>
    </div>
</div>


@endsection
