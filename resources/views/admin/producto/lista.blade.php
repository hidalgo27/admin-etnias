@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">PRODUCTOS</li>

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
                                        <a href="{{ route('producto.nuevo',$tipo_servicio->nombre) }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <table class="table table-bordered table-hover table-striped table-condensed table-sm text-12">
                                            <thead >
                                                <tr>
                                                    <th>#</th>
                                                    <th>DEPARTAMENTO</th>
                                                    @if($tipo_servicio->nombre=='TRANSPORTE')
                                                    <th>PROVINCIA</th>
                                                    <th>DISTRITO</th>
                                                    <th>COMUNIDAD</th>
                                                    <th>CATEGORIA</th>
                                                    <th>RUTA</th>
                                                    @elseif($tipo_servicio->nombre=='GUIA')
                                                    <th>IDIOMA</th>
                                                    @endif
                                                    <th>CAPACIDAD</th>
                                                    <th>TIPO PRODUCTO</th>
                                                    <th>PRECIO</th>
                                                    <th>PROVEEDORES</th>
                                                    <th>OPERACIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($tipo_servicio->nombre=='TRANSPORTE')
                                                    @php
                                                        $i=1;
                                                    @endphp
                                                    @foreach ($transportes_externo->sortBy('categoria');/*->where('categoria',$tipo_servicio->nombre)*/ as $item)
                                            <tr id="row_lista_productos_{{ $item->id }}_{{$tipo_servicio->id}}">
                                                            <td>{{ $i }}</td>
                                                            <td>
                                                                {!! $item->comunidad->distrito->provincia->departamento->departamento !!}
                                                            </td>
                                                            <td>
                                                                {!! $item->comunidad->distrito->provincia->provincia !!}
                                                            </td>
                                                            <td>
                                                                {!! $item->comunidad->distrito->distrito !!}
                                                            </td>
                                                            <td>
                                                                {!! $item->comunidad->nombre !!}
                                                            </td>
                                                            <td>{{ $item->categoria }}</td>
                                                            <td><i class="fas fa-route text-danger"></i>{{ $item->ruta_salida }} / {{ $item->ruta_llegada }}</td>
                                                            <td><i class="fas fa-user-plus text-primary"></i>[{{ $item->min }}-{{$item->max}}]</td>
                                                            <td>{{ $item->s_p }}</td>
                                                            <td><b class="text-success"><sup>$</sup> {{ number_format($item->precio,2) }}</b></td>
                                                            <td>
                                                                @if ($item->transporte_externo_proveedor->count()==0)
                                                                <span class="text-danger">{{ $item->transporte_externo_proveedor->count() }} <i class="fas fa-male"></i></span>
                                                                @elseif($item->transporte_externo_proveedor->count()>0)
                                                                <span class="text-primary">{{ $item->transporte_externo_proveedor->count() }} <i class="fas fa-male"></i></span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Button trigger modal -->
                                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#asociacionModal_{{$tipo_servicio->id}}_{{ $item->id }}">
                                                                        <i class="fas fa-edit"></i>
                                                                </a>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="asociacionModal_{{$tipo_servicio->id}}_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" style="max-width:1200px" role="document">
                                                                    <form action="{{ route('producto.editar') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                            <div class="col-4 card">
                                                                                                <div class="row">
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="departamento">Departamento</label>
                                                                                                    <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias_productos($(this).val(),'{{ $tipo_servicio->nombre }}','{{$tipo_servicio->id}}','{{$item->id}}');" required >
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($departamentos as $departamento)
                                                                                                                <option value="{{ $departamento->id }}" @if ($departamento->id==$item->comunidad->distrito->provincia->departamento->id )
                                                                                                                    selected
                                                                                                                @endif>{{ $departamento->departamento }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="provincia">Provicia</label>
                                                                                                        <select class="form-control" name="provincia" id="provincia_{{$tipo_servicio->id}}_{{$item->id}}" onchange="mostrar_distritos_productos($(this).val(),'{{$tipo_servicio->id}}','{{$item->id}}');" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($provincias as $provincia)
                                                                                                                <option value="{{ $provincia->id }}" @if ($provincia->id==$item->comunidad->distrito->provincia->id )
                                                                                                                    selected
                                                                                                                @endif>{!! $provincia->provincia !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div id="distrito_id" class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="distrito">Distrito</label>
                                                                                                        <select class="form-control" name="distrito" id="distrito_{{$tipo_servicio->id}}_{{$item->id}}" onchange="mostrar_comunidades_productos($(this).val(),'0','{{$tipo_servicio->id}}','{{$item->id}}');" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($distritos as $distrito)
                                                                                                                <option value="{{ $distrito->id }}" @if ($distrito->id==$item->comunidad->distrito->id )
                                                                                                                    selected
                                                                                                                @endif>{!! $distrito->distrito !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div id="distrito_id" class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="comunidad">Comunidad</label>
                                                                                                        <select class="form-control" name="comunidad" id="comunidad_{{$tipo_servicio->id}}_{{$item->id}}" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($comunidades as $comunidad)
                                                                                                                <option value="{{ $comunidad->id }}" @if ($comunidad->id==$item->comunidad->id )
                                                                                                                    selected
                                                                                                                @endif>{!! $comunidad->nombre !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @if($tipo_servicio->nombre=='TRANSPORTE')
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="categoria">Categoria</label>
                                                                                                        <select class="form-control" name="categoria" id="categoria" required>
                                                                                                            <option value="AUTO" @if($item->categoria=='AUTO') selected @endif>AUTO</option>
                                                                                                            <option value="H1" @if($item->categoria=='H1') selected @endif>H1</option>
                                                                                                            <option value="VAN" @if($item->categoria=='VAN') selected @endif>VAN</option>
                                                                                                            <option value="SPRINTER CORTA" @if($item->categoria=='SPRINTER CORTA') selected @endif>SPRINTER CORTA</option>
                                                                                                            <option value="SPRINTER LARGA" @if($item->categoria=='SPRINTER LARGA') selected @endif>SPRINTER LARGA</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="ruta_salida">Ruta de salida</label>
                                                                                                        <input type="text" class="form-control" id="ruta_salida" name="ruta_salida" value="{{ $item->ruta_salida }}" aria-describedby="ruta_salida" placeholder="Ruta de salida" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="ruta_llegada">Ruta de llegada</label>
                                                                                                        <input type="text" class="form-control" id="ruta_llegada" name="ruta_llegada" value="{{ $item->ruta_llegada }}" aria-describedby="ruta_llegada" placeholder="Ruta de llegada" required>
                                                                                                    </div>
                                                                                                    @endif
                                                                                                    @if($tipo_servicio->nombre=='GUIA')
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="idioma">Idioma</label>
                                                                                                        <select class="form-control" name="idioma" id="idioma" value="{{ old('idioma') }}" required>
                                                                                                            <option value="INGLES">INGLES</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @endif
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="min">Min</label>
                                                                                                        <input type="number" class="form-control" id="min" name="min" value="{{ $item->min }}" aria-describedby="min" placeholder="min" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="max">Max</label>
                                                                                                        <input type="number" class="form-control" id="max" name="max" value="{{ $item->max }}" aria-describedby="max" placeholder="max" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="precio">Precio</label>
                                                                                                        <input type="number" class="form-control" id="precio" name="precio" value="{{ $item->precio }}" aria-describedby="precio" placeholder="10.00" step="0.01" min="0.00" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="tipo_producto">Tipo precio</label>
                                                                                                        <div class="form-check">
                                                                                                            <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_p" value="PRIVADO" @if($item->s_p=='PRIVADO') checked="checked" @endif>
                                                                                                            <label class="form-check-label" for="tipo_producto_p">
                                                                                                                PRIVADO
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div class="form-check">
                                                                                                            <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_c" value="COMPARTIDO" @if($item->s_p=='COMPARTIDO') checked="checked" @endif>
                                                                                                            <label class="form-check-label" for="tipo_producto_c">
                                                                                                                COMPARTIDO
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-8 card">
                                                                                                <div class="row">
                                                                                                    <div class="col-4">
                                                                                                        <div class="row">
                                                                                                            <div class="col-12"><p class="text-primary text-15">Lista de proveedores</p></div>
                                                                                                        <div id="lista_proveedores_{{$tipo_servicio->id}}_{{$item->id}}" class="col-12">
                                                                                                                @foreach ($proveedores->where('categoria',$tipo_servicio->nombre)->where('departamento_id',$item->comunidad->distrito->provincia->departamento->id) as $proveedor)
                                                                                                                    <div class="form-check text-primary">
                                                                                                                        <input class="form-check-input proveedor_{{$tipo_servicio->id}}_{{$item->id}}" type="checkbox" value="{{ $proveedor->id }}_{{ $proveedor->nombre_comercial }}" name="proveedor_{{$tipo_servicio->id}}_{{$item->id}}[]" id="proveedor_{{ $proveedor->id }}">
                                                                                                                        <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
                                                                                                                        {{ $proveedor->nombre_comercial }}
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-1"><button type="button" class="btn btn-primary" onclick="pasar_datos('proveedor','{{$tipo_servicio->id}}','{{$item->id}}')"><i class="fas fa-arrow-alt-circle-right"></i></button> </div>
                                                                                                    <div class="col-7">
                                                                                                        <div class="row">
                                                                                                            <div class="col-12"><p class="text-primary text-15">Lista de proveedores</p></div>
                                                                                                            <div class="col-12" id="lista_proveedores_save_{{$tipo_servicio->id}}_{{$item->id}}">
                                                                                                                @foreach ($item->transporte_externo_proveedor as $te_proveedor)
                                                                                                            <div id="lista_proveedores_saved_{{$tipo_servicio->id}}_{{$item->id}}_{{$te_proveedor->proveedor_id}}" class="row">
                                                                                                                        <div class="col-7 ">{{$te_proveedor->proveedor->nombre_comercial}}</div>
                                                                                                                        <div class="col-3 px-0 mx-0">
                                                                                                                        <input class="c_proveedor_id_{{$tipo_servicio->id}}_{{$item->id}}" type="hidden" name="proveedor_id_a[]" value="{{$te_proveedor->proveedor_id}}">
                                                                                                                                <input type="hidden" name="proveedor_id_d[]" value="{{$te_proveedor->id}}">
                                                                                                                        <input class="form-control" type="number" name="precio_d[]" min="0" step="0.01" value="{{$te_proveedor->precio}}">
                                                                                                                        </div>
                                                                                                                    <div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save_d('{{$tipo_servicio->id}}','{{$item->id}}','{{$te_proveedor->proveedor_id}}')"><i class="fas fa-trash"></i></button></div>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                            </div>
                                                                            <div class="modal-footer text-right">
                                                                                {{ csrf_field() }}
                                                                                <input type="hidden" name="rol" value="{{$tipo_servicio->nombre}}">
                                                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                            <a href="#" class="btn btn-danger" onclick="eliminar_producto('{{ $item->id }}','{{$tipo_servicio->nombre}}','{{$tipo_servicio->id}}')"><i class="fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                @elseif($tipo_servicio->nombre=='GUIA')
                                                    @php
                                                        $i=1;
                                                    @endphp
                                                    @foreach ($guias->sortBy('categoria');/*->where('categoria',$tipo_servicio->nombre)*/ as $item)
                                                    <tr id="row_lista_productos_{{ $item->id }}_{{$tipo_servicio->id}}">
                                                            <td>{{ $i }}</td>
                                                            <td>
                                                                {!! $item->departamento->departamento !!}
                                                            </td>
                                                            <td><i class="fas fa-flag text-primary"></i>{{ $item->idioma }}</td>

                                                            <td><i class="fas fa-user-plus text-primary"></i>[{{ $item->min }}-{{$item->max}}]</td>
                                                            <td>{{ $item->s_p }}</td>
                                                            <td><b class="text-success"><sup>$</sup> {{ number_format($item->precio,2) }}</b></td>
                                                            <td>
                                                                @if ($item->guia_proveedor->count()==0)
                                                                <span class="text-danger">{{ $item->guia_proveedor->count() }} <i class="fas fa-male"></i></span>
                                                                @elseif($item->guia_proveedor->count()>0)
                                                                <span class="text-primary">{{ $item->guia_proveedor->count() }} <i class="fas fa-male"></i></span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Button trigger modal -->
                                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#asociacionModal_{{$tipo_servicio->id}}_{{ $item->id }}">
                                                                        <i class="fas fa-edit"></i>
                                                                </a>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="asociacionModal_{{$tipo_servicio->id}}_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" style="max-width:1200px" role="document">
                                                                    <form action="{{ route('producto.editar') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                            <div class="col-4 card">
                                                                                                <div class="row">
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="departamento">Departamento</label>
                                                                                                    <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias_productos($(this).val(),'{{ $tipo_servicio->nombre }}','{{$tipo_servicio->id}}','{{$item->id}}');" required >
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($departamentos as $departamento)
                                                                                                                <option value="{{ $departamento->id }}" @if ($departamento->id==$item->departamento->id )
                                                                                                                    selected
                                                                                                                @endif>{{ $departamento->departamento }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="provincia">Provicia</label>
                                                                                                        <select class="form-control" name="provincia" id="provincia_{{$tipo_servicio->id}}_{{$item->id}}" onchange="mostrar_distritos_productos($(this).val(),'{{$tipo_servicio->id}}','{{$item->id}}');" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($provincias as $provincia)
                                                                                                                <option value="{{ $provincia->id }}">{!! $provincia->provincia !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div id="distrito_id" class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="distrito">Distrito</label>
                                                                                                        <select class="form-control" name="distrito" id="distrito_{{$tipo_servicio->id}}_{{$item->id}}" onchange="mostrar_comunidades_productos($(this).val(),'0','{{$tipo_servicio->id}}','{{$item->id}}');" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($distritos as $distrito)
                                                                                                                <option value="{{ $distrito->id }}" >{!! $distrito->distrito !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div id="distrito_id" class="form-group col-6 @if($tipo_servicio->nombre=='GUIA') d-none @endif">
                                                                                                        <label for="comunidad">Comunidad</label>
                                                                                                        <select class="form-control" name="comunidad" id="comunidad_{{$tipo_servicio->id}}_{{$item->id}}" required>
                                                                                                            <option value="0">Escoja una opcion</option>
                                                                                                            @foreach ($comunidades as $comunidad)
                                                                                                                <option value="{{ $comunidad->id }}">{!! $comunidad->nombre !!}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @if($tipo_servicio->nombre=='TRANSPORTE')
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="categoria">Categoria</label>
                                                                                                        <select class="form-control" name="categoria" id="categoria" required>
                                                                                                            <option value="AUTO" @if($item->categoria=='AUTO') selected @endif>AUTO</option>
                                                                                                            <option value="H1" @if($item->categoria=='H1') selected @endif>H1</option>
                                                                                                            <option value="VAN" @if($item->categoria=='VAN') selected @endif>VAN</option>
                                                                                                            <option value="SPRINTER CORTA" @if($item->categoria=='SPRINTER CORTA') selected @endif>SPRINTER CORTA</option>
                                                                                                            <option value="SPRINTER LARGA" @if($item->categoria=='SPRINTER LARGA') selected @endif>SPRINTER LARGA</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="ruta_salida">Ruta de salida</label>
                                                                                                        <input type="text" class="form-control" id="ruta_salida" name="ruta_salida" value="{{ $item->ruta_salida }}" aria-describedby="ruta_salida" placeholder="Ruta de salida" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="ruta_llegada">Ruta de llegada</label>
                                                                                                        <input type="text" class="form-control" id="ruta_llegada" name="ruta_llegada" value="{{ $item->ruta_llegada }}" aria-describedby="ruta_llegada" placeholder="Ruta de llegada" required>
                                                                                                    </div>
                                                                                                    @endif
                                                                                                    @if($tipo_servicio->nombre=='GUIA')
                                                                                                    <div class="form-group col-12">
                                                                                                        <label for="idioma">Idioma</label>
                                                                                                        <select class="form-control" name="idioma" id="idioma" value="{{ old('idioma') }}" required>
                                                                                                            <option value="INGLES">INGLES</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    @endif
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="min">Min</label>
                                                                                                        <input type="number" class="form-control" id="min" name="min" value="{{ $item->min }}" aria-describedby="min" placeholder="min" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="max">Max</label>
                                                                                                        <input type="number" class="form-control" id="max" name="max" value="{{ $item->max }}" aria-describedby="max" placeholder="max" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="precio">Precio</label>
                                                                                                        <input type="number" class="form-control" id="precio" name="precio" value="{{ $item->precio }}" aria-describedby="precio" placeholder="10.00" step="0.01" min="0.00" required>
                                                                                                    </div>
                                                                                                    <div class="form-group col-6">
                                                                                                        <label for="tipo_producto">Tipo precio</label>
                                                                                                        <div class="form-check">
                                                                                                            <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_p" value="PRIVADO" @if($item->s_p=='PRIVADO') checked="checked" @endif>
                                                                                                            <label class="form-check-label" for="tipo_producto_p">
                                                                                                                PRIVADO
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div class="form-check">
                                                                                                            <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_c" value="COMPARTIDO" @if($item->s_p=='COMPARTIDO') checked="checked" @endif>
                                                                                                            <label class="form-check-label" for="tipo_producto_c">
                                                                                                                COMPARTIDO
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-8 card">
                                                                                                <div class="row">
                                                                                                    <div class="col-4">
                                                                                                        <div class="row">
                                                                                                            <div class="col-12"><p class="text-primary text-15">Lista de proveedores</p></div>
                                                                                                        <div id="lista_proveedores_{{$tipo_servicio->id}}_{{$item->id}}" class="col-12">
                                                                                                                @foreach ($proveedores->where('categoria',$tipo_servicio->nombre)->where('departamento_id',$item->departamento->id) as $proveedor)
                                                                                                                    <div class="form-check text-primary">
                                                                                                                        <input class="form-check-input proveedor_{{$tipo_servicio->id}}_{{$item->id}}" type="checkbox" value="{{ $proveedor->id }}_{{ $proveedor->nombre_comercial }}" name="proveedor_{{$tipo_servicio->id}}_{{$item->id}}[]" id="proveedor_{{ $proveedor->id }}">
                                                                                                                        <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
                                                                                                                        {{ $proveedor->nombre_comercial }}
                                                                                                                        </label>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-1"><button type="button" class="btn btn-primary" onclick="pasar_datos('proveedor','{{$tipo_servicio->id}}','{{$item->id}}')"><i class="fas fa-arrow-alt-circle-right"></i></button> </div>
                                                                                                    <div class="col-7">
                                                                                                        <div class="row">
                                                                                                            <div class="col-12"><p class="text-primary text-15">Lista de proveedores</p></div>
                                                                                                            <div class="col-12" id="lista_proveedores_save_{{$tipo_servicio->id}}_{{$item->id}}">
                                                                                                                @foreach ($item->guia_proveedor as $te_proveedor)
                                                                                                            <div id="lista_proveedores_saved_{{$tipo_servicio->id}}_{{$item->id}}_{{$te_proveedor->proveedor_id}}" class="row">
                                                                                                                        <div class="col-7 ">{{$te_proveedor->proveedor->nombre_comercial}}</div>
                                                                                                                        <div class="col-3 px-0 mx-0">
                                                                                                                        <input class="c_proveedor_id_{{$tipo_servicio->id}}_{{$item->id}}" type="hidden" name="proveedor_id_a[]" value="{{$te_proveedor->proveedor_id}}">
                                                                                                                                <input type="hidden" name="proveedor_id_d[]" value="{{$te_proveedor->id}}">
                                                                                                                        <input class="form-control" type="number" name="precio_d[]" min="0" step="0.01" value="{{$te_proveedor->precio}}">
                                                                                                                        </div>
                                                                                                                    <div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save_d('{{$tipo_servicio->id}}','{{$item->id}}','{{$te_proveedor->proveedor_id}}')"><i class="fas fa-trash"></i></button></div>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                            </div>
                                                                            <div class="modal-footer text-right">
                                                                                {{ csrf_field() }}
                                                                                <input type="hidden" name="rol" value="{{$tipo_servicio->nombre}}">
                                                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                            <a href="#" class="btn btn-danger" onclick="eliminar_producto('{{ $item->id }}','{{$tipo_servicio->nombre}}','{{$tipo_servicio->id}}')"><i class="fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                @endif
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
