<div class="form-group col-12">
        <b class="text-15 text-success">DATOS GENERALES</b>
    </div>
    <table class="table table-hover table-responsive table-striped">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disponibilidad as $disponible)
                    <tr id="row_a_calendario_e{{ $id }}_e{{ $disponible->id }}">
                        
                        <td>
                            {{$disponible->cantidad}}
                        </td>
                        <td>
                            {{$disponible->fecha}}
                        </td>
                        <td>
                            @if($disponible->estado=='1')
                                <span class="text-danger">Ocupado</span>    
                            @else
                                <span class="text-success">Disponible</span>    
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-danger" type="button" onclick="borrar_precio('a','e{{ $id }}','e{{ $disponible->id }}')"><i class="fas fa-trash-alt"></i></button>
                            <button class="btn btn-success d-none" type="button" onclick="agregar_precio('a')"><i class="fas fa-plus"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
