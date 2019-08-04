<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Proveedor;
use App\Provincia;

use App\Departamento;
use App\SolicitudesOtros;
use Illuminate\Http\Request;
use App\Mail\MailSenderOtros;
use Illuminate\Support\Facades\Mail;

class SolicitudOtrosController extends Controller
{
    //
    public function lista(){
        $solicitudes=SolicitudesOtros::where('estado','0')->get();
        $departamentos=Departamento::all();
        $provincias=Provincia::all();
        $distritos=Distrito::all();

        return view('admin.solicitudes.otros',compact('solicitudes','departamentos','provincias','distritos'));
    }
    public function crear($id){
        // $nums = range(100, 999);
        $nums = rand(1000000, 9999999);
        // dd($nums);

        $asociacion_solicitud=SolicitudesOtros::find($id);
        // dd($asociacion_solicitud);
        $asociacion=new Proveedor();
        $asociacion->categoria=strtoupper($asociacion_solicitud->categoria);
        $asociacion->ruc=$asociacion_solicitud->departamento_id.$id;
        $asociacion->razon_social=$asociacion_solicitud->nombre;
        $asociacion->nombre_comercial=$asociacion_solicitud->nombre;
        $asociacion->direccion='';
        $asociacion->telefono=$asociacion_solicitud->telefono;
        $asociacion->celular=$asociacion_solicitud->telefono;
        $asociacion->email=$asociacion_solicitud->email;
        $asociacion->plazo='15';
        $asociacion->desci='DESPUES';
        $asociacion->departamento_id=$asociacion_solicitud->departamento_id;
        $asociacion->provincia_id=$asociacion_solicitud->provincia_id;
        $asociacion->distrito_id=$asociacion_solicitud->distrito_id;
        $asociacion->save();
        $asociacion_solicitud->estado='1';
        $asociacion_solicitud->save();
        // dd($asociacion);
        // enviamos el email
        Mail::send(new MailSenderOtros($asociacion,$asociacion->email));

        return redirect()->back()->with('success','Proveedor de '.$asociacion_solicitud->categoria.' creado con<br><b>Ruc:</b>'.$asociacion->ruc.'<br><b>Nombre:</b>'.$asociacion->nombre.'<br><b>Email:</b>'.$asociacion->email.'<br>Se envio una email a la nueva asociación.');
        // return view('admin.solicitudes.asociaciones',compact('asociacion'))->echo;
    }
}
