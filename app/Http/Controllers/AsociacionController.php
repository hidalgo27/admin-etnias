<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Comunidad;
use App\Provincia;
use App\Asociacion;
use App\Departamento;
use App\AsociacionFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AsociacionController extends Controller
{
    //
    public function lista(){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        $asociaciones=Asociacion::all();
        return view('admin.asociacion.lista',compact('asociaciones','departamentos','provincias','distritos','comunidades'));
    }
    public function nuevo(){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        $asociaciones=Asociacion::all();
        return view('admin.asociacion.nuevo',compact('asociaciones','departamentos','provincias','distritos','comunidades'));
    }
    public function mostrarComunidades(Request $request){
        if($request->ajax()){
            $comunidades = Comunidad::where('distrito_id',$request->distrito_id)->get();
            $data = view('admin.asociacion.mostrar-comunidades-ajax',compact('comunidades'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function store(Request $request){
        $ruc=$request->input('ruc');
        $nombre=$request->input('nombre');
        $descripcion=$request->input('descripcion');
        $contacto=$request->input('contacto');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $direccion=$request->input('direccion');
        $comunidad_id=$request->input('comunidad');
        $comision=$request->input('comision');
        $portada=$request->file('portada');
        $fotos=$request->file('foto');
        $existencias=Asociacion::where('nombre',$ruc)->count();
        if(trim($comunidad_id)==''||trim($comunidad_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia,distrito y comunidad')->withInput();
        }
        if($existencias>0){
            return redirect()->back()->with('error','La Asociacion con ruc '.$ruc.' ya existe')->withInput();
        }
        else{
            $asociacion=new Asociacion();
            $asociacion->ruc=$ruc;
            $asociacion->nombre=$nombre;
            $asociacion->contacto=$contacto;
            $asociacion->celular=$celular;
            $asociacion->email=$email;
            $asociacion->direccion=$direccion;
            $asociacion->comision=$comision;
            $asociacion->descripcion=$descripcion;
            $asociacion->comunidad_id=$comunidad_id;
            $asociacion->save();
            if(!empty($portada)){
                // foreach($fotos as $foto){
                    $asociacionfoto = new AsociacionFoto();
                    $asociacionfoto->asociacion_id=$asociacion->id;
                    $asociacionfoto->save();

                    $filename ='foto-'.$asociacionfoto->id.'.'.$portada->getClientOriginalExtension();
                    $asociacionfoto->imagen=$filename;
                    $asociacionfoto->estado='1';
                    $asociacionfoto->save();
                    Storage::disk('asociaciones')->put($filename,  File::get($portada));
                // }
            }
            if(!empty($fotos)){
                foreach($fotos as $foto){
                    $asociacionfoto = new AsociacionFoto();
                    $asociacionfoto->asociacion_id=$asociacion->id;
                    $asociacionfoto->save();

                    $filename ='foto-'.$asociacionfoto->id.'.'.$foto->getClientOriginalExtension();
                    $asociacionfoto->imagen=$filename;
                    $asociacionfoto->estado='0';
                    $asociacionfoto->save();
                    Storage::disk('asociaciones')->put($filename,  File::get($foto));
                }
            }
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('asociacion.nuevo')->with('success','Datos guardados');

        }
    }
    public function getFoto($filename){
        $file = Storage::disk('asociaciones')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id){
        if(Asociacion::destroy($id))
            return 1;
        else
            return 1;
    }
    public function editar(Request $request){

        $id=$request->input('id');
        $ruc=$request->input('ruc');
        $nombre=$request->input('nombre');

        $descripcion=$request->input('descripcion');
        $contacto=$request->input('contacto');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $direccion=$request->input('direccion');

        $comision=$request->input('comision');
        $comunidad_id=$request->input('comunidad');
        $portada_f=$request->file('portada_f');
        $portada=$request->input('portada');
        $fotos=$request->file('foto');
        $fotosExistentes=$request->input('fotos_');
        // dd($fotosExistentes);
        if(trim($comunidad_id)==''||trim($comunidad_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia, distrito y comunidad')->withInput();
        }

        $asociacion=Asociacion::findorfail($id);
        $asociacion->ruc=$ruc;
        $asociacion->nombre=$nombre;
        $asociacion->contacto=$contacto;
        $asociacion->celular=$celular;
        $asociacion->email=$email;
        $asociacion->direccion=$direccion;
        $asociacion->comision=$comision;
        $asociacion->descripcion=$descripcion;        
        $asociacion->comunidad_id=$comunidad_id;
        $asociacion->save();

        // borramos de la db las fotos que han sido eliminadas por el usuario
        if(isset($portada)){
            $fotos_existentes=AsociacionFoto::where('asociacion_id',$asociacion->id)->where('estado','1')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$portada){
                    AsociacionFoto::find($value->id)->delete();
                }
            }
        }
        else{
            AsociacionFoto::where('asociacion_id',$asociacion->id)->where('estado','1')->delete();
        }
        if(!empty($portada_f)){
            // foreach($fotos as $foto){
                AsociacionFoto::where('asociacion_id',$asociacion->id)->where('estado','1')->delete();
                $asociacionfoto = new AsociacionFoto();
                $asociacionfoto->asociacion_id=$asociacion->id;
                $asociacionfoto->save();

                $filename ='foto-'.$asociacionfoto->id.'.'.$portada_f->getClientOriginalExtension();
                $asociacionfoto->imagen=$filename;
                $asociacionfoto->estado='1';
                $asociacionfoto->save();
                Storage::disk('asociaciones')->put($filename,  File::get($portada_f));
            // }
        }
        // borramos de la db las fotos que han sido eliminadas por el usuario
        if(count((array)$fotosExistentes)>0){
            $fotos_existentes=AsociacionFoto::where('asociacion_id',$asociacion->id)->where('estado','0')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if(!in_array($value->id,$fotosExistentes)){
                    AsociacionFoto::find($value->id)->delete();
                }
            }
        }
        else{
           AsociacionFoto::where('asociacion_id',$asociacion->id)->where('estado','0')->delete();

        }
        if(!empty($fotos)){
            foreach($fotos as $foto){
                $asociacionfoto = new AsociacionFoto();
                $asociacionfoto->asociacion_id=$asociacion->id;
                $asociacionfoto->save();

                $filename ='foto-'.$asociacionfoto->id.'.'.$foto->getClientOriginalExtension();
                $asociacionfoto->imagen=$filename;
                $asociacionfoto->estado='0';
                $asociacionfoto->save();
                Storage::disk('asociaciones')->put($filename,  File::get($foto));
            }
        }
        return redirect()->route('asociacion.lista')->with('success','Datos editados');
    }
}
