@extends('layouts.app-admin')

@section('content')
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">RESERVAS</a></li>
                <li class="breadcrumb-item active" aria-current="page">LISTA</li>
            </ol>
        </nav>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <div class="row">
            <div class="col-4 border border-danger">
                <div class="row bg-danger">
                    <div class="col-3 px-0 pt-2 text-center"><b class="text-white">NUEVO</b></div>
                    <div class="col-8 px-0">
                        <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'nuevo')">
                            <option value="codigo">Codigo</option>
                            <option value="nombre">Nombre</option>
                            <option value="fechas">Entre fechas</option>
                            <option value="mes_anio">mm-aaaa</option>
                        </select>
                    </div>
                </div>
                <div class="row ">
                    <div id="codigo_nuevo" class="col-12 px-0">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Codigo</div>
                            </div>
                            <input type="text" class="form-control" id="codigo" placeholder="Codigo">
                        </div>
                    </div>
                    <div id="nombre_nuevo" class="col-12 px-0 d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Codigo</div>
                            </div>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                        </div>
                    </div>
                    <div id="fechas_nuevo" class="col-12 px-0 form-inline d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">D</div>
                            </div>
                            <input type="date" class="form-control" id="codigo" placeholder="Codigo">

                            <div class="input-group-prepend">
                                <div class="input-group-text">H</div>
                            </div>
                            <input type="date" class="form-control" id="codigo" placeholder="Codigo">
                        </div>
                    </div>
                    <div id="mes_anio_nuevo" class="col-12 px-0 d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Mes</div>
                            </div>
                            <input type="text" class="form-control" id="mes" placeholder="mm">
                            <div class="input-group-prepend">
                                    <div class="input-group-text">Año</div>
                            </div>
                            <input type="text" class="form-control" id="anio" placeholder="aaaa">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @foreach ($reservas_new->sortBy('fecha_llegada') as $item)
                            <div class="row reserva-caja">
                                <div class="col-1 px-0 text-center">
                                    <b class="text-success">{{ $item->codigo }}</b>
                                </div>
                                <div class="col-6 px-0 text-center">
                                    <a href="{{ route('reserva.detalle',$item->id) }}" class=" text-decoration-none"><b class="text-primary">{{ $item->nombre }}</b></a>
                                </div>
                                <div class="col-1 px-0 text-center bg-danger">
                                    <b class="text-white">{{ $item->nro_pax }}</b>
                                </div>
                                <div class="col-4 px-0 text-center  bg-secondary">
                                    <b class="text-white">{{ $item->fecha_llegada }}</b>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-4 border border-primary">
                <div class="row bg-primary">
                    <div class="col-3 px-0 pt-2 text-center"><b class="text-white">ACTUAL</b></div>
                    <div class="col-8 px-0">
                        <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'actual')">
                            <option value="codigo">Codigo</option>
                            <option value="nombre">Nombre</option>
                            <option value="fechas">Entre fechas</option>
                            <option value="mes_anio">mm-aaaa</option>
                        </select>
                    </div>
                    </div>
                    <div class="row ">
                        <div id="codigo_actual" class="col-12 px-0">
                            <div class="input-group px-0 mx-0">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Codigo</div>
                                </div>
                                <input type="text" class="form-control" id="codigo" placeholder="Codigo">
                            </div>
                        </div>
                        <div id="nombre_actual" class="col-12 px-0 d-none">
                            <div class="input-group px-0 mx-0">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Codigo</div>
                                </div>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div id="fechas_actual" class="col-12 px-0 form-inline d-none">
                            <div class="input-group px-0 mx-0">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">D</div>
                                </div>
                                <input type="date" class="form-control" id="codigo" placeholder="Codigo">

                                <div class="input-group-prepend">
                                    <div class="input-group-text">H</div>
                                </div>
                                <input type="date" class="form-control" id="codigo" placeholder="Codigo">
                            </div>
                        </div>
                        <div id="mes_anio_actual" class="col-12 px-0 d-none">
                            <div class="input-group px-0 mx-0">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Mes</div>
                                </div>
                                <input type="text" class="form-control" id="mes" placeholder="mm">
                                <div class="input-group-prepend">
                                        <div class="input-group-text">Año</div>
                                </div>
                                <input type="text" class="form-control" id="anio" placeholder="aaaa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @foreach ($reservas_current->sortBy('fecha_llegada') as $item)
                                <div class="row reserva-caja">
                                    <div class="col-1 px-0 text-center">
                                        <b class="text-success">{{ $item->codigo }}</b>
                                    </div>
                                    <div class="col-6 px-0 text-center">
                                        <a href="#!" class=" text-decoration-none"><b class="text-primary">{{ $item->nombre }}</b></a>
                                    </div>
                                    <div class="col-1 px-0 text-center bg-danger">
                                        <b class="text-white">{{ $item->nro_pax }}</b>
                                    </div>
                                    <div class="col-4 px-0 text-center  bg-secondary">
                                        <b class="text-white">{{ $item->fecha_llegada }}</b>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
            <div class="col-4 border border-dark">
                <div class="row bg-dark">
                    <div class="col-3 px-0 pt-2 text-center"><b class="text-white">CERRADO</b></div>
                    <div class="col-8 px-0">
                        <select class="form-control" name="filtro" id="filtro" onchange="filtro_reserva($(this).val(),'cerrado')">
                            <option value="codigo">Codigo</option>
                            <option value="nombre">Nombre</option>
                            <option value="fechas">Entre fechas</option>
                            <option value="mes_anio">mm-aaaa</option>
                        </select>
                    </div>
                </div>
                <div class="row ">
                    <div id="codigo_cerrado" class="col-12 px-0">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Codigo</div>
                            </div>
                            <input type="text" class="form-control" id="codigo" placeholder="Codigo">
                        </div>
                    </div>
                    <div id="nombre_cerrado" class="col-12 px-0 d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Codigo</div>
                            </div>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                        </div>
                    </div>
                    <div id="fechas_cerrado" class="col-12 px-0 form-inline d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">D</div>
                            </div>
                            <input type="date" class="form-control" id="codigo" placeholder="Codigo">

                            <div class="input-group-prepend">
                                <div class="input-group-text">H</div>
                            </div>
                            <input type="date" class="form-control" id="codigo" placeholder="Codigo">
                        </div>
                    </div>
                    <div id="mes_anio_cerrado" class="col-12 px-0 d-none">
                        <div class="input-group px-0 mx-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Mes</div>
                            </div>
                            <input type="text" class="form-control" id="mes" placeholder="mm">
                            <div class="input-group-prepend">
                                    <div class="input-group-text">Año</div>
                            </div>
                            <input type="text" class="form-control" id="anio" placeholder="aaaa">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @foreach ($reservas_close->sortBy('fecha_llegada') as $item)
                            <div class="row reserva-caja">
                                <div class="col-1 px-0 text-center">
                                    <b class="text-success">{{ $item->codigo }}</b>
                                </div>
                                <div class="col-6 px-0 text-center">
                                    <a href="#!" class=" text-decoration-none"><b class="text-primary">{{ $item->nombre }}</b></a>
                                </div>
                                <div class="col-1 px-0 text-center bg-danger">
                                    <b class="text-white">{{ $item->nro_pax }}</b>
                                </div>
                                <div class="col-4 px-0 text-center  bg-secondary">
                                    <b class="text-white">{{ $item->fecha_llegada }}</b>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
