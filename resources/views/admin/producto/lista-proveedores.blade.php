@foreach ($proveedores as $proveedor)
    <div class="form-check text-primary">
        <input class="form-check-input proveedor" type="checkbox" value="{{ $proveedor->id }}_{{ $proveedor->nombre_comercial }}" id="proveedor_{{ $proveedor->id }}">
        <label class="form-check-label" for="proveedor_{{ $proveedor->id }}">
            {{ $proveedor->nombre_comercial }}
        </label>
    </div>
@endforeach
