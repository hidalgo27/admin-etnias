<div class="row">
    <div class="col-12">
        <div class="alert alert-primary">
            Ruc:<b>{{ $asociacion->ruc }}</b> | Razon social:<b>{{ $asociacion->nombre }}</b> | Contacto:<b>{{ $asociacion->contacto }}</b>
        </div>
    </div>
</div>
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
        <table class="table table-sm table-hover table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TITULO</th>
                    <th>DESCRIPCION</th>
                    <th>OPERACIONES</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=0;
                @endphp
                @foreach ($actividades as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ substr($item->descripcion,0,20) }}...</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_actividad_{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modal_actividad_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_actividad_{{ $item->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Editar la actividad</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
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
                                                    <input type="text" class="form-control" id="titulo_a_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_a_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 text-center">
                                                @foreach ($item->fotos as $foto)
                                                    @if (Storage::disk('actividades')->has($foto->imagen))
                                                        <figure class="figure m-3" id="a_{{ $item->id.'_'.$foto->id }}">
                                                            <img src="{{ route('servicio.show.imagen',[$foto->imagen,'actividades']) }}" class="figure-img rounded" alt="A generic" width="180px" height="180px">
                                                            <figcaption class="figure-caption text-right mt-0">
                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('a_{{ $item->id.'_'.$foto->id }}')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </figcaption>
                                                            <input type="hidden" name="fotos_[]" value="{{ $foto->id }}">
                                                        </figure>
                                                    @endif
                                                @endforeach
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
                                                <tbody id="a_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_a_{{ $item->id }}_precios_e{{ $precio->id }}">
                                                            <td>
                                                                <select class="form-control" name="categoria[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_a_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_a_e{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_a_e{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('e{{ $item->id }}','{{ $apos }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('a')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr id="row_a_{{ $item->id }}_precios_1">
                                                        <td>
                                                            <select class="form-control" name="categoria[]" id="categoria" required>
                                                                <option value="Nacional">Nacional</option>
                                                                <option value="Extranjero">Extranjero</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="number" min="0" name="minimo_a_{{ $item->id }}[]" id="minimo" required>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="number" min="0" name="maximo_a_{{ $item->id }}[]" id="maximo" required>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="number" min="0" name="precio_a_{{ $item->id }}[]" id="precio" required>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger d-none" type="button" onclick="borrar_precio('a')" disabled><i class="fas fa-trash-alt"></i></button>
                                                            <button class="btn btn-success" type="button" onclick="agregar_precio('a','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_precio('2','a')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
