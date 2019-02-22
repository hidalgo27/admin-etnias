<?php

namespace App\Http\Controllers;

use App\Comida;
use App\Servicio;
use App\Actividad;
use App\Hospedaje;
use App\Asociacion;
use App\ComidaFoto;
use App\Transporte;
use App\ComidaPrecio;
use App\ActividadFoto;
use App\ActividadPrecio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request){
        $attributo=$request->input('attributo');
        $v_asociacion_id=$attributo.'_asociacion_id';
        $asociacion_id=$request->input($v_asociacion_id);
        $titulo=strtolower(trim($request->input('titulo')));
        $descripcion=$request->input('descripcion');
        $fotos=$request->file('foto');
        $categoria=$request->input('categoria');
        $minimo=$request->input('minimo_'.$attributo);
        $maximo=$request->input('maximo_'.$attributo);
        $precio=$request->input('precio_'.$attributo);
        $buscar_asociacion= Asociacion::FindOrFail($asociacion_id);
        if(empty($buscar_asociacion)){
            return response()->json(['nombre_clase'=>'alert alert-danger alert-dismissible fade show','mensaje'=>'<strong>Oops!</strong>La asociacion no existe <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>']);
        }
        else{
            if($attributo=='a'){
                $actividad=new Actividad();
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                $actividad->asociacion_id=$asociacion_id;
                $actividad->save();
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->save();
                        Storage::disk('actividades')->put($filename,  File::get($foto));
                    }
                }
                foreach ($categoria as $key => $value) {
                    $actividad_precio=new ActividadPrecio();
                    $actividad_precio->categoria=$value;
                    $actividad_precio->min=$minimo[$key];
                    $actividad_precio->max=$maximo[$key];
                    $actividad_precio->precio=$precio[$key];
                    $actividad_precio->actividad_id=$actividad->id;
                    $actividad_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad guardada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='c'){
                $comida=new Comida();
                $comida->titulo=$titulo;
                $comida->descripcion=$descripcion;
                $comida->asociacion_id=$asociacion_id;
                $comida->save();
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $comidafoto = new ComidaFoto();
                        $comidafoto->comida_id=$comida->id;
                        $comidafoto->save();

                        $filename ='foto-'.$comidafoto->id.'.'.$foto->getClientOriginalExtension();
                        $comidafoto->imagen=$filename;
                        $comidafoto->save();
                        Storage::disk('comidas')->put($filename,  File::get($foto));
                    }
                }
                foreach ($categoria as $key => $value) {
                    $comida_precio=new ComidaPrecio();
                    $comida_precio->categoria=$value;
                    $comida_precio->min=$minimo[$key];
                    $comida_precio->max=$maximo[$key];
                    $comida_precio->precio=$precio[$key];
                    $comida_precio->comida_id=$comida->id;
                    $comida_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida guardada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='h'){
                $hospedaje=new Hospedaje();
                $hospedaje->titulo=$titulo;
                $hospedaje->descripcion=$descripcion;
                $hospedaje->asociacion_id=$asociacion_id;
                $hospedaje->save();
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $hospedajefoto = new HospedajeFoto();
                        $hospedajefoto->comida_id=$hospedaje->id;
                        $hospedajefoto->save();

                        $filename ='foto-'.$hospedajefoto->id.'.'.$foto->getClientOriginalExtension();
                        $hospedajefoto->imagen=$filename;
                        $hospedajefoto->save();
                        Storage::disk('hospedajes')->put($filename,  File::get($foto));
                    }
                }
                foreach ($categoria as $key => $value) {
                    $hospedaje_precio=new HospedajePrecio();
                    $hospedaje_precio->categoria=$value;
                    $hospedaje_precio->min=$minimo[$key];
                    $hospedaje_precio->max=$maximo[$key];
                    $hospedaje_precio->precio=$precio[$key];
                    $hospedaje_precio->comida_id=$hospedaje->id;
                    $hospedaje_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje guardado correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='t'){
                $transporte=new Transporte();
                $transporte->titulo=$titulo;
                $transporte->descripcion=$descripcion;
                $transporte->asociacion_id=$asociacion_id;
                $transporte->save();
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $transportefoto = new TransporteFoto();
                        $transportefoto->comida_id=$transporte->id;
                        $transportefoto->save();

                        $filename ='foto-'.$transportefoto->id.'.'.$foto->getClientOriginalExtension();
                        $transportefoto->imagen=$filename;
                        $transportefoto->save();
                        Storage::disk('transportes')->put($filename,  File::get($foto));
                    }
                }
                foreach ($categoria as $key => $value) {
                    $transporte_precio=new TransportePrecio();
                    $transporte_precio->categoria=$value;
                    $transporte_precio->min=$minimo[$key];
                    $transporte_precio->max=$maximo[$key];
                    $transporte_precio->precio=$precio[$key];
                    $transporte_precio->comida_id=$transporte->id;
                    $transporte_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Transporte guardado correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='s'){
                $servicio=new Servicio();
                $servicio->titulo=$titulo;
                $servicio->descripcion=$descripcion;
                $servicio->asociacion_id=$asociacion_id;
                $servicio->save();
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $serviciofoto = new ServicioFoto();
                        $serviciofoto->comida_id=$servicio->id;
                        $serviciofoto->save();

                        $filename ='foto-'.$serviciofoto->id.'.'.$foto->getClientOriginalExtension();
                        $serviciofoto->imagen=$filename;
                        $serviciofoto->save();
                        Storage::disk('Servicios')->put($filename,  File::get($foto));
                    }
                }
                foreach ($categoria as $key => $value) {
                    $servicio_precio=new ServicioPrecio();
                    $servicio_precio->categoria=$value;
                    $servicio_precio->min=$minimo[$key];
                    $servicio_precio->max=$maximo[$key];
                    $servicio_precio->precio=$precio[$key];
                    $servicio_precio->comida_id=$servicio->id;
                    $servicio_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Servicio guardado correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
        }
    }
    public function lista(){
        return view('admin.servicios.lista');
    }
    public function buscar_servicios($ruc_rs){
        $asociacion=Asociacion::where('ruc',$ruc_rs)->orwhere('nombre','like','%'.$ruc_rs.'%')->first();
        $actividades=Actividad::where('asociacion_id',$asociacion->id)->get();
        $comidas=Comida::where('asociacion_id',$asociacion->id)->get();
        $hospedajes=Hospedaje::where('asociacion_id',$asociacion->id)->get();
        $transporte=Transporte::where('asociacion_id',$asociacion->id)->get();
        $servicios=Servicio::where('asociacion_id',$asociacion->id)->get();

        return view('admin.servicios.buscar-servicios',compact('asociacion','actividades','comidas','hospedajes','transporte','servicios'));
    }
    public function showFoto($filename,$storage){
        $file = Storage::disk($storage)->get($filename);
        return response($file, 200);
    }
}
