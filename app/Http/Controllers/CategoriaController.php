<?php

namespace App\Http\Controllers;


use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Actividad;

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
        $portada_f=$request->file('portada_f');
        $portada=$request->input('portada');
        // dd($fotosExistentes);
        $categoria=Categoria::find($id);
        $categoria->nombre=$nombre;
        $categoria->save();
        // borramos de la db la foto de portada que han sido eliminadas por el usuario
        if(!isset($portada)){
            // $fotos_existentes=ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->get();
            $categoria->imagen='';
            $categoria->save();
        }
        // else{
        //     ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
        // }

        if(!empty($portada_f)){
            // ComunidadFoto::where('comunidad_id',$comunidad->id)->where('estado','1')->delete();
            // // foreach($portada_f as $foto){
            // $comunidadfoto = new ComunidadFoto();
            // $comunidadfoto->comunidad_id=$comunidad->id;
            // $comunidadfoto->save();

            $filename ='foto-'.$categoria->id.'.'.$portada_f->getClientOriginalExtension();
            $categoria->imagen=$filename;
            // $comunidadfoto->estado='1';
            $categoria->save();
            Storage::disk('categorias')->put($filename,  File::get($portada_f));
            // }
        }


        return redirect()->route('categoria_lista_path')->with('success','Datos editados');
    }
    public function getFoto($filename){
        $file = Storage::disk('categorias')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id){
        $categoria=Categoria::find($id);
        $actividades_con_categoria=Actividad::where('categoria',$categoria->nombre)->count('id');
        if($actividades_con_categoria>0){
            return 2;
        }
        else{
            if($categoria->delete())
                return 1;
            else
                return 0;
        }
    }
}
