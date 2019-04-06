@extends('layouts.app-admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
                <li class="breadcrumb-item active" aria-current="page">SERVICIOS</li>
            </ol>
        </nav>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Ruc/Razon social</span>
                                    </div>
                                    <input type="text" class="form-control" id="ruc_rs" placeholder="Ruc/Razon social" aria-describedby="ruc_rs">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-primary" onclick="buscar_servicios($('#ruc_rs').val())"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('servicios.nuevo') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR SERVICIOS</a>
                            </div>
                        </div>
                    </div>

                    <div id="servicios" class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped d-none">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
