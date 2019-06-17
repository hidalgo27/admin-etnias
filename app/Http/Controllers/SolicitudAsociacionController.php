<?php

namespace App\Http\Controllers;

use App\Asociacion;
use App\Mail\MailSender;
use Illuminate\Http\Request;
use App\SolicitudesAsociacion;
use Illuminate\Support\Facades\Mail;

class SolicitudAsociacionController extends Controller
{
    //
    public function lista(){
        $asociaciones=SolicitudesAsociacion::where('estado','0')->get();
        return view('admin.solicitudes.asociaciones',compact('asociaciones'));
    }
    public function crear($id){
        // $nums = range(100, 999);
        $nums = rand(1000000, 9999999);
        // dd($nums);

        $asociacion_solicitud=SolicitudesAsociacion::find($id);
        // dd($asociacion_solicitud);
        $asociacion=new Asociacion();
        $asociacion->ruc=$asociacion_solicitud->comunidad_id.$id;
        $asociacion->nombre=$asociacion_solicitud->nombre;
        $asociacion->contacto=$asociacion_solicitud->nombre_representante;
        $asociacion->celular=$asociacion_solicitud->telefono;
        $asociacion->email=$asociacion_solicitud->email;
        $asociacion->direccion='';
        $asociacion->comision='15';
        $asociacion->descripcion='';
        $asociacion->password=bcrypt($asociacion_solicitud->comunidad_id.$id.$nums);
        $asociacion->password_2=$asociacion_solicitud->comunidad_id.$id.$nums;
        $asociacion->comunidad_id=$asociacion_solicitud->comunidad_id;
        $asociacion->save();
        $asociacion_solicitud->estado='1';
        $asociacion_solicitud->save();
        // dd($asociacion);
        // enviamos el email
        Mail::send(new MailSender($asociacion,$asociacion->email));

        return redirect()->back()->with('success','Asociacion creada con<br><b>Ruc:</b>'.$asociacion->ruc.'<br><b>Nombre:</b>'.$asociacion->nombre.'<br><b>Email:</b>'.$asociacion->email.'<br>Se envio una email a la nueva asociación.');
        // return view('admin.solicitudes.asociaciones',compact('asociacion'))->echo;
    }
}
