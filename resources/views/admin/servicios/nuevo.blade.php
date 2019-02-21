@extends('layouts.app-admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
                <li class="breadcrumb-item"><a href="{{ route('asociacion.lista') }}">SERVICIOS</a></li>
                <li class="breadcrumb-item active" aria-current="page">NUEVO</li>
            </ol>
        </nav>
    </div>
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
                                <div class="col-12 mb-3">
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
                                    <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="" form="form_a">
                                    <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="" form="form_c">
                                    <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="" form="form_h">
                                    <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="" form="form_t">
                                    <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="" form="form_s">

                                </div>
                                <div class="col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-actividades-tab" data-toggle="tab" href="#nav-actividades" role="tab" aria-controls="nav-actividades" aria-selected="true">ACTIVIDADES</a>
                                            <a class="nav-item nav-link" id="nav-comidas-tab" data-toggle="tab" href="#nav-comidas" role="tab" aria-controls="nav-comidas" aria-selected="false">COMIDAS</a>
                                            <a class="nav-item nav-link" id="nav-hospedaje-tab" data-toggle="tab" href="#nav-hospedaje" role="tab" aria-controls="nav-hospedaje" aria-selected="false">HOSPEDAJE</a>
                                            <a class="nav-item nav-link" id="nav-transporte-tab" data-toggle="tab" href="#nav-transporte" role="tab" aria-controls="nav-transporte" aria-selected="false">TRANSPORTE</a>
                                            <a class="nav-item nav-link" id="nav-servicios-tab" data-toggle="tab" href="#nav-servicios" role="tab" aria-controls="nav-servicios" aria-selected="false">SERVICIOS</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-actividades" role="tabpanel" aria-labelledby="nav-actividades-tab">
                                            <form id="form_a" class="card card-body" action="{{ route('servicios.actividad.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="titulo_a" name="titulo" placeholder="Titulo" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_a" cols="30" rows="10"></textarea>
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
                                                    <tbody id="a_precios">
                                                        <tr id="row_a_precios_1">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_a[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_a[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_a[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('a')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('a')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="a">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('a')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_a"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-comidas" role="tabpanel" aria-labelledby="nav-comidas-tab">
                                            <form id="form_c" class="card card-body" action="{{ route('servicios.comidas.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Comida</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Comida</div>
                                                        </div>
                                                        <select class="form-control" name="titulo" id="titulo_c">
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
                                                        <textarea class="form-control" name="descripcion" id="descripcion_c" cols="30" rows="10"></textarea>
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
                                                    <tbody id="c_precios">
                                                        <tr id="row_c_precios_1">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                    <option value="Agencia">Agencia</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_c[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_c[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_c[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('c')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('c')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="c">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('c')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_c"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-hospedaje" role="tabpanel" aria-labelledby="nav-hospedaje-tab">
                                            <form id="form_h" class="card card-body" action="{{ route('servicios.hospedaje.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_h" class="form-control" value="PERNOCTE" disabled='disabled'>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_h" cols="30" rows="10"></textarea>
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
                                                    <tbody id="h_precios">
                                                        <tr id="row_h_precios_1">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_h[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_h[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_h[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('h')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('h')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="h">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('h')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_h"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-transporte" role="tabpanel" aria-labelledby="nav-transporte-tab">
                                            <form id="form_t" class="card card-body" action="{{ route('servicios.transporte.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Ruta</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Ruta</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_t" class="form-control" placeholder="Hotel / Lugar donde queda la asociacion">
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_t" cols="30" rows="10"></textarea>
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
                                                    <tbody id="t_precios">
                                                        <tr id="row_t_precios_1">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_t[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_t[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_t[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('t')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('t')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="t">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('t')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_t"></div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-servicios" role="tabpanel" aria-labelledby="nav-servicios-tab">
                                            <form id="form_s" class="card card-body" action="{{ route('servicios.servicio.store') }}" method="POST" enctype="multipart/form-data">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" name="titulo" id="titulo_s" class="form-control" placeholder="Servicio adicional">
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_s" cols="30" rows="10"></textarea>
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
                                                    <tbody id="s_precios">
                                                        <tr id="row_s_precios_1">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_s[]" id="minimo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_s[]" id="maximo" required>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_s[]" id="precio" required>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('s')" disabled><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio('s')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="col-12">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="attributo" value="s">
                                                    <button class="btn btn-primary" type="button" onclick="enviar_datos('s')"><i class="fas fa-save"></i> GUARDAR</button>
                                                    <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                                </div>
                                                <div class="col-12" id="rpt_form_s"></div>
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
