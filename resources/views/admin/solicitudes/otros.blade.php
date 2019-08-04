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
                                    <th>LUGAR</th>
                                    <th>CATEGORIA</th>
                                    <th>NOMBRE</th>
                                    <th>EMAIL</th>
                                    <th>TELEFONO</th>
                                    <th>FECHA SOLICITUD</th>
                                    <th>OPERACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($solicitudes as $item)
                                    @php
                                        $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at);
                                        $fecha_=$fecha->format('d-m-Y H:i:s');
                                    @endphp
                                    <tr id="row_lista_comunidades_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>
                                            {{$departamentos->where('id',$item->departamento_id)->first()->departamento }}<br>
                                            {{$provincias->where('id',$item->provincia_id)->first()->provincia }}<br>
                                            {{$distritos->where('id',$item->distrito_id)->first()->distrito }}
                                        </td>
                                        <td>{{ $item->categoria }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        {{-- <td>{{ $item->perfil_linkedin }}</td> --}}
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->telefono }}</td>
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
                                                                        <b class="text-secondary">Categoria:</b> {{$item->categoria}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Nombre:</b> {{$item->nombre}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Perfil linkedin:</b> {{$item->perfil_linkedin}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Email:</b> {{$item->email}}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                            <b class="text-secondary">Telefono:</b> {{$item->telefono}}                                                                                </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Depatemento:</b> {{$departamentos->where('id',$item->departamento_id)->first()->departamento }}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Provincia:</b> {{$provincias->where('id',$item->provincia_id)->first()->provincia }}
                                                                    </div>
                                                                    <div class="col-12 my-0">
                                                                        <b class="text-secondary">Distrito:</b> {{ $distritos->where('id',$item->distrito_id)->first()->distrito }}
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
                                            <a href="{{route('solucitudes.otros.crear',$item->id)}}" class="btn btn-success "><i class="fas fa-user-plus"></i>Crear cuenta</a>
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
