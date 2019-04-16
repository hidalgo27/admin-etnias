@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('proveedor.lista') }}">PROVEEDORES</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <b class="text-primary text-15">NUEVO PROVEEDOR DE {{$categoria}}</b>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('proveedor.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="form-group col-6">
                                        <label for="ruc">Ruc</label>
                                        <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc') }}" aria-describedby="nombre" placeholder="Ruc" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="razon_social">Razon social</label>
                                        <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ old('razon_social') }}" aria-describedby="razon_social" placeholder="Razon social" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nombre_comercial">Nombre comercial</label>
                                        <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" value="{{ old('nombre_comercial') }}" aria-describedby="nombre_comercial" placeholder="Nombre comercial" required>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="celular">celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular') }}" aria-describedby="celular" placeholder="Numero del celular" required>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="telefono">Telefono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" aria-describedby="telefono" placeholder="Numero del telefono" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" aria-describedby="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" aria-describedby="direccion" placeholder="Numero del direccion" required>
                                    </div>
                                    <div class="col-12">
                                            <div class="row">
                                                <div class="form-group col-2">
                                                    <label for="plazo">Plazo</label>
                                                    <input type="number" class="form-control" id="plazo" name="plazo" aria-describedby="plazo" placeholder="plazo" required>
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
                                        <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias_servicios($(this).val());">
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
                                        <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos_servicios($(this).val());">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                    <div id="distrito_id" class="form-group col-4">
                                        <label for="distrito">Distrito</label>
                                        <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades_servicios($(this).val(),'0');">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <input type="hidden" name="categoria" value="{{ $categoria }}">
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
