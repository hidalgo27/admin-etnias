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
                    <tr id="servicio_{{ $item->id }}">
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
                                        <form id="form_a_e_{{ $item->id }}" class="card card-body" action="{{ route('servicios.actividad.edit') }}" method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-12">
                                                <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Titulo</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="titulo_a_e_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>

                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="categoria">Categoria</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Categoria</div>
                                                    </div>
                                                    <select class="form-control" name="categoria" id="categoria_t_e_{{ $item->id }}">
                                                        @foreach ($categorias as $cate)
                                                            <option value="{{ $cate->nombre }}" @if ($cate->nombre== $item->categoria) selected @endif >{{ $cate->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_a_e_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
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
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="form-group col-10">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <div class="col-2 text-left">
                                                    <input type="hidden" id="cantidad_precios_a_{{ $item->id }}" value="0">
                                                    <button class="btn btn-success" type="button" onclick="agregar_precio('a','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                                <tbody id="a_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_a_precios_e{{ $item->id }}_e{{ $precio->id }}">
                                                            <td>
                                                                <input type="hidden" name="precio_id_e[]" value="{{ $precio->id }}">
                                                                <select class="form-control" name="categoria_e[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_a_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_a_e_{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_a_e_{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('a','e{{ $item->id }}','e{{ $precio->id }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('a')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-12 text-right">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="attributo" value="a">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-primary" type="button" onclick="enviar_datos_editar('a','e_{{ $item->id }}')"><i class="fas fa-save"></i> GUARDAR</button>
                                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                            </div>
                                            <div class="col-12" id="rpt_form_a_e_{{ $item->id }}"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-none">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_servicio('{{ $item->id }}','a')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-comidas" role="tabpanel" aria-labelledby="nav-comidas-tab">
        <table class="table table-sm table-hover table-striped">
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
                @foreach ($comidas as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ substr($item->descripcion,0,20) }}...</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_comida_{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modal_comida_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_comida_{{ $item->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Editar la comida</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_c_e_{{ $item->id }}" class="card card-body" action="{{ route('servicios.actividad.edit') }}" method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-12">
                                                <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Titulo</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="titulo_c_e_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_c_e_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 text-center">
                                                @foreach ($item->fotos as $foto)
                                                    @if (Storage::disk('comidas')->has($foto->imagen))
                                                        <figure class="figure m-3" id="c_{{ $item->id.'_'.$foto->id }}">
                                                            <img src="{{ route('servicio.show.imagen',[$foto->imagen,'comidas']) }}" class="figure-img rounded" alt="A generic" width="180px" height="180px">
                                                            <figcaption class="figure-caption text-right mt-0">
                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('c_{{ $item->id.'_'.$foto->id }}')">
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
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="form-group col-10">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <div class="col-2 text-left">
                                                    <input type="hidden" id="cantidad_precios_c_{{ $item->id }}" value="0">
                                                    <button class="btn btn-success" type="button" onclick="agregar_precio('c','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                                <tbody id="c_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_c_precios_e{{ $item->id }}_e{{ $precio->id }}">
                                                            <td>
                                                                <input type="hidden" name="precio_id_e[]" value="{{ $precio->id }}">
                                                                <select class="form-control" name="categoria_e[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_c_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_c_e_{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_c_e_{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('c','e{{ $item->id }}','e{{ $precio->id }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('c')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-12 text-right">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="attributo" value="c">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-primary" type="button" onclick="enviar_datos_editar('c','e_{{ $item->id }}')"><i class="fas fa-save"></i> GUARDAR</button>
                                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                            </div>
                                            <div class="col-12" id="rpt_form_c_e_{{ $item->id }}"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-none">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_servicio('{{ $item->id }}','c')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-hospedaje" role="tabpanel" aria-labelledby="nav-hospedaje-tab">
        <table class="table table-sm table-hover table-striped">
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
                @foreach ($hospedajes as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ substr($item->descripcion,0,20) }}...</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_hospedaje_{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modal_hospedaje_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_hospedaje_{{ $item->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Editar el hospedaje</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_h_e_{{ $item->id }}" class="card card-body" action="{{ route('servicios.actividad.edit') }}" method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-12">
                                                <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Titulo</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="titulo_h_e_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_h_e_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 text-center">
                                                @foreach ($item->fotos as $foto)
                                                    @if (Storage::disk('hospedajes')->has($foto->imagen))
                                                        <figure class="figure m-3" id="h_{{ $item->id.'_'.$foto->id }}">
                                                            <img src="{{ route('servicio.show.imagen',[$foto->imagen,'hospedajes']) }}" class="figure-img rounded" alt="A generic" width="180px" height="180px">
                                                            <figcaption class="figure-caption text-right mt-0">
                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('h_{{ $item->id.'_'.$foto->id }}')">
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
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="form-group col-10">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <div class="col-2 text-left">
                                                    <input type="hidden" id="cantidad_precios_h{{ $item->id }}" value="0">
                                                    <button class="btn btn-success" type="button" onclick="agregar_precio('h','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                                <tbody id="h_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_h_precios_e{{ $item->id }}_e{{ $precio->id }}">
                                                            <td>
                                                                <input type="hidden" name="precio_id_e[]" value="{{ $precio->id }}">
                                                                <select class="form-control" name="categoria_e[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_h_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_h_e_{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_h_e_{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('h','e{{ $item->id }}','e{{ $precio->id }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('h')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-12 text-right">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="attributo" value="h">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-primary" type="button" onclick="enviar_datos_editar('h','e_{{ $item->id }}')"><i class="fas fa-save"></i> GUARDAR</button>
                                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                            </div>
                                            <div class="col-12" id="rpt_form_h_e_{{ $item->id }}"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-none">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_servicio('{{ $item->id }}','h')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-transporte" role="tabpanel" aria-labelledby="nav-transporte-tab">
        <table class="table table-sm table-hover table-striped">
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
                @foreach ($transportes as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ substr($item->descripcion,0,20) }}...</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_transporte_{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modal_transporte_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_transporte_{{ $item->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Editar el transporte</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_t_e_{{ $item->id }}" class="card card-body" action="{{ route('servicios.actividad.edit') }}" method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-12">
                                                <b class="text-15 text-success">PASO 1: DATOS GENERALES1</b>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Titulo</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="titulo_t_e_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_t_e_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 text-center">
                                                @foreach ($item->fotos as $foto)
                                                    @if (Storage::disk('transportes')->has($foto->imagen))
                                                        <figure class="figure m-3" id="t_{{ $item->id.'_'.$foto->id }}">
                                                            <img src="{{ route('servicio.show.imagen',[$foto->imagen,'transportes']) }}" class="figure-img rounded" alt="A generic" width="180px" height="180px">
                                                            <figcaption class="figure-caption text-right mt-0">
                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('t_{{ $item->id.'_'.$foto->id }}')">
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
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="form-group col-10">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <div class="col-2 text-left">
                                                    <input type="hidden" id="cantidad_precios_t{{ $item->id }}" value="0">
                                                    <button class="btn btn-success" type="button" onclick="agregar_precio('t','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                                <tbody id="t_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_t_precios_e{{ $item->id }}_e{{ $precio->id }}">
                                                            <td>
                                                                <input type="hidden" name="precio_id_e[]" value="{{ $precio->id }}">
                                                                <select class="form-control" name="categoria_e[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_t_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_t_e_{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_t_e_{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('t','e{{ $item->id }}','e{{ $precio->id }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('t')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-12 text-right">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="attributo" value="t">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-primary" type="button" onclick="enviar_datos_editar('t','e_{{ $item->id }}')"><i class="fas fa-save"></i> GUARDAR</button>
                                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                            </div>
                                            <div class="col-12" id="rpt_form_t_e_{{ $item->id }}"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-none">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_servicio('{{ $item->id }}','t')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="nav-servicios" role="tabpanel" aria-labelledby="nav-servicios-tab">
        <table class="table table-sm table-hover table-striped">
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
                @foreach ($servicios as $item)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ substr($item->descripcion,0,20) }}...</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_servicio_{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modal_servicio_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modal_servicio_{{ $item->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Editar el servicio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form_s_e_{{ $item->id }}" class="card card-body" action="{{ route('servicios.actividad.edit') }}" method="POST" enctype="multipart/form-data">
                                            <div class="form-group col-12">
                                                <b class="text-15 text-success">PASO 1: DATOS GENERALES</b>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Titulo</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Titulo</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="titulo_s_e_{{ $item->id }}" name="titulo" placeholder="Titulo" required value="{{ $item->titulo }}">
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <label class="sr-only" for="inlineFormInputGroupUsername">Descripcion</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Descripcion</div>
                                                    </div>
                                                    <textarea class="form-control" name="descripcion" id="descripcion_s_e_{{ $item->id }}" cols="30" rows="10">{{ $item->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 text-center">
                                                @foreach ($item->fotos as $foto)
                                                    @if (Storage::disk('servicios')->has($foto->imagen))
                                                        <figure class="figure m-3" id="t_{{ $item->id.'_'.$foto->id }}">
                                                            <img src="{{ route('servicio.show.imagen',[$foto->imagen,'servicios']) }}" class="figure-img rounded" alt="A generic" width="180px" height="180px">
                                                            <figcaption class="figure-caption text-right mt-0">
                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('t_{{ $item->id.'_'.$foto->id }}')">
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
                                            <hr>
                                            <div class="row mt-3">
                                                <div class="form-group col-10">
                                                    <b class="text-15 text-success">PASO 2: PRECIOS</b>
                                                </div>
                                                <div class="col-2 text-left">
                                                    <input type="hidden" id="cantidad_precios_s{{ $item->id }}" value="0">
                                                    <button class="btn btn-success" type="button" onclick="agregar_precio('s','{{ $item->id }}')"><i class="fas fa-plus"></i></button>
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
                                                <tbody id="s_precios_{{ $item->id }}">
                                                    @foreach ($item->precios as $precio)
                                                        <tr id="row_s_precios_e{{ $item->id }}_e{{ $precio->id }}">
                                                            <td>
                                                                <input type="hidden" name="precio_id_e[]" value="{{ $precio->id }}">
                                                                <select class="form-control" name="categoria_e[]" id="categoria" required>
                                                                    <option value="Nacional" @if($precio->categoria=='Nacional') selected @endif>Nacional</option>
                                                                    <option value="Extranjero" @if($precio->categoria=='Extranjero') selected @endif>Extranjero</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="minimo_s_e_{{ $item->id }}[]" id="minimo" required value="{{ $precio->min }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="maximo_s_e_{{ $item->id }}[]" id="maximo" required value="{{ $precio->max }}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" min="0" name="precio_s_e_{{ $item->id }}[]" id="precio" required value="{{ $precio->precio }}">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onclick="borrar_precio('s','e{{ $item->id }}','e{{ $precio->id }}')"><i class="fas fa-trash-alt"></i></button>
                                                                <button class="btn btn-success d-none" type="button" onclick="agregar_precio('s')"><i class="fas fa-plus"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="col-12 text-right">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="attributo" value="s">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button class="btn btn-primary" type="button" onclick="enviar_datos_editar('s','e_{{ $item->id }}')"><i class="fas fa-save"></i> GUARDAR</button>
                                                <a href="{{ route('asociacion.lista') }}" class="btn btn-outline-primary" type="close"><i class="fas fa-close"></i> CANCELAR</a>
                                            </div>
                                            <div class="col-12" id="rpt_form_s_e_{{ $item->id }}"></div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-none">
                                        <button type="button" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button class="btn btn-danger" type="button" onclick="borrar_servicio('{{ $item->id }}','s')"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
