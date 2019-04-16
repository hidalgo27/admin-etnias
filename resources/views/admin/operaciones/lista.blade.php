@extends('layouts.app-admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('reserva.lista')}}">RESERVAS</a></li>
    <li class="breadcrumb-item active"><a href="{{route('operaciones.lista',[$f1,$f2])}}"">OPERACIONES</a></li>
@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="row">
    
    <div class="col-12">
        <div class="row mb-1">
            <div id="codigo_cerrado" class="col-12 px-0 form-inline">
            <form action="{{route('operaciones.post.lista')}}" method="POST">
                    <div class="input-group px-0 mx-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text">FILTRO</div>
                        </div>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Desde</div>
                        </div>
                        <input type="date" class="form-control" name="desde" id="desde" placeholder="Desde" value="{{$f1}}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Hasta</div>
                        </div>
                        <input type="date" class="form-control" name="hasta" id="hasta" placeholder="Hasta" value="{{$f2}}">
                        <div class="input-group-prepend">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary" onclick="buscar_reserva($('#codigo_buscar').val())"><i class="fas fa-search"></i> </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12 card">
                <table class="mt-3 table table-hover table-bordered table-sm text-11">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>FECHA</th>
                            <th>PAX</th>
                            <th>CLIENTE</th>
                            <th>ACTIVIDAD</th>
                            <th>COMIDA</th>
                            <th>HOSPEDAJE</th>
                            <th>TRANSPORTE</th>
                            <th>SERVICIOS</th>
                            <th>TRANSPORTE EXTERNO</th>
                            <th>GUIADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($operaciones as $item)
                            <tr>
                                <td>
                                    @php
                                        $fecha_llegada = Carbon::createFromFormat("Y-m-d", $item->fecha_llegada);
                                        $f=$fecha_llegada->format('d-m-Y');
                                    @endphp
                                    <b>{{$f}}</b>
                                </td>
                                <td><b>{{$item->nro_pax}}</b></td>
                                <td><span class="text-primary">{{$item->codigo}}</span> {{$item->nombre}}</td>
                                <td>
                                    @foreach ($item->actividades as $objeto)
                                        {{$objeto->titulo}} <span class="text-primary">{{$objeto->asociacion->nombre}}</span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->comidas as $objeto)
                                        {{$objeto->titulo}} <span class="text-primary">{{$objeto->asociacion->nombre}}</span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->hospedajes as $objeto)
                                        {{$objeto->titulo}} <span class="text-primary">{{$objeto->asociacion->nombre}}</span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->transporte as $objeto)
                                        {{$objeto->titulo}} <span class="text-primary">{{$objeto->asociacion->nombre}}</span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->servicios as $objeto)
                                        {{$objeto->titulo}} <span class="text-primary">{{$objeto->asociacion->nombre}}</span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->transporte_externo as $objeto)
                                        {{$objeto->categoria}} | {{$objeto->ruta_salida}} / {{$objeto->ruta_llegada}} | {{$objeto->s_p}}
                                        <span class="text-primary">
                                            @if ($objeto->proveedor_id>0)
                                                {{$proveedores->where('id',$objeto->proveedor_id)->first()->nombre_comercial}}
                                            @else
                                                No hay proveedor
                                            @endif
                                        </span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->guia as $objeto)
                                    {{$objeto->categoria}} | {{$objeto->ruta_salida}} / {{$objeto->ruta_llegada}} | {{$objeto->s_p}}
                                        <span class="text-primary">
                                            @if ($objeto->proveedor_id>0)
                                                {{$proveedores->where('id',$objeto->proveedor_id)->first()->nombre_comercial}}
                                            @else
                                                No hay proveedor
                                            @endif
                                        </span>
                                        @if ($objeto->estado=='0')
                                            <span class="text-danger"><i class="fas fa-user-clock"></i></span>
                                        @elseif ($objeto->estado=='1')
                                            <span class="text-success"><i class="fas fa-user-check"></i></span>
                                        @elseif ($objeto->estado=='2')
                                            <span class="text-secondary"><i class="fas fa-user-alt-slach"></i></span>
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


@endsection
