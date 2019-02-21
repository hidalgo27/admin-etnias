@if (count((array)$asociacion))
    <div class="alert alert-primary">
        Ruc: <b>{{ $asociacion->ruc }}</b> | Razon social: <b>{{ $asociacion->nombre }} </b>
        <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="{{ $asociacion->id}}" form="form_a">
        <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="{{ $asociacion->id}}" form="form_c">
        <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="{{ $asociacion->id}}" form="form_h">
        <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="{{ $asociacion->id}}" form="form_t">
        <input type="hidden" name="s_asociacion_id" id="s_asociacion_id" value="{{ $asociacion->id}}" form="form_s">
    </div>
@else
    <div class="alert alert-danger">
        <p>No existe la asociacion con el dato "<b>{{ $ruc_rs }}</b>" </p>
        <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="" form="form_a">
        <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="" form="form_c">
        <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="" form="form_h">
        <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="" form="form_t">
        <input type="hidden" name="s_asociacion_id" id="s_asociacion_id" value="" form="form_s">
    </div>
@endif
