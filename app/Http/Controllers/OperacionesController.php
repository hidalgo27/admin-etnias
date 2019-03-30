<?php

namespace App\Http\Controllers;

use App\Reserva;
use Illuminate\Http\Request;
use App\Proveedor;

class OperacionesController extends Controller
{
    //

    public function lista($f1,$f2){
        // return dd($f1.'_'.$f2);
        $operaciones=Reserva::whereBetween('fecha_llegada',[$f1,$f2])->get();
        $proveedores=Proveedor::get();
        return view('admin.operaciones.lista',compact('operaciones','f1','f2','proveedores'));
    }
    public function lista_post(Request $request){
        // return dd($f1.'_'.$f2);
        $f1=$request->input('desde');
        $f2=$request->input('hasta');
        $operaciones=Reserva::whereBetween('fecha_llegada',[$f1,$f2])->get();
        $proveedores=Proveedor::get();
        return view('admin.operaciones.lista',compact('operaciones','f1','f2','proveedores'));
    }
    
}
