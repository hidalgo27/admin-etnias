<?php

namespace App\Http\Controllers;

use App\User;
use App\Reserva;
use App\Encuesta;
use App\ReservaEncuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\MailSenderEncuesta;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class EncuestaController extends Controller
{
     //
     public function lista(){
        $reservas_sin_enviar=Reserva::where('estado','>=','0')->where('estado_encuesta','0')->get();
        $reservas_enviadas=Reserva::where('estado','>=','0')->where('estado_encuesta','1')->get();
        
        $reservas_respondidas=Reserva::where('estado','>=','0')->where('estado_encuesta','2')->get();
        return view('admin.encuesta.lista',compact('reservas_sin_enviar','reservas_enviadas','reservas_respondidas'));
    }
    public function detalle($reserva_id){
        $reserva=Reserva::findOrFail($reserva_id);
        return view('admin.encuesta.detalle',compact('reserva','reserva_id'));
    }
    public function enviar_encuesta(Request $request){
        $reserva_id=$request->input('reserva_id');
        $reserva=Reserva::findOrFail($reserva_id);
        $encuesta_=ReservaEncuesta::where('reserva_id',$reserva->id)->first();
        if(!isset($encuesta_)){
            $encuesta_modelo=Encuesta::get();
                foreach ($encuesta_modelo->sortby('pos') as $encuesta_m){
                    $encuesta=new ReservaEncuesta();
                    if(App::isLocale('en')){
                        $encuesta->pregunta=$encuesta_m->question;
                    }
                    else{
                        $encuesta->pregunta=$encuesta_m->pregunta;
                    }
                    
                
                    $encuesta->pregunta=$encuesta_m->pregunta;
                    $encuesta->pos=$encuesta_m->pos;
                    $encuesta->estado=$encuesta_m->estado;
                    if($encuesta_m->estado=='0'){
                        $encuesta->valoracion=0;
                    }
                    else{
                        $encuesta->valoracion='';
                    }
                    $encuesta->reserva_id=$reserva->id;
                    $encuesta->save();
                }
        }
        // dd($reserva);

        //dd($reserva->user_id);
        $user=User::Find($reserva->user_id);
        // dd($user);
        $reserva->estado_encuesta=1;
        $reserva->save();
        Mail::send(new MailSenderEncuesta($reserva,$user->email));

        return redirect()->back()->with('success','Encuesta enviada.');

    }
    public function guardar_encuesta(Request $request ){

        $reserva_id=base64_decode($request->input('reserva_id'));
        $preguntas=$request->input('preguntas');
        $pregunta_texto_id=$request->input('pregunta_texto_id');
        $pregunta_texto=$request->input('pregunta_texto');
        if(isset($preguntas)){
            foreach($preguntas as $pregunta){
                $pregunta_=explode('_',$pregunta);
                $encuesta=ReservaEncuesta::find($pregunta_[0]);
                $encuesta->valoracion=$pregunta_[1];
                $encuesta->save();
            }
        }
        if(isset($pregunta_texto_id)){
            $encuesta=ReservaEncuesta::find($pregunta_texto_id);
            $encuesta->valoracion=$pregunta_texto;
            $encuesta->save();
        }
        return redirect()->back()->with('success','Encuesta enviada.');
    }
    public function confirmar($tipo_servicio,$grupo_id,$estado){
        // try {
            //code...

            if($tipo_servicio=='actividad'){
                $temp=ReservaActividad::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='comida'){
                $temp=ReservaComida::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='hospedaje'){
                $temp=ReservaHospedaje::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='transporte'){
                $temp=ReservaTransporte::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='servicio'){
                $temp=ReservaServicio::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='TRANSPORTE'){
                $temp=ReservaTransporteExterno::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($tipo_servicio=='GUIA'){
                $temp=ReservaGuia::find($grupo_id);
                $temp->estado=$estado;
                $temp->save();
            }
            if($estado==1){
                $estado_rpt=0;
                $clase_span='badge-success';
                $estado_span='Confirmado';
                $clase_confirmar='btn-danger';
                $estado_confirmar='Cancelar';
            }
            elseif($estado==0){
                $estado_rpt=1;
                $clase_span='badge-dark';
                $estado_span='Pendiente';
                $clase_confirmar='btn-primary';
                $estado_confirmar='Confirmar';
            }

            return response()->json(['rpt'=>'1',
                                    'estado'=>$estado,
                                    'clase_span'=>$clase_span,
                                    'estado_span'=>$estado_span,
                                    'clase_confirmar'=>$clase_confirmar,
                                    'estado_confirmar'=>$estado_confirmar]);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['rpt'=>'0']);
        // }
    }
    public function confirmar_reserva($tipo_servicio,$grupo_id,$estado,$nuevo_estado){
        // try {
        //code...

        if($tipo_servicio=='actividad'){
            $temp=ReservaActividad::find($grupo_id);
            $temp->estado=$nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='comida'){
            $temp=ReservaComida::find($grupo_id);
            $temp->estado=$nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='hospedaje'){
            $temp=ReservaHospedaje::find($grupo_id);
            $temp->estado=$nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='transporte'){
            $temp=ReservaTransporte::find($grupo_id);
            $temp->estado=$nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='servicio'){
            $temp=ReservaServicio::find($grupo_id);
            $temp->estado=$nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='TRANSPORTE'){
            $temp=ReservaTransporteExterno::find($grupo_id);
            $temp->estado=nuevo_estado;
            $temp->save();
        }
        if($tipo_servicio=='GUIA'){
            $temp=ReservaGuia::find($grupo_id);
            $temp->estado=nuevo_estado;
            $temp->save();
        }
        if($nuevo_estado==1){
            $estado_rpt=1;
            $clase_span='badge-success';
            $estado_span='Confirmado';
            $clase_confirmar='btn-success';
            $estado_confirmar='Confirmar';
        }
        elseif($nuevo_estado==0){
            $estado_rpt=1;
            $clase_span='badge-dark';
            $estado_span='Pendiente';
            $clase_confirmar='btn-dark';
            $estado_confirmar='Confirmar';
        }
        elseif($nuevo_estado==2){
            $estado_rpt=1;
            $clase_span='badge-danger';
            $estado_span='Anulado';
            $clase_confirmar='btn-danger';
            $estado_confirmar='Confirmar';
        }

        return response()->json(['rpt'=>'1',
            'estado'=>$estado,
            'clase_span'=>$clase_span,
            'estado_span'=>$estado_span,
            'clase_confirmar'=>$clase_confirmar,
            'estado_confirmar'=>$estado_confirmar]);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['rpt'=>'0']);
        // }
    }
    public function escojer_proveedor(Request $request){
        // try {
            //code...
            // return response()->json(['rpt'=>$request->all()]);
            $transporte_externo_guia_id=$request->input('transporte_externo_guia_id');
            $proveedor_id_pago=$request->input('proveedor_id_pago');
            $precio_pago=$request->input('precio_pago');
            $fecha_pago=$request->input('fecha_pago');
            $rol=$request->input('rol');
            if($rol=='TRANSPORTE'){
                $rexterna=ReservaTransporteExterno::find($transporte_externo_guia_id);
                $rexterna->proveedor_id=$proveedor_id_pago;
                $rexterna->fecha_pago=$fecha_pago;
                $rexterna->precio_reserva=$precio_pago;
                if($rexterna->save())
                    return response()->json(['rpt'=>'1']);
                else
                    return response()->json(['rpt'=>'0']);

            }
            else if($rol=='GUIA'){
                $gexterna=GuiaTransporteExterno::find($transporte_externo_guia_id);
                $gexterna->proveedor_id=$proveedor_id_pago;
                $gexterna->fecha_pago=$fecha_pago;
                $gexterna->precio_reserva=$precio_pago;
                if($gexterna->save())
                    return response()->json(['rpt'=>'1']);
                else
                    return response()->json(['rpt'=>'0']);
            }

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['rpt'=>'0']);
        // }
    }

    public function getReserva(Request $request){
        $valor=$request->input('valor');
        // return response()->json([$request->all()]);
        if(trim($valor)!=''){
        $reserva=Reserva::where('codigo',$valor)->orwhere('nombre','like',"%$valor%")->get();
            return view('admin.encuesta.get-busqueda',compact('reserva'));
        }
    }
}
