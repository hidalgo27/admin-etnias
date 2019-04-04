<?php

namespace App\Http\Controllers;

use App\Comida;
use App\Servicio;
use App\Actividad;
use App\Categoria;
use App\Hospedaje;
use Carbon\Carbon;
use App\Asociacion;
use App\ComidaFoto;
use App\Transporte;
use App\ComidaPrecio;
use App\ActividadFoto;
use App\ActividadPrecio;
use App\ActividadDisponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use MaddHatter\LaravelFullcalendar\Calendar;

class ServiciosController extends Controller
{
    //
    public function nuevo(Request $request){

        $categorias=Categoria::get();
        return view('admin.servicios.nuevo',compact('categorias'));
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
        $categoria_=$request->input('categoria_');
        $descripcion=$request->input('descripcion');
        $duracion=$request->input('duracion');
        $periodo=$request->input('periodo');
        $incluye=$request->input('incluye');
        $no_incluye=$request->input('no_incluye');
        $disponible=$request->input('disponible');

        $fotos=$request->file('foto');
        $categoria=$request->input('categoria_n');
        $minimo=$request->input('minimo_'.$attributo.'_n_0');
        $maximo=$request->input('maximo_'.$attributo.'_n_0');
        $precio=$request->input('precio_'.$attributo.'_n_0');
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
                $actividad->categoria=$categoria_;
                $actividad->descripcion=$descripcion;
                $actividad->duracion=$duracion;
                $actividad->periodo=$periodo;
                $actividad->incluye=$incluye;
                $actividad->no_incluye=$no_incluye;
                $actividad->disponible=$disponible;
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
        $transportes=Transporte::where('asociacion_id',$asociacion->id)->get();
        $servicios=Servicio::where('asociacion_id',$asociacion->id)->get();
        $categorias=Categoria::get();

        return view('admin.servicios.buscar-servicios',compact('asociacion','actividades','comidas','hospedajes','transportes','servicios','categorias'));
    }
    public function showFoto($filename,$storage){
        $file = Storage::disk($storage)->get($filename);
        return response($file, 200);
    }
    public function edit(Request $request){
        $attributo=$request->input('attributo');
        $id=$request->input('id');
        // $v_asociacion_id=$attributo.'_asociacion_id';
        // $asociacion_id=$request->input('id');

        $categoria_=$request->input('categoria_');
        $titulo=strtolower(trim($request->input('titulo')));
        $descripcion=$request->input('descripcion');
        $fotos=$request->file('foto');
        $fotos_e=$request->file('fotos');
        $categoria_n=$request->input('categoria_n');
        $duracion=$request->input('duracion');
        $periodo=$request->input('periodo');
        $incluye=$request->input('incluye');
        $no_incluye=$request->input('no_incluye');
        $disponible=$request->input('disponible');

        $minimo_n=$request->input('minimo_'.$attributo.'_n_'.$id);
        $maximo_n=$request->input('maximo_'.$attributo.'_n_'.$id);
        $precio_n=$request->input('precio_'.$attributo.'-n_'.$id);

        $precio_id_e=$request->input('precio_id_e');
        $categoria_e=$request->input('categoria_e');
        $minimo_e=$request->input('minimo_'.$attributo.'_e_'.$id);
        $maximo_e=$request->input('maximo_'.$attributo.'_e_'.$id);
        $precio_e=$request->input('precio_'.$attributo.'_e_'.$id);
        // $buscar_asociacion= Asociacion::FindOrFail($asociacion_id);
        // if(empty($buscar_asociacion)){
        //     return response()->json(['nombre_clase'=>'alert alert-danger alert-dismissible fade show','mensaje'=>'<strong>Oops!</strong>La asociacion no existe <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //     <span aria-hidden="true">&times;</span>
        //   </button>']);
        // }
        // else{
            if($attributo=='a'){
                $actividad=Actividad::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->categoria=$categoria_;
                $actividad->descripcion=$descripcion;
                $actividad->duracion=$duracion;
                $actividad->periodo=$periodo;
                $actividad->incluye=$incluye;
                $actividad->no_incluye=$no_incluye;
                $actividad->disponible=$disponible;
                $actividad->save();
                if(!empty($fotos_e)){
                    $fotitos=ActividadFoto::where('actividad_id',$id)->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=ActividadFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ActividadFoto::where('actividad_id',$id)->delete();
                }

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
                if(!empty($precio_id_e)){
                    $precios=ActividadPrecio::where('actividad_id',$id)->get();
                    foreach($precios as $precio){
                        if(!in_array($precio->id,$precio_id_e)){
                            $actividad_precio=ActividadPrecio::findOrfail($precio->id);
                            $actividad_precio->delete();
                        }
                        else{
                            foreach($precio_id_e as $key => $value){
                                if($value==$precio->id){
                                    $actividad_precio=ActividadPrecio::findOrfail($precio->id);
                                    $actividad_precio->categoria=$categoria_e[$key];
                                    $actividad_precio->min=$minimo_e[$key];
                                    $actividad_precio->max=$maximo_e[$key];
                                    $actividad_precio->precio=$precio_e[$key];
                                    $actividad_precio->save();
                                }
                            }
                        }
                    }
                }
                else{
                    ActividadPrecio::where('actividad_id',$id)->delete();
                }
                if(!empty($categoria_n)){
                    foreach ($categoria_n as $key => $value) {
                        $actividad_precio=new ActividadPrecio();
                        $actividad_precio->categoria=$value;
                        $actividad_precio->min=$minimo_n[$key];
                        $actividad_precio->max=$maximo_n[$key];
                        $actividad_precio->precio=$precio_n[$key];
                        $actividad_precio->actividad_id=$id;
                        $actividad_precio->save();
                    }
                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='c'){
                $actividad=Comida::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                $actividad->save();
                if(!empty($fotos_e)){
                    $fotitos=ComidaFoto::where('comida_id',$id)->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=ComidaFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ComidaFoto::where('comida_id',$id)->delete();
                }

                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new ComidaFoto();
                        $actividadfoto->actividad_id=$id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->save();
                        Storage::disk('comidas')->put($filename,  File::get($foto));
                    }
                }
                if(!empty($precio_id_e)){
                    $precios=ComidaPrecio::where('comida_id',$id)->get();
                    foreach($precios as $precio){
                        if(!in_array($precio->id,$precio_id_e)){
                            $actividad_precio=ComidaPrecio::findOrfail($precio->id);
                            $actividad_precio->delete();
                        }
                        else{
                            foreach($precio_id_e as $key => $value){
                                if($value==$precio->id){
                                    $actividad_precio=ComidaPrecio::findOrfail($precio->id);
                                    $actividad_precio->categoria=$categoria_e[$key];
                                    $actividad_precio->min=$minimo_e[$key];
                                    $actividad_precio->max=$maximo_e[$key];
                                    $actividad_precio->precio=$precio_e[$key];
                                    $actividad_precio->save();
                                }
                            }
                        }
                    }
                }
                else{
                    ComidaPrecio::where('comida_id',$id)->delete();
                }
                if(!empty($categoria_n)){
                    foreach ($categoria_n as $key => $value) {
                        $actividad_precio=new ComidaPrecio();
                        $actividad_precio->categoria=$value;
                        $actividad_precio->min=$minimo_n[$key];
                        $actividad_precio->max=$maximo_n[$key];
                        $actividad_precio->precio=$precio_n[$key];
                        $actividad_precio->comida_id=$id;
                        $actividad_precio->save();
                    }
                }
                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='h'){
                $actividad=Hospedaje::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                $actividad->save();
                if(!empty($fotos_e)){
                    $fotitos=HospedajeFoto::where('hospedaje_id',$id)->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=HospedajeFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    HospedajeFoto::where('hospedaje_id',$id)->delete();
                }

                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new HospedajeFoto();
                        $actividadfoto->hospedaje_id=$id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->save();
                        Storage::disk('actividades')->put($filename,  File::get($foto));
                    }
                }
                if(!empty($precio_id_e)){
                    $precios=HospedajePrecio::where('hospedaje_id',$id)->get();
                    foreach($precios as $precio){
                        if(!in_array($precio->id,$precio_id_e)){
                            $actividad_precio=HospedajePrecio::findOrfail($precio->id);
                            $actividad_precio->delete();
                        }
                        else{
                            foreach($precio_id_e as $key => $value){
                                if($value==$precio->id){
                                    $actividad_precio=HospedajePrecio::findOrfail($precio->id);
                                    $actividad_precio->categoria=$categoria_e[$key];
                                    $actividad_precio->min=$minimo_e[$key];
                                    $actividad_precio->max=$maximo_e[$key];
                                    $actividad_precio->precio=$precio_e[$key];
                                    $actividad_precio->save();
                                }
                            }
                        }
                    }
                }
                else{
                    HospedajePrecio::where('hospedaje_id',$id)->delete();
                }
                if(!empty($categoria_n)){
                    foreach ($categoria_n as $key => $value) {
                        $actividad_precio=new HospedajePrecio();
                        $actividad_precio->categoria=$value;
                        $actividad_precio->min=$minimo_n[$key];
                        $actividad_precio->max=$maximo_n[$key];
                        $actividad_precio->precio=$precio_n[$key];
                        $actividad_precio->hospedaje_id=$id;
                        $actividad_precio->save();
                    }
                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='t'){
                $actividad=Transporte::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                $actividad->save();
                if(!empty($fotos_e)){
                    $fotitos=TransporteFoto::where('transporte_id',$id)->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=TransporteFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    TransporteFoto::where('transporte_id',$id)->delete();
                }

                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new TransporteFoto();
                        $actividadfoto->actividad_id=$transporte_id->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->save();
                        Storage::disk('transportes')->put($filename,  File::get($foto));
                    }
                }
                if(!empty($precio_id_e)){
                    $precios=TransportePrecio::where('transporte_id',$id)->get();
                    foreach($precios as $precio){
                        if(!in_array($precio->id,$precio_id_e)){
                            $actividad_precio=TransportePrecio::findOrfail($precio->id);
                            $actividad_precio->delete();
                        }
                        else{
                            foreach($precio_id_e as $key => $value){
                                if($value==$precio->id){
                                    $actividad_precio=TransportePrecio::findOrfail($precio->id);
                                    $actividad_precio->categoria=$categoria_e[$key];
                                    $actividad_precio->min=$minimo_e[$key];
                                    $actividad_precio->max=$maximo_e[$key];
                                    $actividad_precio->precio=$precio_e[$key];
                                    $actividad_precio->save();
                                }
                            }
                        }
                    }
                }
                else{
                    TransportePrecio::where('transporte_id',$id)->delete();
                }
                if(!empty($categoria_n)){
                    foreach ($categoria_n as $key => $value) {
                        $actividad_precio=new TransportePrecio();
                        $actividad_precio->categoria=$value;
                        $actividad_precio->min=$minimo_n[$key];
                        $actividad_precio->max=$maximo_n[$key];
                        $actividad_precio->precio=$precio_n[$key];
                        $actividad_precio->transporte_id=$id;
                        $actividad_precio->save();
                    }
                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Transporte editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
            else if($attributo=='s'){
                $actividad=Servicio::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                $actividad->save();
                if(!empty($fotos_e)){
                    $fotitos=ServicioFoto::where('servicio_id',$id)->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=ServicioFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ServicioFoto::where('servicio_id',$id)->delete();
                }

                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new ServicioFoto();
                        $actividadfoto->servicio_id=$id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->save();
                        Storage::disk('servicios')->put($filename,  File::get($foto));
                    }
                }
                if(!empty($precio_id_e)){
                    $precios=ServicioPrecio::where('servicio_id',$id)->get();
                    foreach($precios as $precio){
                        if(!in_array($precio->id,$precio_id_e)){
                            $actividad_precio=ServicioPrecio::findOrfail($precio->id);
                            $actividad_precio->delete();
                        }
                        else{
                            foreach($precio_id_e as $key => $value){
                                if($value==$precio->id){
                                    $actividad_precio=ServicioPrecio::findOrfail($precio->id);
                                    $actividad_precio->categoria=$categoria_e[$key];
                                    $actividad_precio->min=$minimo_e[$key];
                                    $actividad_precio->max=$maximo_e[$key];
                                    $actividad_precio->precio=$precio_e[$key];
                                    $actividad_precio->save();
                                }
                            }
                        }
                    }
                }
                else{
                    ServicioPrecio::where('servicio_id',$id)->delete();
                }
                if(!empty($categoria_n)){
                    foreach ($categoria_n as $key => $value) {
                        $actividad_precio=new ServicioPrecio();
                        $actividad_precio->categoria=$value;
                        $actividad_precio->min=$minimo_n[$key];
                        $actividad_precio->max=$maximo_n[$key];
                        $actividad_precio->precio=$precio_n[$key];
                        $actividad_precio->servicio_id=$id;
                        $actividad_precio->save();
                    }
                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Servicio editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
        // }
    }
    public function getDelete($id,$atributo){
        if($atributo=='a'){
            if( Actividad::destroy($id))
                return 1;
            else
                return 0;
        }
        if($atributo=='c'){
            if( Comida::destroy($id))
                return 1;
            else
                return 0;
        }
        if($atributo=='h'){
            if( Hospedaje::destroy($id))
                return 1;
            else
                return 0;
        }
        if($atributo=='t'){
            if( Transporte::destroy($id))
                return 1;
            else
                return 0;
        }
        if($atributo=='s'){
            if( Servicio::destroy($id))
                return 1;
            else
                return 0;
        }
    }

    public function add_calendario(Request $request){
        $cantidad=$request->input('cantidad');
        $fecha1=$request->input('fecha_add');
        $fecha=explode(',',$fecha1);
        $start = Carbon::createFromFormat('m/d/Y', $fecha[0]);
        $end = Carbon::createFromFormat('m/d/Y', $fecha[1]);

        $dates = [];

        while ($start->lte($end)) {

            $dates[] = $start->copy()->format('Y-m-d');

            $start->addDay();
        }

        $id=$request->input('id');
        if(count($dates)>0){
            foreach ($dates as $key => $value) {
                // return '.'.$value.'.';
                // $f1=explode('/',$value);
                // return $value;
                // $f=$f1[2].'-'.$f1[0].'-'.$f1[1];
                $existe=ActividadDisponible::where('actividad_id',$id)->where('fecha',$value)->get();
                if($existe->count()==0){
                    $temp=new ActividadDisponible();
                    $temp->cantidad=$cantidad;
                    $temp->fecha=$value;
                    $temp->estado='1';
                    $temp->actividad_id=$id;
                    $temp->save();
                    $item=Actividad::find($id);
                }
            }
            $item=Actividad::find($id);
            return view('admin.servicios.calendario-actual',compact('item'));
        }
        else
            return '1';

        // return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Servicio editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //         <span aria-hidden="true">&times;</span>
        //       </button>']);
    }
    public function add_calendario_d(Request $request){
        $cantidad=$request->input('cantidad');
        $fecha1=$request->input('fecha_d');
        // $fecha=explode(',',$fecha1);
        // $start = Carbon::createFromFormat('m/d/Y', $fecha[0]);
        // $end = Carbon::createFromFormat('m/d/Y', $fecha[1]);

        // $dates = [];

        // while ($start->lte($end)) {

        //     $dates[] = $start->copy()->format('Y-m-d');

        //     $start->addDay();
        // }

        $id=$request->input('id');
        if(strlen($fecha1)>0){
            // foreach ($dates as $key => $value) {
                // return '.'.$value.'.';
                // $f1=explode('/',$value);
                // return $value;
                $f=$fecha1[2].'-'.$fecha1[0].'-'.$fecha1[1];
                $existe=ActividadDisponible::where('actividad_id',$id)->where('fecha',$f)->get();
                if($existe->count()==0){
                    $temp=new ActividadDisponible();
                    $temp->cantidad=$cantidad;
                    $temp->fecha=$f;
                    $temp->estado='0';
                    $temp->actividad_id=$id;
                    $temp->save();
                }
                else{
                    $existe=ActividadDisponible::where('actividad_id',$id)->where('fecha',$f)->first();
                    $existe->cantidad=0;
                    $existe->estado='0';
                    $existe->save();
                }
            // }
            $item=Actividad::find($id);
            return view('admin.servicios.calendario-actual',compact('item'));
        }
        else
            return '1';

        // return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Servicio editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //         <span aria-hidden="true">&times;</span>
        //       </button>']);
    }
    public function calendario_eliminar(Request $request){
        $actividad_id=$request->input('actividad_id');
        $fecha_=$request->input('fecha');
        $f=explode('-',$fecha_);
        $fecha = $f[2].'-'.$f[1].'-'.$f[0];
        $rpt=ActividadDisponible::where('actividad_id',$actividad_id)->where('fecha',$fecha)->delete();
        if($rpt>0){
            // return view('servicios..');
            $item=Actividad::find($actividad_id);
            return view('admin.servicios.calendario-actual',compact('item'));
        }
        else
            return '0';

    }
}
