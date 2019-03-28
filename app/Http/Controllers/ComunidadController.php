<?php

namespace App\Http\Controllers;

use App\Comunidad;
use App\ComunidadFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Departamento;
use App\Provincia;
use App\Distrito;
// use Alert;

class ComunidadController extends Controller
{
    //
    public function getComunidades(){
        $comunidades = Comunidad::get();
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();

        return view('admin.comunidad.lista',compact(['comunidades','departamentos','provincias','distritos']));
    }
    public function nuevo(){
        $departamentos = Departamento::get();
        return view('admin.comunidad.nuevo',compact(['departamentos']));
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        $distrito_id=$request->input('distrito');
        $descripcion=$request->input('descripcion');
        $fotos=$request->file('foto');
        $existencias=Comunidad::where('nombre',$nombre)->count();
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        }
        if($existencias>0){
            return redirect()->back()->with('error','La comunidada ya existe')->withInput();
        }
        else{
            $comunidad=new Comunidad();
            $comunidad->nombre=$nombre;
            $comunidad->descripcion=$descripcion;
            $comunidad->distrito_id=$distrito_id;
            $comunidad->save();
            if(!empty($fotos)){
                foreach($fotos as $foto){
                    $comunidadfoto = new ComunidadFoto();
                    $comunidadfoto->comunidad_id=$comunidad->id;
                    $comunidadfoto->save();

                    $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                    $comunidadfoto->imagen=$filename;
                    $comunidadfoto->save();
                    Storage::disk('comunidades')->put($filename,  File::get($foto));
                }
            }
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('comunidad_nuevo_path')->with('success','Datos guardados');

        }
    }
    public function mostrarProvincias(Request $request){

        $categoria_id=$request->categoria_id;
        $producto_id=$request->producto_id;
        if($request->ajax()){
            $provincias = Provincia::where('departamento_id',$request->departamento_id)->get();
            $data = view('admin.comunidad.mostrar-provincias-ajax',compact('provincias','categoria_id','producto_id'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function mostrarDistritos(Request $request){
        if($request->ajax()){
            $distritos = Distrito::where('provincia_id',$request->provincia_id)->get();
            $data = view('admin.comunidad.mostrar-distritos-ajax',compact('distritos'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function editar(Request $request){
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        $distrito_id=$request->input('distrito');
        $descripcion=$request->input('descripcion');
        $fotos=$request->file('foto');

        $fotosExistentes=$request->input('fotos_');
        // dd($fotosExistentes);
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        }
        $comunidad=Comunidad::find($id);
        $comunidad->nombre=$nombre;
        $comunidad->descripcion=$descripcion;
        $comunidad->distrito_id=$distrito_id;
        $comunidad->save();

        // borramos de la db las fotos que han sido eliminadas por el usuario
        if(count((array)$fotosExistentes)>0){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if(!in_array($value->id,$fotosExistentes)){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        if(!empty($fotos)){
            foreach($fotos as $foto){
                $comunidadfoto = new ComunidadFoto();
                $comunidadfoto->comunidad_id=$comunidad->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                $comunidadfoto->imagen=$filename;
                $comunidadfoto->save();
                Storage::disk('comunidades')->put($filename,  File::get($foto));
            }
        }
        return redirect()->route('comunidad_lista_path')->with('success','Datos editados');
    }
    public function getFoto($filename){
        $file = Storage::disk('comunidades')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id){
        if(Comunidad::destroy($id))
            return 1;
        else
            return 1;
    }
}
