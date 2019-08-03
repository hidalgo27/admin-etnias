<?php

namespace App\Http\Controllers;

use App\Comida;
use App\Distrito;
use App\Servicio;
use App\Actividad;
use App\Categoria;
use App\Comunidad;
use App\Hospedaje;
use App\Provincia;
use Carbon\Carbon;
use App\Asociacion;
use App\ComidaFoto;
use App\Transporte;
use App\ComidaPrecio;
use App\Departamento;
use App\ServicioFoto;
use App\ActividadFoto;
use App\HospedajeFoto;
use App\ServicioPrecio;
use App\TransporteFoto;
use App\ActividadPrecio;
use App\HospedajePrecio;
use App\TransportePrecio;
use App\ActividadDisponible;
use Illuminate\Http\Request;
use App\ActividadDisponibleHora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use MaddHatter\LaravelFullcalendar\Calendar;
use App\Mail\MailSenderNotificacionAsociacion;

class ServiciosController extends Controller
{
    //
    public function nuevo($asociacion_id){
        $asociacion=Asociacion::find($asociacion_id);
        $categorias=Categoria::get();
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        return view('admin.servicios.nuevo',compact('categorias','asociacion','asociacion_id','departamentos','provincias','distritos','comunidades'));
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
        $edad_minima=$request->input('edad_minima');
        $dificultad=$request->input('dificultad');
        $tolerancia=$request->input('tolerancia');
        $id_comida=$request->input('id_comida');
        $id_hospedaje=$request->input('id_hospedaje');
        $id_transporte=$request->input('id_transporte');
        $incluye=$request->input('incluye');
        $no_incluye=$request->input('no_incluye');
        $disponible=$request->input('disponible');
        $recomendaciones=$request->input('recomendaciones');

        $fotos=$request->file('foto');
        $foto_portada=$request->file('foto_portada');
        $foto_miniatura=$request->file('foto_miniatura');
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
                $v_comida=0;
                if(isset($id_comida)){
                    $v_comida=1;
                }
                $v_hospedaje=0;
                if(isset($id_hospedaje)){
                    $v_hospedaje=1;
                }
                $v_transporte=0;
                if(isset($id_transporte)){
                    $v_transporte=1;
                }
                $actividad=new Actividad();
                $actividad->titulo=$titulo;
                $actividad->categoria=$categoria_;
                $actividad->descripcion=$descripcion;
                $actividad->duracion=$duracion;
                $actividad->periodo=$periodo;
                $actividad->edad_minima=$edad_minima;
                $actividad->dificultad=$dificultad;
                $actividad->tolerancia=$tolerancia;
                $actividad->in_comida=$v_comida;
                $actividad->in_hospedaje=$v_hospedaje;
                $actividad->in_transporte=$v_transporte;
                $actividad->incluye=$incluye;
                $actividad->no_incluye=$no_incluye;
                $actividad->disponible=$disponible;
                $actividad->recomendaciones=$recomendaciones;
                $actividad->asociacion_id=$asociacion_id;
                if(!Auth::user()->hasRole('admin'))
                    $actividad->estado='0';
                else
                    $actividad->estado='1';
                $actividad->save();
                if(!empty($foto_portada)){

                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto_portada->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->estado='1';
                        $actividadfoto->save();
                        Storage::disk('actividades')->put($filename,  File::get($foto_portada));

                }
                if(!empty($foto_miniatura)){

                    $actividadfoto = new ActividadFoto();
                    $actividadfoto->actividad_id=$actividad->id;
                    $actividadfoto->save();

                    $filename ='foto-'.$actividadfoto->id.'.'.$foto_miniatura->getClientOriginalExtension();
                    $actividadfoto->imagen=$filename;
                    $actividadfoto->estado='2';
                    $actividadfoto->save();
                    Storage::disk('actividades')->put($filename,  File::get($foto_miniatura));

            }
                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->estado='0';
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
                if(!Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad guardada correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad guardada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }

            }
            else if($attributo=='c'){
                $comida=new Comida();
                $comida->titulo=$titulo;
                $comida->descripcion=$descripcion;
                $comida->asociacion_id=$asociacion_id;
                if(!Auth::user()->hasRole('admin'))
                    $comida->estado='0';
                else
                    $comida->estado='1';
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
                if(!Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida guardada correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida guardada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }


            }
            else if($attributo=='h'){
                $hospedaje=new Hospedaje();
                $hospedaje->titulo=$titulo;
                $hospedaje->descripcion=$descripcion;
                $hospedaje->asociacion_id=$asociacion_id;
                if(!Auth::user()->hasRole('admin'))
                    $hospedaje->estado='0';
                else
                    $hospedaje->estado='1';
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
                    $hospedaje_precio->hospedaje_id=$hospedaje->id;
                    $hospedaje_precio->save();

                }
                if(!Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje guardado correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje guardado correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }


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
                    $transporte_precio->tansporte_id=$transporte->id;
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
                    $servicio_precio->servicio_id=$servicio->id;
                    $servicio_precio->save();

                }

                return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Servicio guardado correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
            }
        }
    }
    public function lista($asociacion_id){
        $asociacion=Asociacion::find($asociacion_id);
        $actividades=Actividad::where('asociacion_id',$asociacion_id)->get();
        $comidas=Comida::where('asociacion_id',$asociacion_id)->get();
        $hospedajes=Hospedaje::where('asociacion_id',$asociacion_id)->get();
        $transportes=Transporte::where('asociacion_id',$asociacion_id)->get();
        $servicios=Servicio::where('asociacion_id',$asociacion_id)->get();
        $categorias=Categoria::get();

        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        return view('admin.servicios.lista',compact('asociacion','actividades','comidas','hospedajes','transportes','servicios','categorias','asociacion_id','departamentos','provincias','distritos','comunidades'));
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

        $foto_portada=$request->file('foto_portada');
        $foto_portada_e=$request->input('foto_portada_e');
        $foto_miniatura=$request->file('foto_miniatura');
        $foto_miniatura_e=$request->input('foto_miniatura_e');
        $fotos=$request->file('foto');
        $fotos_e=$request->input('fotos_');
        $categoria_n=$request->input('categoria_n');
        $duracion=$request->input('duracion');
        $periodo=$request->input('periodo');
        $edad_minima=$request->input('edad_minima');
        $dificultad=$request->input('dificultad');
        $tolerancia=$request->input('tolerancia');
        $id_comida=$request->input('id_comida');
        $id_hospedaje=$request->input('id_hospedaje');
        $id_transporte=$request->input('id_transporte');
        $incluye=$request->input('incluye');
        $no_incluye=$request->input('no_incluye');
        $disponible=$request->input('disponible');
        $recomendaciones=$request->input('recomendaciones');

        $minimo_n=$request->input('minimo_'.$attributo.'_n_'.$id);
        $maximo_n=$request->input('maximo_'.$attributo.'_n_'.$id);
        $precio_n=$request->input('precio_'.$attributo.'_n_'.$id);

        $precio_id_e=$request->input('precio_id_e');
        $categoria_e=$request->input('categoria_e');
        $minimo_e=$request->input('minimo_'.$attributo.'_e_'.$id);
        $maximo_e=$request->input('maximo_'.$attributo.'_e_'.$id);
        $precio_e=$request->input('precio_'.$attributo.'_e_'.$id);

        // $mail='fredy1432@gmail.com';
        $mail='misreservas@mietnia.com';
        // $buscar_asociacion= Asociacion::FindOrFail($asociacion_id);
        // if(empty($buscar_asociacion)){
        //     return response()->json(['nombre_clase'=>'alert alert-danger alert-dismissible fade show','mensaje'=>'<strong>Oops!</strong>La asociacion no existe <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //     <span aria-hidden="true">&times;</span>
        //   </button>']);
        // }
        // else{
            if($attributo=='a'){
                $v_comida=0;
                if(isset($id_comida)){
                    $v_comida=1;
                }
                $v_hospedaje=0;
                if(isset($id_hospedaje)){
                    $v_hospedaje=1;
                }
                $v_transporte=0;
                if(isset($id_transporte)){
                    $v_transporte=1;
                }
                $actividad=Actividad::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->categoria=$categoria_;
                $actividad->descripcion=$descripcion;
                $actividad->duracion=$duracion;
                $actividad->periodo=$periodo;
                $actividad->edad_minima=$edad_minima;
                $actividad->dificultad=$dificultad;
                $actividad->tolerancia=$tolerancia;
                $actividad->in_comida=$v_comida;
                $actividad->in_hospedaje=$v_hospedaje;
                $actividad->in_transporte=$v_transporte;
                $actividad->incluye=$incluye;
                $actividad->no_incluye=$no_incluye;
                $actividad->disponible=$disponible;
                $actividad->recomendaciones=$recomendaciones;
                if(!Auth::user()->hasRole('admin'))
                    $actividad->estado='0';
                else
                    $actividad->estado='1';

                $actividad->save();
                //-- agregando foto de portada
                if(!empty($foto_portada_e)){
                    $fotitos=ActividadFoto::where('actividad_id',$id)->where('estado','1')->get();
                    foreach($fotitos as $fotito){
                        if(($fotito->id!=$foto_portada_e)){
                            $temp=ActividadFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ActividadFoto::where('actividad_id',$id)->where('estado','1')->delete();
                }

                if(!empty($foto_portada)){
                    // foreach($foto_portada as $foto){
                        ActividadFoto::where('actividad_id',$id)->where('estado','1')->delete();
                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto_portada->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->estado='1';
                        $actividadfoto->save();
                        Storage::disk('actividades')->put($filename,  File::get($foto_portada));
                    // }
                }
                //-- agregando foto de portada
                if(!empty($foto_miniatura_e)){
                    $fotitos=ActividadFoto::where('actividad_id',$id)->where('estado','2')->get();
                    foreach($fotitos as $fotito){
                        if(($fotito->id!=$foto_miniatura_e)){
                            $temp=ActividadFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ActividadFoto::where('actividad_id',$id)->where('estado','2')->delete();
                }

                if(!empty($foto_miniatura)){
                        ActividadFoto::where('actividad_id',$id)->where('estado','2')->delete();
                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto_miniatura->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->estado='2';
                        $actividadfoto->save();
                        Storage::disk('actividades')->put($filename,  File::get($foto_miniatura));

                }
                //-- agrgando galeria de fotos
                if(!empty($fotos_e)){
                    $fotitos=ActividadFoto::where('actividad_id',$id)->where('estado','0')->get();
                    foreach($fotitos as $fotito){
                        if(!in_array($fotito->id,$fotos_e)){
                            $temp=ActividadFoto::findOrfail($fotito->id);
                            $temp->delete();
                        }
                    }
                }
                else{
                    ActividadFoto::where('actividad_id',$id)->where('estado','0')->delete();
                }

                if(!empty($fotos)){
                    foreach($fotos as $foto){
                        $actividadfoto = new ActividadFoto();
                        $actividadfoto->actividad_id=$actividad->id;
                        $actividadfoto->save();

                        $filename ='foto-'.$actividadfoto->id.'.'.$foto->getClientOriginalExtension();
                        $actividadfoto->imagen=$filename;
                        $actividadfoto->estado='0';
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
                if(!Auth::user()->hasRole('admin')){
                    $asociacion=Asociacion::findOrfail($actividad->asociacion->id);
                    $asociacion_nombre=$asociacion->nombre;
                    $servicio_tipo='actividad';
                    $servicio_nombre=$actividad->titulo;
                    // $mail='misreservas@mietnia.com';
                    Mail::send(new MailSenderNotificacionAsociacion($asociacion_nombre,$servicio_tipo,$servicio_nombre,$mail));
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad editada correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Actividad editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>']);
                }
            }
            else if($attributo=='c'){
                $actividad=Comida::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                if(!Auth::user()->hasRole('admin'))
                    $actividad->estado='0';
                else
                    $actividad->estado='1';
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
                if(!Auth::user()->hasRole('admin')){
                    $asociacion=Asociacion::findOrfail($actividad->asociacion->id);
                    $asociacion_nombre=$asociacion->nombre;
                    $servicio_tipo='comida';
                    $servicio_nombre=$actividad->titulo;
                    // $mail='misreservas@mietnia.com';
                    Mail::send(new MailSenderNotificacionAsociacion($asociacion_nombre,$servicio_tipo,$servicio_nombre,$mail));

                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida editada correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Comida editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>']);
                }

            }
            else if($attributo=='h'){
                $actividad=Hospedaje::FindOrFail($id);
                $actividad->titulo=$titulo;
                $actividad->descripcion=$descripcion;
                if(!Auth::user()->hasRole('admin'))
                    $actividad->estado='0';
                else
                    $actividad->estado='1';
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
                if(!Auth::user()->hasRole('admin')){
                    $asociacion=Asociacion::findOrfail($actividad->asociacion->id);
                    $asociacion_nombre=$asociacion->nombre;
                    $servicio_tipo='hospedaje';
                    $servicio_nombre=$actividad->titulo;

                    Mail::send(new MailSenderNotificacionAsociacion($asociacion_nombre,$servicio_tipo,$servicio_nombre,$mail));

                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje editado correctamente, comuniquese con el administrador para aprobar sus cambios. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>']);
                }
                elseif(Auth::user()->hasRole('admin')){
                    return response()->json(['nombre_clase'=>'alert alert-success alert-dismissible fade show','mensaje'=>'<strong>Genial!</strong>Hospedaje editada correctamente. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>']);
                }

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
        $hora=$request->input('hora');

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

                    // creamos las horas disponibles
                    foreach($hora as $hora_){
                        $hora_disponible=new ActividadDisponibleHora();
                        $hora_disponible->hora=$hora_;
                        $hora_disponible->actividad_disponible_id=$temp->id;
                        $hora_disponible->save();
                    }

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
                $f1=explode('/',$fecha1);
                // return $value;
                $f=$f1[2].'-'.$f1[0].'-'.$f1[1];
                // return $f;
                $existe=ActividadDisponible::where('actividad_id',$id)->where('fecha',$f)->get();
                if($existe->count()==0){
                    $temp=new ActividadDisponible();
                    $temp->cantidad='0';
                    $temp->fecha=$f;
                    $temp->estado='0';
                    $temp->actividad_id=$id;
                    $temp->save();
                }
                else{
                    $existe=ActividadDisponible::where('actividad_id',$id)->where('fecha',$f)->first();
                    $existe->cantidad='0';
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

        $rpt1=ActividadDisponible::where('actividad_id',$actividad_id)->where('fecha',$fecha)->first();
        $hora=ActividadDisponibleHora::where('actividad_disponible_id',$rpt1->id)->delete();

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
