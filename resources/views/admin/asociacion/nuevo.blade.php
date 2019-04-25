@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
@if(Auth::user()->hasRole('admin'))
    <li class="breadcrumb-item"><a href="{{ route('asociacion.lista') }}">ASOCIACIONES</a></li>
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
                        <b class="text-primary text-15">NUEVA ASOCIACION</b>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('asociacion.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="ruc">Ruc</label>
                                        <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc') }}" aria-describedby="nombre" placeholder="Ruc" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="Razon social" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="contacto">Contacto</label>
                                        <input type="text" class="form-control" id="contacto" name="contacto" value="{{ old('contacto') }}" aria-describedby="contacto" placeholder="Nombre del contacto" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="celular">celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular') }}" aria-describedby="celular" placeholder="Numero del celular" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="email">email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" aria-describedby="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" aria-describedby="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Re password</label>
                                        <input type="password" class="form-control" id="repassword" name="repassword" value="{{ old('repassword') }}" aria-describedby="repassword" placeholder="Re password" required>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" aria-describedby="direccion" placeholder="Numero del direccion" required>
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
                                        <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades($(this).val(),'0');">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                    <div id="distrito_id" class="form-group col-4">
                                        <label for="comunidad">Comunidad</label>
                                        <select class="form-control" name="comunidad" id="comunidad_0">
                                            <option value="0">Escoja una opcion</option>
                                        </select>
                                    </div>
                                    <div  class="form-group col-2">
                                        <label for="comision">Comision</label>
                                        <input class="form-control" type="number" name="comision" id="comision" value="" min="0" max="100" step="0.01" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="portada">Portada</label>
                                                <input type="file" name="portada" id="portada" class="form-control">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="miniatura">Miniatura</label>
                                                <input type="file" name="miniatura" id="miniatura" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="foto">Galeria de fotos</label>
                                        <input type="file" name="foto[]" multiple class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control descripcion"  cols="30" rows="10" required >{{ old('descripcion') }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 text-right">
                                {{ csrf_field() }}
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> GUARDAR</button>
                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
