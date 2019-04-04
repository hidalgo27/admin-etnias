@if (count((array)$asociacion))
    <div class="alert alert-primary">
        Ruc: <b>{{ $asociacion->ruc }}</b> | Razon social: <b>{{ $asociacion->nombre }} </b>
        <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="{{ $asociacion->id}}" form="form_a_n_0">
        <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="{{ $asociacion->id}}" form="form_c_n_0">
        <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="{{ $asociacion->id}}" form="form_h_n_0">
        <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="{{ $asociacion->id}}" form="form_t_n_0">
        <input type="hidden" name="s_asociacion_id" id="s_asociacion_id" value="{{ $asociacion->id}}" form="form_s_n_0">
    </div>
@else
    <div class="alert alert-danger">
        <p>No existe la asociacion con el dato "<b>{{ $ruc_rs }}</b>" </p>
        <input type="hidden" name="a_asociacion_id" id="a_asociacion_id" value="" form="form_a_n_0">
        <input type="hidden" name="c_asociacion_id" id="c_asociacion_id" value="" form="form_c_n_0">
        <input type="hidden" name="h_asociacion_id" id="h_asociacion_id" value="" form="form_h_n_0">
        <input type="hidden" name="t_asociacion_id" id="t_asociacion_id" value="" form="form_t_n_0">
        <input type="hidden" name="s_asociacion_id" id="s_asociacion_id" value="" form="form_s_n_0">
    </div>
@endif
