@extends('layouts.app-admin')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">BASE DE DATOS</a></li>
<li class="breadcrumb-item active" aria-current="page">ASOCIACIONES</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9">
                                <b class="text-danger text-15">LISTA DE PROVEEDORES</b>
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('asociacion.nuevo') }}" class="btn btn-info text-white"><i class="fas fa-plus-circle"></i> AGREGAR ASOCIACION</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <table class="table table-bordered table-hover table-striped">
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
                                @foreach ($asociaciones as $item)
                                    <tr id="row_lista_asociaciones_{{ $item->id }}">
                                        <td>{{ $i }}</td>
                                        <td>
                                            {{ $item->comunidad->distrito->provincia->departamento->departamento }}
                                        </td>
                                        <td>
                                            {{ $item->comunidad->distrito->provincia->provincia }}
                                        </td>
                                        <td>
                                            {{ $item->comunidad->distrito->distrito }}
                                        </td>
                                        <td>{{ $item->ruc }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <div class="btn btn-group">
                                            <a href="#" data-tooltip="popover" title="Tips" data-content="Edite los datos de la asociación " class="btn btn-warning" data-toggle="modal" data-target="#asociacionModal_{{ $item->id }}"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('servicios.lista',$item->id) }}" data-tooltip="popover" title="Tips" data-content="Agrege actividades, comidas, hospedaje " class="btn btn-primary"><i class="fas fa-concierge-bell"></i></a>
                                            <a href="#" class="btn btn-danger" onclick="eliminar_asociacion('{{ $item->id }}')"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="asociacionModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <form action="{{ route('asociacion.editar') }}" method="POST" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="form-group col-12">
                                                                        <label for="ruc">Ruc</label>
                                                                        <input type="text" class="form-control" id="ruc" name="ruc" aria-describedby="ruc" placeholder="Ruc" value="{{ $item->ruc }}">
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="nombre">Nombre</label>
                                                                        <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Nombre comercial" value="{{ $item->nombre }}">
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="contacto">Contacto</label>
                                                                        <input type="text" class="form-control" id="contacto" name="contacto" aria-describedby="contacto" placeholder="contacto" value="{{ $item->contacto }}">
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="celular">Celular</label>
                                                                        <input type="text" class="form-control" id="celular" name="celular" aria-describedby="celular" placeholder="Celular" value="{{ $item->celular }}">
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="direccion">Direccion</label>
                                                                        <input type="text" class="form-control" id="direccion" name="direccion" aria-describedby="direccion" placeholder="Direccion" value="{{ $item->direccion }}">
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="email">Email</label>
                                                                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="email" value="{{ $item->email }}">
                                                                    </div>
                                                                    <div class="form-group col-6">
                                                                        <label for="password">Password</label>
                                                                        <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="password" value="{{ $item->password_2 }}">
                                                                    </div>
                                                                    <div class="form-group col-6">
                                                                            <label for="password">Re password</label>
                                                                            <input type="password" class="form-control" id="repassword" name="repassword" aria-describedby="password" placeholder="password" value="{{ $item->password_2 }}">
                                                                        </div>
                                                                    <div class="form-group col-4">
                                                                        <label for="departamento">Departamento</label>
                                                                        <select class="form-control" name="departamento" id="departamento" onchange="mostrar_provincias($(this).val());">
                                                                            <option value="0">Escoja una opcion</option>
                                                                            @foreach ($departamentos as $item_)
                                                                                <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito->provincia->departamento_id)
                                                                                    selected
                                                                                @endif>{{ $item_->departamento }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-4">
                                                                        <label for="provincia">Provicia</label>
                                                                        <select class="form-control" name="provincia" id="provincia" onchange="mostrar_distritos($(this).val());">
                                                                            <option value="0">Escoja una opcion</option>
                                                                            @foreach ($provincias->where('departamento_id',$item->comunidad->distrito->provincia->departamento_id) as $item_)
                                                                                <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito->provincia_id)
                                                                                    selected
                                                                                @endif>{{ $item_->provincia }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div id="distrito_id" class="form-group col-4">
                                                                        <label for="distrito">Distrito</label>
                                                                        <select class="form-control" name="distrito" id="distrito" onchange="mostrar_comunidades($(this).val(),'{{ $item->id }}');">
                                                                            <option value="0">Escoja una opcion</option>
                                                                            @foreach ($distritos->where('provincia_id',$item->comunidad->distrito->provincia_id) as $item_)
                                                                                <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->distrito_id)
                                                                                    selected
                                                                                @endif>{{ $item_->distrito }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div id="distrito_id" class="form-group col-4">
                                                                        <label for="comunidad">comunidad</label>
                                                                        <select class="form-control" name="comunidad" id="comunidad_{{ $item->id }}">
                                                                            <option value="0">Escoja una opcion</option>
                                                                            @foreach ($comunidades->where('distrito_id',$item->comunidad->distrito->id) as $item_)
                                                                                <option value="{{ $item_->id }}" @if ($item_->id==$item->comunidad->id)
                                                                                    selected
                                                                                @endif>{{ $item_->nombre }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group col-2">
                                                                        <label for="comision">Comision(%)</label>
                                                                        <input type="number" class="form-control" id="comision" name="comision" value="{{ $item->comision }}" step="0.01" min="0" max="100">
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group col-12 text-left">
                                                                                <p><b>Portada</b></p>
                                                                                @foreach ($item->fotos->where('estado','1') as $foto)
                                                                                    @if (Storage::disk('asociaciones')->has($foto->imagen))
                                                                                        <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                            <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                            <figcaption class="figure-caption text-right mt-0">
                                                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                                </a>
                                                                                            </figcaption>
                                                                                            <input type="hidden" name="portada" value="{{ $foto->id }}">
                                                                                        </figure>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group col-12">
                                                                                <label for="foto">Foto</label>
                                                                                <input type="file" name="portada_f" multiple class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group col-12 text-left">
                                                                                <p><b>Miniatura</b></p>
                                                                                @foreach ($item->fotos->where('estado','2') as $foto)
                                                                                    @if (Storage::disk('asociaciones')->has($foto->imagen))
                                                                                        <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                            <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                            <figcaption class="figure-caption text-right mt-0">
                                                                                                <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                                </a>
                                                                                            </figcaption>
                                                                                            <input type="hidden" name="miniatura" value="{{ $foto->id }}">
                                                                                        </figure>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group col-12">
                                                                                <label for="foto">Foto</label>
                                                                                <input type="file" name="miniatura_f" multiple class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="form-group col-12 text-left">
                                                                                <p><b>Galeria de fotos</b></p>
                                                                                    @foreach ($item->fotos->where('estado','0') as $foto)
                                                                                        @if (Storage::disk('asociaciones')->has($foto->imagen))
                                                                                            <figure class="figure m-3" id="{{ $item->id.'_'.$foto->id }}">
                                                                                                <img src="{{ route('asociacion.editar.imagen',$foto->imagen) }}" class="figure-img rounded" alt="A generic" width="200px" height="200px">
                                                                                                <figcaption class="figure-caption text-right mt-0">
                                                                                                    <a href="#!" class="btn btn-danger btn btn-block" onclick="borrar_foto_asociacion('{{ $item->id.'_'.$foto->id }}')">
                                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                                    </a>
                                                                                                </figcaption>
                                                                                                <input type="hidden" name="fotos_[]" value="{{ $foto->id }}">
                                                                                            </figure>
                                                                                        @endif
                                                                                    @endforeach
                                                                            </div>
                                                                            <div class="form-group col-12">
                                                                                <label for="foto">Foto</label>
                                                                                <input type="file" name="foto[]" multiple class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <label for="descripcion">Descripcion</label>
                                                                        <textarea name="descripcion" id="descripcion" class="form-control descripcion"  cols="30" rows="10" >{{ $item->descripcion }}</textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer text-right">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                         </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
