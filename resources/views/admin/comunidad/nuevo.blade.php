@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('comunidad_lista_path') }}">COMUNIDADES</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <b class="text-primary text-15">NUEVA COMUNIDAD</b>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('comunidad_store_path') }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="form-group col-12">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="COMUNIDAD DE ..." required>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="departamento">Departamento</label>
                                        <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias($(this).val());">
                                            <option value="0">Escoja una opcion</option>
                                            @foreach ($departamentos as $item)
                                                <option value="{{ $item->id }}" @if ($item->id==old('departamento'))
                                                    selected
                                                @endif>{{ $item->departamento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="provincia">Provicia</label>
                                        <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos($(this).val());">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                    <div id="distrito_id" class="form-group col-4">
                                        <label for="distrito">Distrito</label>
                                        <select class="form-control" name="distrito" id="distrito">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="altura">Altura</label>
                                        <input type="text" class="form-control" id="altura" name="altura" value="{{ old('altura') }}" aria-describedby="altura" placeholder="3420 msnm" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="distancia">Distancia</label>
                                        <input type="text" class="form-control" id="distancia" name="distancia" value="{{ old('distancia') }}" aria-describedby="distancia" placeholder="2 horas de la ciudad del Cusco" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea  id="basic-example" class="form-control descripcion" name="descripcion" id="descripcion" cols="30" rows="10">{{ old('descripcion') }}</textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="historia">Historia</label>
                                        <textarea class="form-control descripcion" name="historia" id="historia" cols="30" rows="10">{{ old('historia') }}</textarea>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="foto">Portada</label>
                                        <input type="file" name="portada" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="miniatura">Miniatura</label>
                                        <input type="file" name="miniatura" class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="foto">Galeria de fotos</label>
                                        <input type="file" name="foto[]" multiple class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                                <a href="{{ route('comunidad_lista_path') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
