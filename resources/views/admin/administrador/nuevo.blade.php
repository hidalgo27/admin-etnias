@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item"><a href="{{ route('administrador_lista_path') }}">ADMINISTRADORES</a></li>
<li class="breadcrumb-item active" aria-current="page">NUEVO</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <b class="text-primary text-15">NUEVO ADMINISTRADOR</b>
                    </div>
                    <div class="col-12">
                        <form action="{{route('administrador_store_path') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" aria-describedby="nombre" placeholder="NOMBRE ..." required>
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular') }}" aria-describedby="celular" placeholder="974325658" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" aria-describedby="email" placeholder="micorreo@empresa.com" required>
                                    </div>
                                    <div class="form-group col-6">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="password" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group col-6">
                                            <label for="password_2">Re-password</label>
                                            <input type="password" class="form-control" id="password_2" name="re_password" aria-describedby="password" placeholder="password" value="{{ old('re_password') }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="email">
                                        <input type="radio" class="form-control" id="estado_1" name="estado" value="1" checked="checked">
                                        Activo</label>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="email">
                                        <input type="radio" class="form-control" id="estado_0" name="estado" value="0" >
                                        Suspendido</label>
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
