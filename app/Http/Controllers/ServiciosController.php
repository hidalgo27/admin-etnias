<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Asociacion;
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
    public function actividad_store(Request $request){
        $asociacion_id=$request->input('actividad_asociacion_id');
        $titulo=strtolower(trim($request->input('titulo')));
        $descripcion=$request->input('descripcion');
        $fotos=$request->file('foto');
        $categoria=$request->input('categoria');
        $minimo=$request->input('minimo');
        $maximo=$request->input('maximo');
        $precio=$request->input('precio');
        $buscar_actividad=Asociacion::FindOrFail($asociacion_id);

        // return response()->json(['aa'=>$request->all()]);
        if(empty($buscar_actividad)){
            return response()->json(['nombre_clase'=>'alert alert-danger alert-dismissible fade show','mensaje'=>'<strong>Oops!</strong>La asociacion no existe <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>']);
        }
        else{
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
    }

}
