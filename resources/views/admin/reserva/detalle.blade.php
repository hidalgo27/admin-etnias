@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">RESERVAS</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('reserva.lista')}}">LISTA</a></li>
<li class="breadcrumb-item active" aria-current="page">DETALLE</li>

@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-12">
        <div class="row">
                @php
                    $i=0;
                @endphp
                <div class="col-12">
                    Codigo: <b class="text-success">{{ $reserva->codigo }}</b> |
                    Titulo: <b class="text-success">{{ $reserva->nombre }}</b> |
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
                </div>
                <div class="col-12">
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
                <div class="col-12">
                    @php
                        $total_asociacion=0;
                        $total_transporte_externo=0;
                        $total_guias=0;
                        $nro_col_span=0;
                        $total_comision=0;
                    @endphp
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr class="bg-dark text-white"><th colspan="8">ACTIVIDADES</th></tr>
                        </thead>
                        <thead>
                            <tr class="bg-secondary text-white mb-0">
                                <th>TITULO</th>
                                <th>PAX</th>
                                <th>P.U.</th>
                                <th>SUBTOTAL</th>
                                <th>COMISION(%)</th>
                                <th>ASOCIACION</th>
                                <th>ESTADO</th>
                                <th>OPERACIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($reserva->actividades)
                                @foreach ($reserva->actividades as $actividad)
                                @php
                                    $total_asociacion+=$reserva->nro_pax*$actividad->precio;
                                @endphp
                                <tr>
                                        <td><i class="fas fa-map text-primary"></i> {{ $actividad->titulo }}</td>
                                        <td class="text-center">{{ $reserva->nro_pax }}</td>
                                        <td class="text-right">{{ number_format($actividad->precio,2) }}</td>
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$actividad->precio,2) }}</td>
                                        @php
                                            $total_comision+=$reserva->nro_pax*$actividad->precio*($actividad->asociacion->comision/100);
                                        @endphp
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$actividad->precio*($actividad->asociacion->comision/100),2) }} <sup class="text-success"><b>({{ $actividad->asociacion->comision }}%)</b></sup></td>
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
                                                <button class="btn btn-primary btn-sm" id="confirmar_actividad_{{ $actividad->id }}" onclick="confirmar('actividad','{{ $actividad->id }}',$('#estado_actividad_{{ $actividad->id }}').val())">Confirmar</button>
                                            @elseif($actividad->estado==1)
                                                <button class="btn btn-danger btn-sm" id="confirmar_actividad_{{ $actividad->id }}" onclick="confirmar('actividad','{{ $actividad->id }}',$('#estado_actividad_{{ $actividad->id }}').val())">Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($reserva->comidas)
                                @foreach ($reserva->comidas as $valor)
                                @php
                                    $total_asociacion+=$reserva->nro_pax*$valor->precio;
                                @endphp
                                <tr>
                                        <td><i class="fas fa-utensils text-danger"></i> {{ $valor->titulo }}</td>
                                        <td class="text-center">{{ $reserva->nro_pax }}</td>
                                        <td class="text-right">{{ number_format($valor->precio,2) }}</td>
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio,2) }}</td>
                                        @php
                                            $total_comision+=$reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100);
                                        @endphp
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100),2) }} <sup class="text-success"><b>({{ $actividad->asociacion->comision }}%)</b></sup></td>
                                        <td>
                                            {{ $valor->asociacion->ruc }}
                                            {{ $valor->asociacion->nombre }}
                                            {{ $valor->asociacion->contacto }}
                                        </td>
                                        <td>
                                            @if ($valor->estado==0)
                                                <span class="badge badge-dark" id="estado_span_comida_{{ $valor->id }}">Pendiente</span>
                                            @elseif($valor->estado==1)
                                                <span class="badge badge-success" id="estado_span_comida_{{ $valor->id }}">Confirmado</span>
                                            @elseif($valor->estado==2)
                                                <span class="badge badge-danger" id="estado_span_comida_{{ $valor->id }}">Anulado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="hidden" id="estado_comida_{{ $valor->id }}" value="{{ $valor->estado }}">
                                            @if ($valor->estado==0)
                                                <button class="btn btn-primary btn-sm" id="confirmar_comida_{{ $valor->id }}" onclick="confirmar('comida','{{ $valor->id }}',$('#estado_comida_{{ $valor->id }}').val())">Confirmar</button>
                                            @elseif($valor->estado==1)
                                                <button class="btn btn-danger btn-sm" id="confirmar_comida_{{ $valor->id }}" onclick="confirmar('comida','{{ $valor->id }}',$('#estado_comida_{{ $valor->id }}').val())">Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($reserva->hospedajes)
                                @foreach ($reserva->hospedajes as $valor)
                                @php
                                    $total_asociacion+=$reserva->nro_pax*$valor->precio;
                                @endphp
                                    <tr>
                                        <td><i class="fas fa-bed"></i> {{ $valor->titulo }}</td>
                                        <td class="text-center">{{ $reserva->nro_pax }}</td>
                                        <td class="text-right">{{ number_format($valor->precio,2) }}</td>
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio,2) }}</td>
                                        @php
                                            $total_comision+=$reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100);
                                        @endphp
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100),2) }} <sup class="text-success"><b>({{ $actividad->asociacion->comision }}%)</b></sup></td>
                                        <td>
                                            {{ $valor->asociacion->ruc }}
                                            {{ $valor->asociacion->nombre }}
                                            {{ $valor->asociacion->contacto }}
                                        </td>
                                        <td>
                                            @if ($valor->estado==0)
                                                <span class="badge badge-dark" id="estado_span_hospedaje_{{ $valor->id }}">Pendiente</span>
                                            @elseif($valor->estado==1)
                                                <span class="badge badge-success" id="estado_span_hospedaje_{{ $valor->id }}">Confirmado</span>
                                            @elseif($valor->estado==2)
                                                <span class="badge badge-danger" id="estado_span_hospedaje_{{ $valor->id }}">Anulado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="hidden" id="estado_hospedaje_{{ $valor->id }}" value="{{ $valor->estado }}">
                                            @if ($valor->estado==0)
                                                <button class="btn btn-primary btn-sm" id="confirmar_hospedaje_{{ $valor->id }}" onclick="confirmar('hospedaje','{{ $valor->id }}',$('#estado_hospedaje_{{ $valor->id }}').val())">Confirmar</button>
                                            @elseif($valor->estado==1)
                                                <button class="btn btn-danger btn-sm" id="confirmar_hospedaje_{{ $valor->id }}" onclick="confirmar('hospedaje','{{ $valor->id }}',$('#estado_hospedaje_{{ $valor->id }}').val())">Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($reserva->transporte)
                                @foreach ($reserva->transporte as $valor)
                                @php
                                    $total_asociacion+=$reserva->nro_pax*$valor->precio;
                                @endphp
                                    <tr>
                                        <td><i class="fas fa-bus"></i> {{ $valor->titulo }}</td>
                                        <td class="text-center">{{ $reserva->nro_pax }}</td>
                                        <td class="text-right">{{ number_format($valor->precio,2) }}</td>
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio,2) }}</td>
                                        @php
                                            $total_comision+=$reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100);
                                        @endphp
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100),2) }} <sup class="text-success"><b>({{ $actividad->asociacion->comision }}%)</b></sup></td>
                                        <td>
                                            {{ $valor->asociacion->ruc }}
                                            {{ $valor->asociacion->nombre }}
                                            {{ $valor->asociacion->contacto }}
                                        </td>
                                        <td>
                                            @if ($valor->estado==0)
                                                <span class="badge badge-dark" id="estado_span_transporte_{{ $valor->id }}">Pendiente</span>
                                            @elseif($valor->estado==1)
                                                <span class="badge badge-success" id="estado_span_transporte_{{ $valor->id }}">Confirmado</span>
                                            @elseif($valor->estado==2)
                                                <span class="badge badge-danger" id="estado_span_transporte_{{ $valor->id }}">Anulado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="hidden" id="estado_transporte_{{ $valor->id }}" value="{{ $valor->estado }}">
                                            @if ($valor->estado==0)
                                                <button class="btn btn-primary btn-sm" id="confirmar_transporte_{{ $valor->id }}" onclick="confirmar('transporte','{{ $valor->id }}',$('#estado_transporte_{{ $valor->id }}').val())">Confirmar</button>
                                            @elseif($valor->estado==1)
                                                <button class="btn btn-danger btn-sm" id="confirmar_transporte_{{ $valor->id }}" onclick="confirmar('transporte','{{ $valor->id }}',$('#estado_transporte_{{ $valor->id }}').val())">Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($reserva->servicios)
                                @foreach ($reserva->servicios as $valor)
                                @php
                                    $total_asociacion+=$reserva->nro_pax*$valor->precio;
                                @endphp
                                    <tr>
                                        <td><i class="fas fa-concierge-bell"></i> {{ $valor->titulo }}</td>
                                        <td class="text-center">{{ $reserva->nro_pax }}</td>
                                        <td class="text-right">{{ number_format($valor->precio,2) }}</td>
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio,2) }}</td>
                                        @php
                                            $total_comision+=$reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100);
                                        @endphp
                                        <td class="text-right">{{ number_format($reserva->nro_pax*$valor->precio*($valor->asociacion->comision/100),2) }} <sup class="text-success"><b>({{ $actividad->asociacion->comision }}%)</b></sup></td>

                                        <td>
                                            {{ $valor->asociacion->ruc }}
                                            {{ $valor->asociacion->nombre }}
                                            {{ $valor->asociacion->contacto }}
                                        </td>
                                        <td>
                                            @if ($valor->estado==0)
                                                <span class="badge badge-dark" id="estado_span_servicio_{{ $valor->id }}">Pendiente</span>
                                            @elseif($valor->estado==1)
                                                <span class="badge badge-success" id="estado_span_servicio_{{ $valor->id }}">Confirmado</span>
                                            @elseif($valor->estado==2)
                                                <span class="badge badge-danger" id="estado_span_servicio_{{ $valor->id }}">Anulado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="hidden" id="estado_servicio_{{ $valor->id }}" value="{{ $valor->estado }}">
                                            @if ($valor->estado==0)
                                                <button class="btn btn-primary btn-sm" id="confirmar_servicio_{{ $valor->id }}" onclick="confirmar('servicio','{{ $valor->id }}',$('#estado_servicio_{{ $valor->id }}').val())">Confirmar</button>
                                            @elseif($valor->estado==1)
                                                <button class="btn btn-danger btn-sm" id="confirmar_servicio_{{ $valor->id }}" onclick="confirmar('servicio','{{ $valor->id }}',$('#estado_servicio_{{ $valor->id }}').val())">Cancelar</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="3"><b>TOTAL</b></td>
                                <td class="text-right"><b><sup>S/.</sup> {{number_format($total_asociacion,2)}}</b></td>
                                <td class="text-right" colspan="{{ $nro_col_span }}"> <b>+ <sup>S/.</sup> {{number_format($total_comision,2)}}</b></td>
                                <td class="text-left"><b>= <sup>S/.</sup> {{ number_format($total_asociacion+$total_comision,2)}}</b></td>
                            </tr>
                            @php
                                $total_transporte_externo=0;
                            @endphp
                            @if(Auth::user()->hasRole('admin'))
                                @if ($reserva->transporte_externo)
                                    <thead>
                                        <tr class="bg-dark text-white"><th colspan="8">TRANSPORTE EXTERNO</th></tr>
                                    </thead>
                                    <thead>
                                        <tr class="bg-secondary text-white mb-0">
                                            <th>TITULO</th>
                                            <th>PAX</th>
                                            <th>P.U.</th>
                                            <th>SUBTOTAL</th>
                                            <th colspan="2">PROVEEDOR</th>
                                            <th>ESTADO</th>
                                            <th>OPERACIONES</th>
                                        </tr>
                                    </thead>
                                    @foreach ($reserva->transporte_externo as $valor)
                                        @if ($valor->s_p=='PRIVADO')
                                            @php
                                                $total_transporte_externo+=$valor->precio*$valor->pax;
                                            @endphp
                                        @elseif ($valor->s_p=='COMPARTIDO')
                                            @php
                                                $total_transporte_externo+=$valor->precio;
                                            @endphp
                                        @endif

                                        <tr>
                                            <td>
                                                <i class="fas fa-bus"></i> <span class="badge badge-success">{{ $valor->categoria }} [{{ $valor->min }} - {{ $valor->max }}]</span> <span class="badge badge-secondary">{{ $valor->ruta_salida }} / {{ $valor->ruta_llegada }}</span> <span class="badge badge-primary">{{ $valor->s_p }}</span>
                                            </td>
                                            <td class="text-center">{{ $valor->pax }}</td>
                                            <td class="text-right">
                                                @if ($valor->s_p=='PRIVADO')
                                                    {{ number_format($valor->precio,2) }}
                                                @elseif ($valor->s_p=='COMPARTIDO')
                                                {{ number_format($valor->precio/$valor->pax,2) }}
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if ($valor->s_p=='PRIVADO')
                                                    {{ number_format($valor->precio*$valor->pax,2) }}
                                                @elseif ($valor->s_p=='COMPARTIDO')
                                                {{ number_format($valor->precio,2) }}
                                                @endif
                                            </td>

                                            <td colspan="2">
                                                <div class="row">
                                                    @if ($valor->proveedor_id>0)
                                                        @php
                                                            $objeto=$proveedores->where('id',$valor->proveedor_id)->first();
                                                        @endphp
                                                    @endif
                                                    <div id="rpt_proveedor_TRANSPORTE_{{ $valor->id }}" class="col-5 ">@if($valor->proveedor_id>0) {{$objeto->nombre_comercial}} @else Sin proveedor @endif</div>
                                                    <div id="rpt_precio_pago_TRANSPORTE_{{ $valor->id }}" class="col-2  px-0">@if($valor->proveedor_id>0) {{$valor->precio_reserva}} @else 0.00 @endif</div>
                                                    <div id="rpt_fecha_pago_TRANSPORTE_{{ $valor->id }}" class="col-3  px-0">@if($valor->proveedor_id>0) {{$valor->fecha_pago}} @else Sin fecha @endif</div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_{{ $valor->id }}"><i class="fas fa-plus"></i></button>
                                                        <!-- Modal -->
                                                        <div id="myModal_{{ $valor->id }}" class="modal fade" role="dialog">
                                                            <div class="modal-dialog  modal-lg">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary text-white">
                                                                            <h4 class="modal-title">Agregar proveedor</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12 text-20">
                                                                                <i class="fas fa-bus"></i>
                                                                                <span class="badge badge-success">{{ $valor->categoria }} [{{ $valor->min }} - {{ $valor->max }}]</span>
                                                                                <span class="badge badge-secondary">{{ $valor->ruta_salida }} / {{ $valor->ruta_llegada }}</span>
                                                                                <span class="badge badge-primary">{{ $valor->s_p }}</span>
                                                                                <span class="badge badge-success"><sup>S/.</sup>{{ number_format($valor->precio,2) }}</span>
                                                                            <hr>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <b class="text-18">Lista de proveedores</b>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <table class="table table-bordered table-condensed table-hover table-sm">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>PROVEEDOR</th>
                                                                                            <th>COSTO</th>
                                                                                            <th>PLAZO</th>
                                                                                            <th>FECHA DE PAGO</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($transporte_externo->where('comunidad_id',$valor->comunidad_id)->where('categoria',$valor->categoria)->where('ruta_salida',$valor->ruta_salida)->where('ruta_llegada',$valor->ruta_llegada)->where('min',$valor->min)->where('max',$valor->max)->where('s_p',$valor->s_p) as $transporte_externo_)
                                                                                            @foreach ($transporte_externo_->transporte_externo_proveedor as $transporte_externo_proveedor)
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <label for="proveedor_{{ $valor->id }}_{{ $transporte_externo_proveedor->proveedor->id }}">
                                                                                                        <input type="radio" name="proveedor_{{ $valor->id }}[]" id="proveedor_{{ $valor->id }}_{{ $transporte_externo_proveedor->proveedor->id }}" value="{{ $transporte_externo_proveedor->proveedor->id }}" onchange="proveedor_escojido('{{ $transporte_externo_proveedor->proveedor->id }}')">
                                                                                                        {{ $transporte_externo_proveedor->proveedor->nombre_comercial }}
                                                                                                    </label>
                                                                                                </td>
                                                                                                <td style="width:120px">
                                                                                                    @if ($valor->s_p=='PRIVADO')
                                                                                                        @php
                                                                                                            $precio_proveedor=number_format($transporte_externo_proveedor->precio*$valor->pax,2);
                                                                                                        @endphp
                                                                                                    @elseif ($valor->s_p=='COMPARTIDO')
                                                                                                    @php
                                                                                                        $precio_proveedor=number_format($transporte_externo_proveedor->precio,2);
                                                                                                    @endphp
                                                                                                    @endif
                                                                                                    <input class="form-control" type="hidden" name="proveedor_nombre_" id="proveedor_nombre_{{ $valor->id }}_{{ $transporte_externo_proveedor->proveedor->id }}" value="{{ $transporte_externo_proveedor->proveedor->nombre_comercial }}">
                                                                                                    <input class="form-control" type="number" name="precio_pago" id="precio_pago_{{ $valor->id }}_{{ $transporte_externo_proveedor->proveedor->id }}" value="{{ $precio_proveedor }}">
                                                                                                </td>
                                                                                                <td>
                                                                                                    {{ $transporte_externo_proveedor->proveedor->plazo }}
                                                                                                    {{ $transporte_externo_proveedor->proveedor->desci }}
                                                                                                </td>
                                                                                                <td style="width:100px">
                                                                                                    @php
                                                                                                        $fecha = Carbon::createFromFormat("Y-m-d", $reserva->fecha_llegada);
                                                                                                    @endphp
                                                                                                    @if ($transporte_externo_proveedor->proveedor->desci=='ANTES')
                                                                                                        @php
                                                                                                            $fecha->subDays($transporte_externo_proveedor->proveedor->plazo);
                                                                                                        @endphp
                                                                                                    @elseif ($transporte_externo_proveedor->proveedor->desci=='DESPUES')
                                                                                                        @php
                                                                                                            $fecha->addDays($transporte_externo_proveedor->proveedor->plazo);
                                                                                                        @endphp
                                                                                                    @endif
                                                                                                    <input class="form-control" type="date" name="fecha_pago" id="fecha_pago_{{ $valor->id }}_{{ $transporte_externo_proveedor->proveedor->id }}" value="{{ $fecha->format('Y-m-d') }}">
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div id="rpt_{{ $valor->id }}" class="col-12">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" onclick="escojer_proveedor('{{ $valor->id }}','TRANSPORTE')" >Escojer</button>
                                                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                @if ($valor->estado==0)
                                                    <span class="badge badge-dark" id="estado_span_TRANSPORTE_{{ $valor->id }}">Pendiente</span>
                                                @elseif($valor->estado==1)
                                                    <span class="badge badge-success" id="estado_span_TRANSPORTE_{{ $valor->id }}">Confirmado</span>
                                                @elseif($valor->estado==2)
                                                    <span class="badge badge-danger" id="estado_span_TRANSPORTE_{{ $valor->id }}">Anulado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="hidden" id="estado_TRANSPORTE_{{ $valor->id }}" value="{{ $valor->estado }}">
                                                @if ($valor->estado==0)
                                                    <button class="btn btn-primary btn-sm" id="confirmar_TRANSPORTE_{{ $valor->id }}" onclick="confirmar_t_g('TRANSPORTE','{{ $valor->id }}',$('#estado_TRANSPORTE_{{ $valor->id }}').val())">Confirmar</button>
                                                @elseif($valor->estado==1)
                                                    <button class="btn btn-danger btn-sm" id="confirmar_TRANSPORTE_{{ $valor->id }}" onclick="confirmar('TRANSPORTE','{{ $valor->id }}',$('#estado_TRANSPORTE_{{ $valor->id }}').val())">Cancelar</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr><td colspan="3"></td><td class="text-right"><b><sup>S/.</sup>{{number_format($total_transporte_externo,2)}}</b></td></tr>
                                @endif
                            @endif
                            @php
                                $total_guia=0;
                            @endphp
                            @if(Auth::user()->hasRole('admin'))
                                @if ($reserva->guia)
                                    <thead>
                                        <tr class="bg-dark text-white"><th colspan="8">GUIADO</th></tr>
                                    </thead>
                                    <thead>
                                        <tr class="bg-secondary text-white mb-0">
                                            <th>TITULO</th>
                                            <th>PAX</th>
                                            <th>P.U.</th>
                                            <th>SUBTOTAL</th>
                                            <th colspan="2">PROVEEDOR</th>
                                            <th>ESTADO</th>
                                            <th>OPERACIONES</th>
                                        </tr>
                                    </thead>
                                    @foreach ($reserva->guia as $valor)
                                        @if ($valor->s_p=='PRIVADO')
                                            @php
                                                $total_guia+=$valor->precio*$valor->pax;
                                            @endphp
                                        @elseif ($valor->s_p=='COMPARTIDO')
                                            @php
                                                $total_guia+=$valor->precio;
                                            @endphp
                                        @endif

                                        <tr>
                                            <td>
                                                <i class="fas fa-flag"></i> <span class="badge badge-success">{{ $valor->idioma }} [{{ $valor->min }} - {{ $valor->max }}]</span> <span class="badge badge-primary">{{ $valor->s_p }}</span>
                                            </td>
                                            <td class="text-center">{{ $valor->pax }}</td>
                                            <td class="text-right">
                                                @if ($valor->s_p=='PRIVADO')
                                                    {{ number_format($valor->precio,2) }}
                                                @elseif ($valor->s_p=='COMPARTIDO')
                                                {{ number_format($valor->precio/$valor->pax,2) }}
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if ($valor->s_p=='PRIVADO')
                                                    {{ number_format($valor->precio*$valor->pax,2) }}
                                                @elseif ($valor->s_p=='COMPARTIDO')
                                                {{ number_format($valor->precio,2) }}
                                                @endif
                                            </td>

                                            <td colspan="2">
                                                <div class="row">
                                                    @if ($valor->proveedor_id>0)
                                                        @php
                                                            $objeto=$proveedores->where('id',$valor->proveedor_id)->first();
                                                        @endphp
                                                    @endif
                                                    <div id="rpt_proveedor_GUIA_{{ $valor->id }}" class="col-5 ">@if($valor->proveedor_id>0) {{$objeto->nombre_comercial}} @else Sin proveedor @endif</div>
                                                    <div id="rpt_precio_pago_GUIA_{{ $valor->id }}" class="col-2  px-0">@if($valor->proveedor_id>0) {{$valor->precio_reserva}} @else 0.00 @endif</div>
                                                    <div id="rpt_fecha_pago_GUIA_{{ $valor->id }}" class="col-3  px-0">@if($valor->proveedor_id>0) {{$valor->fecha_pago}} @else Sin fecha @endif</div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal_g_{{ $valor->id }}"><i class="fas fa-plus"></i></button>
                                                        <!-- Modal -->
                                                        <div id="myModal_g_{{ $valor->id }}" class="modal fade" role="dialog">
                                                            <div class="modal-dialog  modal-lg">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary text-white">
                                                                            <h4 class="modal-title">Agregar proveedor</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12 text-20">
                                                                                <i class="fas fa-flag"></i>
                                                                                <span class="badge badge-success">{{ $valor->idioma }} [{{ $valor->min }} - {{ $valor->max }}]</span>
                                                                                <span class="badge badge-primary">{{ $valor->s_p }}</span>
                                                                                <span class="badge badge-success"><sup>S/.</sup>{{ number_format($valor->precio,2) }}</span>
                                                                            <hr>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <b class="text-18">Lista de proveedores</b>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <table class="table table-bordered table-condensed table-hover table-sm">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>PROVEEDOR</th>
                                                                                            <th>COSTO</th>
                                                                                            <th>PLAZO</th>
                                                                                            <th>FECHA DE PAGO</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($guiado->where('departamento_id',$valor->departamento_id)->where('idioma',$valor->idioma)->where('min',$valor->min)->where('max',$valor->max)->where('s_p',$valor->s_p) as $guia)
                                                                                            @foreach ($guia->guia_proveedor as $guia_proveedor)
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <label for="proveedor_{{ $valor->id }}_{{ $guia_proveedor->proveedor->id }}">
                                                                                                        <input type="radio" name="proveedor_{{ $valor->id }}[]" id="proveedor_{{ $valor->id }}_{{ $guia->proveedor->id }}" value="{{ $guia->proveedor->id }}" onchange="proveedor_escojido('{{ $guia->proveedor->id }}')">
                                                                                                        {{ $guia->proveedor->nombre_comercial }}
                                                                                                    </label>
                                                                                                </td>
                                                                                                <td style="width:120px">
                                                                                                    @if ($valor->s_p=='PRIVADO')
                                                                                                        @php
                                                                                                            $precio_proveedor=number_format($guia_proveedor->precio*$valor->pax,2);
                                                                                                        @endphp
                                                                                                    @elseif ($valor->s_p=='COMPARTIDO')
                                                                                                    @php
                                                                                                        $precio_proveedor=number_format($guia_proveedor->precio,2);
                                                                                                    @endphp
                                                                                                    @endif
                                                                                                    <input class="form-control" type="hidden" name="proveedor_nombre_" id="proveedor_nombre_{{ $valor->id }}_{{ $guia_proveedor->proveedor->id }}" value="{{ $guia_proveedor->proveedor->nombre_comercial }}">
                                                                                                    <input class="form-control" type="number" name="precio_pago" id="precio_pago_{{ $valor->id }}_{{ $guia_proveedor->proveedor->id }}" value="{{ $precio_proveedor }}">
                                                                                                </td>
                                                                                                <td>
                                                                                                    {{ $guia_proveedor->proveedor->plazo }}
                                                                                                    {{ $guia_proveedor->proveedor->desci }}
                                                                                                </td>
                                                                                                <td style="width:100px">
                                                                                                    @php
                                                                                                        $fecha = Carbon::createFromFormat("Y-m-d", $reserva->fecha_llegada);
                                                                                                    @endphp
                                                                                                    @if ($guia_proveedor->proveedor->desci=='ANTES')
                                                                                                        @php
                                                                                                            $fecha->subDays($guia_proveedor->proveedor->plazo);
                                                                                                        @endphp
                                                                                                    @elseif ($guia_proveedor->proveedor->desci=='DESPUES')
                                                                                                        @php
                                                                                                            $fecha->addDays($guia_proveedor->proveedor->plazo);
                                                                                                        @endphp
                                                                                                    @endif
                                                                                                    <input class="form-control" type="date" name="fecha_pago" id="fecha_pago_{{ $valor->id }}_{{ $guia_proveedor->proveedor->id }}" value="{{ $fecha->format('Y-m-d') }}">
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endforeach
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div id="rpt_{{ $valor->id }}" class="col-12">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-primary" onclick="escojer_proveedor('{{ $valor->id }}','GUIA')" >Escojer</button>
                                                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                @if ($valor->estado==0)
                                                    <span class="badge badge-dark" id="estado_span_GUIA_{{ $valor->id }}">Pendiente</span>
                                                @elseif($valor->estado==1)
                                                    <span class="badge badge-success" id="estado_span_GUIA_{{ $valor->id }}">Confirmado</span>
                                                @elseif($valor->estado==2)
                                                    <span class="badge badge-danger" id="estado_span_GUIA_{{ $valor->id }}">Anulado</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="hidden" id="estado_GUIA_{{ $valor->id }}" value="{{ $valor->estado }}">
                                                @if ($valor->estado==0)
                                                    <button class="btn btn-primary btn-sm" id="confirmar_GUIA_{{ $valor->id }}" onclick="confirmar_t_g('GUIA','{{ $valor->id }}',$('#estado_GUIA_{{ $valor->id }}').val())">Confirmar</button>
                                                @elseif($valor->estado==1)
                                                    <button class="btn btn-danger btn-sm" id="confirmar_GUIA_{{ $valor->id }}" onclick="confirmar('GUIA','{{ $valor->id }}',$('#estado_GUIA_{{ $valor->id }}').val())">Cancelar</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr><td colspan="3"></td><td class="text-right"><b><sup>S/.</sup>{{number_format($total_guia,2)}}</b></td></tr>
                                @endif
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white"><th colspan="3"><b class="text-success text-18"> GRAN TOTAL</b></th><th colspan="5"><b class="text-success text-18">{{number_format($total_asociacion+$total_comision+$total_transporte_externo+$total_guia,2)}}</b></th></tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
</div>


@endsection
