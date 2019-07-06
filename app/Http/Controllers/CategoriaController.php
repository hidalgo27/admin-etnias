<?php

namespace App\Http\Controllers;


use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    //
    public function getCategorias(){
        $categorias =Categoria::get();
//dd($categorias);
        return view('admin.categoria.lista',compact('categorias'));
    }
    public function nuevo(){
        return view('admin.categoria.nuevo');
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        $portada=$request->file('portada');
        $existencias=Categoria::where('nombre',$nombre)->count();

        if($existencias>0){
            return redirect()->back()->with('error','La categoria ya existe')->withInput();
        }
        else{
            $categoria=new Categoria();
            $categoria->nombre=$nombre;
            $categoria->save();
            if(!empty($portada)){
                // foreach($fotos as $foto){
//                $comunidadfoto = new ComunidadFoto();
//                $comunidadfoto->comunidad_id=$comunidad->id;
//                $comunidadfoto->save();
//
                $filename ='foto-'.$categoria->id.'.'.$portada->getClientOriginalExtension();
                $categoria->imagen=$filename;
//                $comunidadfoto->estado='1';
                $categoria->save();
                Storage::disk('categorias')->put($filename,  File::get($portada));
                // }
            }

            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('categoria_nuevo_path')->with('success','Datos guardados');

        }
    }

    public function editar(Request $request){
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        $distrito_id=$request->input('distrito');
        $descripcion=$request->input('descripcion');
        $historia=$request->input('historia');
        $portada_f=$request->file('portada_f');
        $portada=$request->input('portada');
        $miniatura=$request->input('miniatura');
        $miniatura_f=$request->file('miniatura_f');
        $fotos=$request->file('foto');
        $altura=$request->input('altura');
        $distancia=$request->input('distancia');

        $fotosExistentes=$request->input('fotos_');
        // dd($fotosExistentes);
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia y distrito')->withInput();
        }
        $comunidad=Comunidad::find($id);
        $comunidad->nombre=$nombre;
        $comunidad->descripcion=$descripcion;
        $comunidad->historia=$historia;
        $comunidad->distrito_id=$distrito_id;
        $comunidad->altura=$altura;
        $comunidad->distancia=$distancia;
        $comunidad->save();
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(isset($portada)){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$portada){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
        }

        if(!empty($portada_f)){
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
            // foreach($portada_f as $foto){
            $comunidadfoto = new ComunidadFoto();
            $comunidadfoto->comunidad_id=$comunidad->id;
            $comunidadfoto->save();

            $filename ='foto-'.$comunidadfoto->id.'.'.$portada_f->getClientOriginalExtension();
            $comunidadfoto->imagen=$filename;
            $comunidadfoto->estado='1';
            $comunidadfoto->save();
            Storage::disk('comunidades')->put($filename,  File::get($portada_f));
            // }
        }
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(isset($miniatura)){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if($value->id!=$miniatura){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
        }

        if(!empty($miniatura_f)){
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','2')->delete();
            // foreach($miniatura_f as $foto){
            $comunidadfoto = new ComunidadFoto();
            $comunidadfoto->comunidad_id=$comunidad->id;
            $comunidadfoto->save();

            $filename ='foto-'.$comunidadfoto->id.'.'.$miniatura_f->getClientOriginalExtension();
            $comunidadfoto->imagen=$filename;
            $comunidadfoto->estado='2';
            $comunidadfoto->save();
            Storage::disk('comunidades')->put($filename,  File::get($miniatura_f));
            // }
        }
        // borramos de la db las fotos que han sido eliminadas por el usuario
        if(count((array)$fotosExistentes)>0){
            $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->get();
            foreach ($fotos_existentes as $value) {
                # code...
                if(!in_array($value->id,$fotosExistentes)){
                    ComunidadFoto::find($value->id)->delete();
                }
            }
        }
        else{
            ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','0')->delete();
        }
        if(!empty($fotos)){
            foreach($fotos as $foto){
                $comunidadfoto = new ComunidadFoto();
                $comunidadfoto->comunidad_id=$comunidad->id;
                $comunidadfoto->save();

                $filename ='foto-'.$comunidadfoto->id.'.'.$foto->getClientOriginalExtension();
                $comunidadfoto->imagen=$filename;
                $comunidadfoto->estado='0';
                $comunidadfoto->save();
                Storage::disk('comunidades')->put($filename,  File::get($foto));
            }
        }
        return redirect()->route('comunidad_lista_path')->with('success','Datos editados');
    }
    public function getFoto($filename){
        $file = Storage::disk('categorias')->get($filename);
        return response($file, 200);
    }
}
