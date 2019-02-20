@if (count((array)$asociacion))
    <div class="alert alert-success">
        <p>Asociacion encontrada</p>
        <b>Ruc: {{ $asociacion->ruc }}, Razon social {{ $asociacion->nombre }} </b>
        <input type="hidden" name="asociacion_id" id="asociacion_id" value="{{ $asociacion->id}}" form="form_actividad">
    </div>
@else
    <div class="alert alert-danger">
        <p>No existe la asociacion con el dato "<b>{{ $ruc_rs }}</b>" </p>
        <input type="hidden" name="asociacion_id" id="asociacion_id" value="0">
    </div>
@endif
