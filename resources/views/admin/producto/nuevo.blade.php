@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('producto.lista') }}">PRODUCTOS</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO PRODUCTO {{ $categoria }}</li>

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('producto.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="col-12">
                                @if(session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        <strong>Genial!</strong> {{ session('success') }}
                                    </div>
                                @elseif(session()->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Ups!</strong> {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-4 card">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="departamento">Departamento</label>
                                                <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias_servicios($(this).val(),'{{ $categoria }}','0','0');" required >
                                                    <option value="0">Escoja una opcion</option>
                                                    @foreach ($departamentos as $item)
                                                        <option value="{{ $item->id }}" @if ($item->id==old('departamento'))
                                                            selected
                                                        @endif>{{ $item->departamento }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 @if($categoria=='GUIA') d-none @endif">
                                                <label for="provincia">Provicia</label>
                                                <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos_servicios($(this).val());" required>
                                                    <option value="0">Escoja una opcion</option>
                                                </select>
                                            </div>
                                            <div id="distrito_id" class="form-group col-6 @if($categoria=='GUIA') d-none @endif">
                                                <label for="distrito">Distrito</label>
                                                <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades_servicios($(this).val(),'0');" required>
                                                    <option value="0">Escoja una opcion</option>
                                                </select>
                                            </div>
                                            <div id="distrito_id" class="form-group col-6 @if($categoria=='GUIA') d-none @endif">
                                                <label for="comunidad">Comunidad</label>
                                                <select class="form-control" name="comunidad" id="comunidad_0" required>
                                                    <option value="0">Escoja una opcion</option>
                                                </select>
                                            </div>
                                            @if($categoria=='TRANSPORTE')
                                            <div class="form-group col-12">
                                                <label for="categoria">Categoria</label>
                                                <select class="form-control" name="categoria" id="categoria" required>
                                                    <option value="AUTO">AUTO</option>
                                                    <option value="H1">H1</option>
                                                    <option value="VAN">VAN</option>
                                                    <option value="SPRINTER CORTA">SPRINTER CORTA</option>
                                                    <option value="SPRINTER LARGA">SPRINTER LARGA</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="ruta_salida">Ruta de salida</label>
                                                <input type="text" class="form-control" id="ruta_salida" name="ruta_salida" value="{{ old('ruta_salida') }}" aria-describedby="ruta_salida" placeholder="Ruta de salida" required>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="ruta_llegada">Ruta de llegada</label>
                                                <input type="text" class="form-control" id="ruta_llegada" name="ruta_llegada" value="{{ old('ruta_llegada') }}" aria-describedby="ruta_llegada" placeholder="Ruta de llegada" required>
                                            </div>
                                            @endif
                                            @if($categoria=='GUIA')
                                            <div class="form-group col-12">
                                                <label for="idioma">Idioma</label>
                                                <select class="form-control" name="idioma" id="idioma" value="{{ old('idioma') }}" required>
                                                    <option value="INGLES">INGLES</option>
                                                </select>
                                            </div>
                                            @endif
                                            <div class="form-group col-6">
                                                <label for="min">Min</label>
                                                <input type="number" class="form-control" id="min" name="min" value="{{ old('min') }}" aria-describedby="min" placeholder="min" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="max">Max</label>
                                                <input type="number" class="form-control" id="max" name="max" value="{{ old('max') }}" aria-describedby="max" placeholder="max" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="precio">Precio</label>
                                                <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" aria-describedby="precio" placeholder="10.00" step="0.01" min="0.00" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="tipo_producto">Tipo precio</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_p" value="PRIVADO" checked="checked">
                                                    <label class="form-check-label" for="tipo_producto_p">
                                                        PRIVADO
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_producto" id="tipo_producto_c" value="COMPARTIDO">
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
                                                    <div id="lista_proveedores_0_0" class="col-12">
                                                        {{-- @foreach ($proveedores as $proveedor)
                                                            <div class="form-check text-primary">
                                                                <input class="form-check-input" type="checkbox" value="{{ $proveedor->id }}_{{ $proveedor->nombre_comercial }}" name="proveedor_0_0[]" id="proveedor_{{ $proveedor->id }}">
                                                                <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
                                                                  {{ $proveedor->nombre_comercial }}
                                                                </label>
                                                            </div>
                                                        @endforeach --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1"><button type="button" class="btn btn-primary" onclick="pasar_datos('proveedor','0','0')"><i class="fas fa-arrow-alt-circle-right"></i></button> </div>
                                            <div class="col-7">
                                                <div class="row">
                                                    <div class="col-12"><p class="text-primary text-15">Lista de proveedores</p></div>
                                                    <div class="col-12" id="lista_proveedores_save_0_0">
                                                        {{--  <div id="lista_proveedores_save_1" class="row">
                                                            <div class="col-7 ">Proveedor</div>
                                                            <div class="col-3 px-0 mx-0">
                                                                <input type="hidden" name="proveedor_id[]" value="1">
                                                                <input class="form-control" type="number" name="precio[]" min="0" step="0.01">
                                                            </div>
                                                            <div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save('1')"><i class="fas fa-trash"></i></button></div>
                                                        </div>  --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <input type="hidden" name="rol" value="{{ $categoria }}">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                                <a href="{{ route('proveedor.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
