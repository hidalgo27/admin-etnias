@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">PROVEEDORES</li>

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @php
                                    $active='active';
                                @endphp
                                @foreach ($tipo_servicios as $tipo_servicio)
                                    <a class="nav-item nav-link {{$active}}" id="nav-{{$tipo_servicio->id}}-tab" data-toggle="tab" href="#nav-{{$tipo_servicio->id}}" role="tab" aria-controls="nav-{{$tipo_servicio->id}}" aria-selected="true">{!! $tipo_servicio->icono !!} {{$tipo_servicio->nombre}}</a>
                                    @php
                                        $active='';
                                    @endphp
                                @endforeach
                                {{-- <a class="nav-item nav-link" id="nav-guia-tab" data-toggle="tab" href="#nav-guia" role="tab" aria-controls="nav-guia" aria-selected="false"><i class="fas fa-flag"></i> GUIA</a> --}}
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @php
                                $active='active';
                            @endphp
                            @foreach ($tipo_servicios as $tipo_servicio)
                            <div class="tab-pane fade show {{$active}}" id="nav-{{$tipo_servicio->id}}" role="tabpanel" aria-labelledby="nav-{{$tipo_servicio->id}}-tab">
                                <div class="row mt-2">
                                    <div class="col-9">
                                        <b class="text-danger text-15">LISTA DE {{$tipo_servicio->nombre}}</b>
                                    </div>
                                    <div class="col-3 text-right">
                                        <a href="{{ route('proveedor.nuevo',$tipo_servicio->nombre) }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead >
                                                <tr>
                                                    <th>#</th>
                                                    <th>DEPARTAMENTO</th>
                                                    <th>PROVINCIA</th>
                                                    <th>DISTRITO</th>
                                                    <th>RUC</th>
                                                    <th>RAZON SOCIAL</th>
                                                    <th>OPERACIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @foreach ($proveedores->where('categoria',$tipo_servicio->nombre) as $item)
                                                    <tr id="row_lista_asociaciones_{{ $item->id }}">
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            {{ $item->departamento->departamento }}
                                                        </td>
                                                        <td>
                                                            {{ $item->provincia->provincia }}
                                                        </td>
                                                        <td>
                                                            {{ $item->distrito->distrito }}
                                                        </td>
                                                        <td>{{ $item->ruc }}</td>
                                                        <td>{{ $item->razon_social }}</td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#asociacionModal_{{ $item->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                            </a>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="asociacionModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <form action="{{ route('proveedor.editar') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-6">
                                                                                    <label for="ruc">Ruc</label>
                                                                                    <input type="text" class="form-control" id="ruc" name="ruc" aria-describedby="ruc" placeholder="Ruc" value="{{ $item->ruc }}">
                                                                                </div>
                                                                                <div class="form-group col-6">
                                                                                    <label for="razon_social">Razon social</label>
                                                                                    <input type="text" class="form-control" id="razon_social" name="razon_social" aria-describedby="razon_social" placeholder="Razon social" value="{{ $item->razon_social }}">
                                                                                </div>
                                                                                <div class="form-group col-6">
                                                                                    <label for="nombre_comercial">Nombre comercial</label>
                                                                                    <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" aria-describedby="nombre_comercial" placeholder="Nombre comercial" value="{{ $item->nombre_comercial }}">
                                                                                </div>
                                                                                <div class="form-group col-3">
                                                                                    <label for="celular">Celular</label>
                                                                                    <input type="text" class="form-control" id="celular" name="celular" aria-describedby="celular" placeholder="celular" value="{{ $item->celular }}">
                                                                                </div>
                                                                                <div class="form-group col-3">
                                                                                    <label for="telefono">Telefono</label>
                                                                                    <input type="text" class="form-control" id="telefono" name="telefono" aria-describedby="telefono" placeholder="telefono" value="{{ $item->telefono }}">
                                                                                </div>
                                                                                <div class="form-group col-6">
                                                                                    <label for="email">Email</label>
                                                                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="email" value="{{ $item->email }}">
                                                                                </div>
                                                                                <div class="form-group col-6">
                                                                                    <label for="direccion">Direccion</label>
                                                                                    <input type="text" class="form-control" id="direccion" name="direccion" aria-describedby="direccion" placeholder="direccion" value="{{ $item->direccion }}">
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="form-group col-2">
                                                                                            <label for="plazo">Plazo</label>
                                                                                            <input type="number" class="form-control" id="plazo" name="plazo" aria-describedby="plazo" placeholder="plazo" value="{{ $item->plazo }}">
                                                                                        </div>
                                                                                        <div class="form-group col-2">
                                                                                            <label for="plazo">Desc.</label>
                                                                                            <select class="form-control" name="desci" id="desci">
                                                                                                <option value="ANTES">ANTES</option>
                                                                                                <option value="DESPUES">DESPUES</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group col-4">
                                                                                    <label for="departamento">Departamento</label>
                                                                                    <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias($(this).val());">
                                                                                        <option value="0">Escoja una opcion</option>
                                                                                        @foreach ($departamentos as $item_)
                                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->departamento->id)
                                                                                                selected
                                                                                            @endif>{{ $item_->departamento }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-4">
                                                                                    <label for="provincia">Provicia</label>
                                                                                    <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos($(this).val());">
                                                                                        <option value="0">Escoja una opcion</option>
                                                                                        @foreach ($provincias->where('departamento_id',$item->departamento->id) as $item_)
                                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->provincia->id)
                                                                                                selected
                                                                                            @endif>{{ $item_->provincia }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div id="distrito_id" class="form-group col-4">
                                                                                    <label for="distrito">Distrito</label>
                                                                                    <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades($(this).val(),'{{ $item->id }}');">
                                                                                        <option value="0">Escoja una opcion</option>
                                                                                        @foreach ($distritos->where('provincia_id',$item->provincia->id) as $item_)
                                                                                            <option value="{{ $item_->id }}" @if ($item_->id==$item->distrito->id)
                                                                                                selected
                                                                                            @endif>{{ $item_->distrito }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer text-right">
                                                                            {{ csrf_field() }}

                                                                            <input type="hidden" name="categoria" value="{{ $tipo_servicio->nombre}}">
                                                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            </div>
                                                            <a href="#" class="btn btn-danger" onclick="eliminar_proveedor('{{ $item->id }}','{{ $tipo_servicio->nombre }}')"><i class="fas fa-trash-alt"></i></a>
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
                                @php
                                    $active='';
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
