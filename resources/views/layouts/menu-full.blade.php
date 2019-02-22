@if (!isset($hotel_proveedor_id))
  @php
      $hotel_proveedor_id=0;
  @endphp
@endif


<div class="menu-list text-12">
  <ul id="menu-content" class="menu-content collapsed menu1">
    {{-- rutas para la base de datos --}}
    <li data-toggle="collapse" data-target="#operaciones" class="collapsed">
        <a href="#" class="bg-dark text-white"><i class="fas fa-database"></i> BASE DE DATOS </a>
    </li>
    <ul class="sub-menu collapse menu2 @if(
      (url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path'))||
      (url()->current()==route('asociacion.lista')||url()->current()==route('asociacion.nuevo'))||
      (url()->current()==route('servicios.nuevo')||url()->current()==route('servicios.lista'))
      ) show @endif" id="operaciones">
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path')) active @endif" href="{{route('comunidad_lista_path')}}">COMUNIDADES</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('asociacion.lista')||url()->current()==route('asociacion.nuevo')) active @endif" href="{{route('asociacion.lista')}}"> ASOCIACIONES</a>
      </li>
      <li data-toggle="collapse" class="active1">
        <a class="@if(url()->current()==route('servicios.nuevo')||url()->current()==route('servicios.lista')) active @endif" href="{{route('servicios.lista')}}">SERVICIOS</a>
      </li>
    </ul>
    {{-- rutas para la base de datos --}}
    <li data-toggle="collapse" data-target="#reservas" class="collapsed">
      <a href="#" class="bg-danger text-white"><i class="fas fa-swatchbook"></i> RESERVAS </a>
  </li>
  <ul class="sub-menu collapse menu2 @if(
    (url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path'))
    ) show @endif" id="reservas">
    <li data-toggle="collapse" class="active1">
      <a class="@if(url()->current()==route('comunidad_lista_path')||url()->current()==route('comunidad_nuevo_path')) active @endif" href="{{route('comunidad_lista_path')}}">RESERVAS</a>
    </li>

  </ul>

  </ul>
 </div>
