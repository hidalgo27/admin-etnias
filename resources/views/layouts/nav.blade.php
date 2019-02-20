<nav id="sidebar" class="bg-light p-2">
        <div class="sidebar-header">
            <img alt="Brand" src="{{asset("images/img/logo-etnias.png")}}" class="w-100">
            <div class="row justify-content-center my-3">
                <div class="col text-center">
                    <p class="m-0">
                        {{-- {{auth()->user()->name}} --}}
                        <b class="text-success">Usuario del sistema</b>
                        <span class="d-block text-info">(Administrador)</span>
                        <a href="#!" class="text-secondary">Cerrar</a>
                    </p>
                </div>
            </div>
        </div>
        @include('layouts.menu-full')

    </nav>
