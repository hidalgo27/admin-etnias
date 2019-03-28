@foreach ($proveedores as $proveedor)
<div class="form-check text-primary">
<input class="form-check-input" type="checkbox" value="{{ $proveedor->id }}_{{ $proveedor->nombre_comercial }}" name="proveedor_{{$categoria_id}}_{{$producto_id}}[]" id="proveedor_{{ $proveedor->id }}">
    <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
      {{ $proveedor->nombre_comercial }}
    </label>
</div>
@endforeach
