@if (count((array)$asociacion))
    <div class="alert alert-primary">
        Ruc: <b>{{ $asociacion->ruc }}</b> | Razon social: <b>{{ $asociacion->nombre }} </b>
        <input type="hidden" name="actividad_asociacion_id" id="actividad_asociacion_id" value="{{ $asociacion->id}}" form="form_actividad">
        <input type="hidden" name="comidas_asociacion_id" id="comidas_asociacion_id" value="{{ $asociacion->id}}" form="form_comidas">
        <input type="hidden" name="hospedaje_asociacion_id" id="hospedaje_asociacion_id" value="{{ $asociacion->id}}" form="form_hospedaje">
        <input type="hidden" name="transporte_asociacion_id" id="transporte_asociacion_id" value="{{ $asociacion->id}}" form="form_transporte">
        <input type="hidden" name="servicios_asociacion_id" id="servicios_asociacion_id" value="{{ $asociacion->id}}" form="form_servicios">
    </div>
@else
    <div class="alert alert-danger">
        <p>No existe la asociacion con el dato "<b>{{ $ruc_rs }}</b>" </p>
        <input type="hidden" name="actividad_asociacion_id" id="actividad_asociacion_id" value="" form="form_actividad">
        <input type="hidden" name="comidas_asociacion_id" id="comidas_asociacion_id" value="" form="form_comidas">
        <input type="hidden" name="hospedaje_asociacion_id" id="hospedaje_asociacion_id" value="" form="form_hospedaje">
        <input type="hidden" name="transporte_asociacion_id" id="transporte_asociacion_id" value="" form="form_transporte">
        <input type="hidden" name="servicios_asociacion_id" id="servicios_asociacion_id" value="" form="form_servicios">
    </div>
@endif
