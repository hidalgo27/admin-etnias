@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
@if(Auth::user()->hasRole('admin'))
<li class="breadcrumb-item"><a href="{{ route('asociacion.lista') }}">ASOCIACIONES</a></li>
<li class="breadcrumb-item"><a href="{{ route('servicios.lista',$asociacion->id) }}">SERVICIOS</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@elseif(Auth::user()->hasRole('asociacion'))
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@endif
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <b class="text-primary text-15">NUEVOS SERVICIOS</b>
                    </div>
                    <div class="col-12">
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
                                <div class="col-12 mb-3 d-none">
                                    <label for="validationCustomUsername">Asociacion</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">Ruc/Razon social</span>
                                        </div>
                                        <input type="text" class="form-control" id="ruc_rs" placeholder="Ruc/Razon social" aria-describedby="ruc_rs">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-primary" onclick="buscar_asociacion($('#ruc_rs').val())"><i class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="asociacion" class="col-12">
                                    <div class="alert alert-primary">
                                        Ruc: <b>{{ $asociacion->ruc }}</b> | Razon social: <b>{{ $asociacion->nombre }} </b>
                                        <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="{{ $asociacion->id}}" form="form_a_n_0">
                                        <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="{{ $asociacion->id}}" form="form_c_n_0">
                                        <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="{{ $asociacion->id}}" form="form_h_n_0">
                                        <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="{{ $asociacion->id}}" form="form_t_n_0">
                                        <input type="hidden" name="s_asociacion_id" id="s_asociacion_id" value="{{ $asociacion->id}}" form="form_s_n_0">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-actividades-tab" data-toggle="tab" href="#nav-actividades" role="tab" aria-controls="nav-actividades" aria-selected="true">ACTIVIDADES</a>
                                            <a class="nav-item nav-link" id="nav-comidas-tab" data-toggle="tab" href="#nav-comidas" role="tab" aria-controls="nav-comidas" aria-selected="false">COMIDAS</a>
                                            <a class="nav-item nav-link" id="nav-hospedaje-tab" data-toggle="tab" href="#nav-hospedaje" role="tab" aria-controls="nav-hospedaje" aria-selected="false">HOSPEDAJE</a>
                                            {{-- <a class="nav-item nav-link" id="nav-transporte-tab" data-toggle="tab" href="#nav-transporte" role="tab" aria-controls="nav-transporte" aria-selected="false">TRANSPORTE</a>
                                            <a class="nav-item nav-link" id="nav-servicios-tab" data-toggle="tab" href="#nav-servicios" role="tab" aria-controls="nav-servicios" aria-selected="false">SERVICIOS</a> --}}
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-actividades" role="tabpanel" aria-labelledby="nav-actividades-tab">
                                            <form id="form_a_n_0" class="card card-body px-1" action="{{ route('servicios.actividad.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="form-group col-12">
                                                        <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                    </div>
                                                    <div class="col-8 my-1">
                                                        <label class="sr-only" for="titulo_a_n_0">Titulo</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Titulo</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="titulo_a_n_0" name="titulo" placeholder="Titulo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-1">
                                                        <label class="sr-only" for="categoria_a_n_0">Categoria</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Categoria</div>
                                                            </div>
                                                            <select name="categoria_" id="categoria_a_n_0" class="form-control">
                                                                @foreach ($categorias as $item)
                                                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="descripcion_a_n_0">Descripcion</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Descripcion</div>
                                                            </div>
                                                            <textarea class="form-control descripcion" name="descripcion" id="descripcion_a_n_0" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 my-1">
                                                        <label class="sr-only" for="duracion_a_n_0">Duracion</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Duracion</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="duracion_a_n_0" name="duracion" placeholder="Ejm. 3 horas" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 my-1">
                                                        <label class="sr-only" for="periodo_a_n_0">Periodo</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Periodo</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="periodo_a_n_0" name="periodo" placeholder="Ejm. Todo el año" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-1">
                                                        <label class="sr-only" for="edad_minima_a_n_0">Edad minima</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Edad minima</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="edad_minima_a_n_0" name="edad_minima" placeholder="Ejm. 7 años" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-1">
                                                        <label class="sr-only" for="dificultad_a_n_0">Dificultad</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Dificultad</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="dificultad_a_n_0" name="dificultad" placeholder="Ejm. Facil" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-1">
                                                        <label class="sr-only" for="tolerancia_a_n_0">Tolerancia</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Tolerancia</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="tolerancia_a_n_0" name="tolerancia" placeholder="Ejm. 20 minutos" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="form-group my-0 py-0">
                                                                    <div class="btn-group">
                                                                        <label for="id_comida" class="btn btn-primary">
                                                                            <span class="glyphicon glyphicon-ok"></span>
                                                                            <span>
                                                                                <input type="checkbox" name="id_comida" id="id_comida" autocomplete="off" />
                                                                            </span>
                                                                        </label>
                                                                        <label for="id_comida" class="btn btn-primary active">
                                                                            Comida
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group my-0 py-0">
                                                                    <div class="btn-group">
                                                                        <label for="id_hospedaje" class="btn btn-primary">
                                                                            <span class="glyphicon glyphicon-ok"></span>
                                                                            <span>
                                                                                <input type="checkbox" name="id_hospedaje" id="id_hospedaje" autocomplete="off" />
                                                                            </span>
                                                                        </label>
                                                                        <label for="id_hospedaje" class="btn btn-primary active">
                                                                            Hospedaje
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group my-0 py-0">
                                                                    <div class="btn-group">
                                                                        <label for="id_transporte" class="btn btn-primary">
                                                                            <span class="glyphicon glyphicon-ok"></span>
                                                                            <span>
                                                                                <input type="checkbox" name="id_transporte" id="id_transporte" autocomplete="off" />
                                                                            </span>
                                                                        </label>
                                                                        <label for="id_transporte" class="btn btn-primary active">
                                                                            Transporte
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="incluye_a_n_0">incluye</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">incluye</div>
                                                            </div>
                                                            <textarea class="form-control descripcion" name="incluye" id="incluye_a_n_0" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="no_incluye_a_n_0">No incluye</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">No incluye</div>
                                                            </div>
                                                            <textarea class="form-control descripcion" name="no_incluye" id="no_incluye_a_n_0" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="disponible_a_n_0">Idioma disponible</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Idioma disponible</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="disponible_a_n_0" name="disponible" placeholder="Ingles, Español" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="recomendaciones_a_n_0">Recomendaciones</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Recomendaciones</div>
                                                            </div>
                                                            <textarea class="form-control descripcion" name="recomendaciones" id="recomendaciones_a_n_0" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 my-1">
                                                        <label class="sr-only" for="inlineFormInputGroupUsername">Portada</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Portada <span class="text-danger">(1770x900 px)</span></div>
                                                            </div>
                                                            <input type="file" id="foto_portada_e_a_n_0" name="foto_portada" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 my-1">
                                                        <label class="sr-only" for="inlineFormInputGroupUsername">Miniatura</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Miniatura <span class="text-danger">(550x345 px)</span></div>
                                                            </div>
                                                            <input type="file" id="foto_miniatura_a_n_0" name="foto_miniatura" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-1">
                                                        <label class="sr-only" for="inlineFormInputGroupUsername">Galeria de fotos</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Galeria de fotos <span class="text-danger">(1280x665 px)</span></div>
                                                            </div>
                                                            <input type="file" id="foto_a_n_0" name="foto[]" multiple class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                    </div>
                                                </div>
                                                <table class="table table-hover table-responsive table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Min</th>
                                                            <th>Max</th>
                                                            <th>Precio</th>
                                                            <th>Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="a_precios_0">
                                                        <tr id="row_a_precios_0_1">
                                                            <td>
                                                                <select class="form-control" name="categoria_n[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_a_n_0[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_a_n_0[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_a_n_0[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('a')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <input type="hidden" id="cantidad_precios_a_0" value="1">
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('a','0')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="a">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('a','n_0')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('servicios.lista',$asociacion->id) }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_a_n_0"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-comidas" role="tabpanel" aria-labelledby="nav-comidas-tab">
                                            <form id="form_c_n_0" class="card card-body" action="{{ route('servicios.comidas.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Comida</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Comida</div>
                                                        </div>
                                                        <select class="form-control" name="titulo" id="titulo_c_n_0">
                                                            <option value="DESAYUNO">DESAYUNO</option>
                                                            <option value="ALMUERZO">ALMUERZO</option>
                                                            <option value="CENA">CENA</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control descripcion" name="descripcion" id="descripcion_c_n_0" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Fotos</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Fotos</div>
                                                        </div>
                                                        <input type="file" name="foto[]" multiple class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <table class="table table-hover table-responsive table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Min</th>
                                                            <th>Max</th>
                                                            <th>Precio</th>
                                                            <th>Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="c_precios_0">
                                                        <tr id="row_c_precios_0_1">
                                                            <td>
                                                                <select class="form-control" name="categoria_n[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                    <option value="Agencia">Agencia</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_c_n_0[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_c_n_0[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_c_n_0[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('c')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <input type="hidden" id="cantidad_precios_c_0" value="1">
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('c','0')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="c">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('c','n_0')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('servicios.lista',$asociacion->id) }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_c_n_0"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-hospedaje" role="tabpanel" aria-labelledby="nav-hospedaje-tab">
                                            <form id="form_h_n_0" class="card card-body" action="{{ route('servicios.hospedaje.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_h_n_0" class="form-control" value="PERNOCTE" disabled='disabled'>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control descripcion" name="descripcion" id="descripcion_h_n_0" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Fotos</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Fotos</div>
                                                        </div>
                                                        <input type="file" name="foto[]" multiple class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <table class="table table-hover table-responsive table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Min</th>
                                                            <th>Max</th>
                                                            <th>Precio</th>
                                                            <th>Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="h_precios_0">
                                                        <tr id="row_h_precios_0_1">
                                                            <td>
                                                                <select class="form-control" name="categoria_n[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_h_n_0[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_h_n_0[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_h_n_0[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('h')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <input type="hidden" id="cantidad_precios_h_0" value="1">
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('h','0')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="h">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('h','n_0')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('servicios.lista',$asociacion->id) }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_h_n_0"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-transporte" role="tabpanel" aria-labelledby="nav-transporte-tab">
                                            <form id="form_t_n_0" class="card card-body" action="{{ route('servicios.transporte.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Ruta</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Ruta</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_t_n_0" class="form-control" placeholder="Hotel / Lugar donde queda la asociacion">
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control descripcion" name="descripcion" id="descripcion_t_n_0" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Fotos</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Fotos</div>
                                                        </div>
                                                        <input type="file" name="foto[]" multiple class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <table class="table table-hover table-responsive table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Min</th>
                                                            <th>Max</th>
                                                            <th>Precio</th>
                                                            <th>Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="t_precios_0">
                                                        <tr id="row_t_precios_0_1">
                                                            <td>
                                                                <select class="form-control" name="categoria_n[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_t_n_0[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_t_n_0[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_t_n_0[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('t')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <input type="hidden" id="cantidad_precios_t_0" value="1">
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('t','0')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="t">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('t','n_0')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('servicios.lista',$asociacion->id) }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_t_n_0"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-servicios" role="tabpanel" aria-labelledby="nav-servicios-tab">
                                            <form id="form_s_n_0" class="card card-body" action="{{ route('servicios.servicio.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_s_n_0" class="form-control" placeholder="Servicio adicional">
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control descripcion" name="descripcion" id="descripcion_s_n_0" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Fotos</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Fotos</div>
                                                        </div>
                                                        <input type="file" name="foto[]" multiple class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <table class="table table-hover table-responsive table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Min</th>
                                                            <th>Max</th>
                                                            <th>Precio</th>
                                                            <th>Operaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="s_precios_0">
                                                        <tr id="row_s_precios_0_1">
                                                            <td>
                                                                <select class="form-control" name="categoria_n[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_s_n_0[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_s_n_0[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_s_n_0[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('s')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('s','0')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="s">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('s','n_0')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('servicios.lista',$asociacion->id) }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_s_n_0"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
