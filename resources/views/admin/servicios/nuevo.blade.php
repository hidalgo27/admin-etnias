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
                                            <form class="card card-body" action="">
                                                <div class="form-group col-12">
                                                    <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Titulo</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo">
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Descripcion</div>
                                                        </div>
                                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 my-1">
                                                    <label class="sr-only" for="inlineFormInputGroupUsername">Fotos</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Fotos</div>
                                                        </div>
                                                        <input type="file" class="form-control" name="foto" id="foto" multiple>
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
                                                    <tbody id="actividad_precios">
                                                        <tr id="row_actividad_precios_0">
                                                            <td>
                                                                <select class="form-control" name="categoria" id="categoria">
                                                                    <option value="Nacional">Nacional</option>
                                                                    <option value="Extranjero">Extranjero</option>
                                                                    <option value="Agencia">Agencia</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo" id="minimo">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo" id="maximo">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio" id="precio">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" onclick="borrar_precio_actividad()"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success" type="button" onclick="agregar_precio_actividad()"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </form>

                                        </div>
                                        <div class="tab-pane fade" id="nav-comidas" role="tabpanel" aria-labelledby="nav-comidas-tab">comidas...</div>
                                        <div class="tab-pane fade" id="nav-hospedaje" role="tabpanel" aria-labelledby="nav-hospedaje-tab">hospedaje...</div>
                                        <div class="tab-pane fade" id="nav-transorte" role="tabpanel" aria-labelledby="nav-transorte-tab">transporte...</div>
                                        <div class="tab-pane fade" id="nav-servicios" role="tabpanel" aria-labelledby="nav-servicios-tab">servicios...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            {{ csrf_field() }}
                            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                            <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
