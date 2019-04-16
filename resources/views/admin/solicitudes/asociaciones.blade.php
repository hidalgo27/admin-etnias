@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">SOLICITUD DE </li>

@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <b class="text-danger text-15">LISTA DE SOLICITUDES</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
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
                        <table class="table table-bordered table-hover table-striped">
                            <thead >
                                <tr>
                                    <th>#</th>
                                    <th>COMUNIDAD</th>
                                    <th>REPRESENTANTE</th>
                                    <th>TELEFONO</th>
                                    <th>UBICACION</th>
                                    <th>FECHA SOLICITUD</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($asociaciones as $item)
                                    @php
                                        $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at);
                                        $fecha_=$fecha->format('d-m-Y H:i:s');
                                    @endphp
                                    <tr id="row_lista_comunidades_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->nombre_comunidad }}</td>
                                        <td>{{ $item->nombre_representante }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td>{{ $item->ubicacion }}</td>
                                        <td>{{ $fecha_ }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#asociacion_modal_{{ $item->id }}">
                                                    <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="asociacion_modal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">DATOS DETALLADOS</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="row px-2 text-15">
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-danger">INFORMACIÓN GENERAL</b>
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Nombre de la comunidad:</b> {{$item->nombre_comunidad}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Nombre del representante:</b> {{$item->nombre_representante}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Teléfono contacto:</b> {{$item->telefono}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                            <b class="text-secondary">Ubicación:</b> {{$item->ubicacion}}                                                                                </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Email:</b> {{$item->email}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Distancia a la población más cercana:</b> {{$item->distancia_poblacion_cercana}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Transporte:</b> @if($item->transporte=='1') Si @else No @endif | {{number_format($item->transporte_costo,2)}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                            <b class="text-danger">HOSPEDAJE</b>
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Cantidad de viviendas para recibir turistas:</b> {{$item->hospedaje_nro_viviendas}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">¿ Que operador móvil tiene mejor cobertura?:</b> {{$item->operador}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">¿Tiene cuartos individuales?:</b> @if($item->hospedaje_tiene_individuales=='1') Si @else No @endif | {{$item->hospedaje_tiene_individuales_nro}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">¿Tiene cuartos comunales?:</b> @if($item->hospedaje_tiene_comunales=='1') Si @else No @endif | {{$item->hospedaje_tiene_comunales_nro}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">¿ Todas las casas cuentan con servicios básicos?(Electricidad, agua, desague):</b> @if($item->servicios_basicos=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                            <b class="text-secondary">¿Cuentan con acceso a internet?:</b> @if($item->acceso_internet=='1') Si @else No @endif
                                                                        </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-danger">SERVICIOS QUE OFRECE</b>
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Enseñanza para hacer Artesania:</b> @if($item->artesania=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Alimentación (desayuno, almuerzo, cena):</b> @if($item->alimentacion=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Enseñanza enTextileria:</b> @if($item->textileria=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Yachaywasi(Enseñanza para niños: canto, etc):</b> @if($item->yachaywasi=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Yanapacuy:</b> @if($item->yanapacuy=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-6 my-0">
                                                                        <b class="text-secondary">Chasqui:</b> @if($item->chasqui=='1') Si @else No @endif
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Otros:</b> {{$item->otros}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-right d-none">
                                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-danger d-none" onclick="eliminar('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
                                        <a href="{{route('solucitudes.asociacion.crear',$item->id)}}" class="btn btn-success "><i class="fas fa-user-plus"></i>Crear cuenta</a>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
