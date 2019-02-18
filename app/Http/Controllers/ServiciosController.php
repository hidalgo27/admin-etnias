<?php

namespace App\Http\Controllers;

use App\Asociacion;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    //
    public function nuevo(Request $request){


        return view('admin.servicios.nuevo');
    }
    public function buscar_asociacion($ruc_rs){
        $asociacion=Asociacion::where('ruc',$ruc_rs)->orwhere('nombre','like','%'.$ruc_rs.'%')->first();
        return view('admin.servicios.buscar-asociacion',compact('asociacion','ruc_rs'));
    }

}
