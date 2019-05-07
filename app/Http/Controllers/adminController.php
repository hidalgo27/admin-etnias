<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Comunidad;
use App\Provincia;
use App\Departamento;
use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['user', 'admin','asociacion']);
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        // return view('admin.index');
        return view('admin.index',compact('departamentos','provincias','distritos','comunidades'));

    }
    public function crear_usuario(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        // return view('admin.index');
        return view('admin.crear-usuario');

    }
    

    public function destroy(){
        // auth()->guard('admin')->logout();
        return redirect()->route('admin_index_path');
    }
    public function solicitudes_lista()
    {

        return view('admin.index');
    }
}
