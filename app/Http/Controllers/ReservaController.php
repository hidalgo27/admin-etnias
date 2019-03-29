<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Comision;
use App\ReservaComida;
use App\ReservaServicio;
use App\ReservaActividad;
use App\ReservaHospedaje;
use App\ReservaTransporte;
use App\TransporteExterno;
use Illuminate\Http\Request;
use App\ReservaTransporteExterno;
use App\Proveedor;
use App\Guia;

class ReservaController extends Controller
{
    //
    public function lista(){
        $reservas_new=Reserva::where('estado','0')->get();
        $reservas_current=Reserva::where(function($query){
            $query->where('estado','1');
        })
        ->where(function($query){
            $query->WhereHas('actividades',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('comidas',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('hospedajes',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('transporte',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('servicios',function($q){
                $q->where('estado','0');
            });
        })->get();

        $reservas_close=Reserva::where(function($query){
            $query->where('estado','1');
        })
        ->where(function($query){
            $query->WhereHas('actividades',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('comidas',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('hospedajes',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('transporte',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('servicios',function($q){
                $q->where('estado','1');
            });
        })->get();
        return view('admin.reserva.lista',compact('reservas_new','reservas_current','reservas_close'));
    }
    public function detalle($reserva_id){
        $reserva=Reserva::findOrFail($reserva_id);
        $comisiones=Comision::get();
        $transporte_externo=TransporteExterno::get();
        $guia=Guia::get();
        $proveedores=Proveedor::get();
        return view('admin.reserva.detalle',compact('reserva','comisiones','transporte_externo','guia','proveedores'));
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
}
