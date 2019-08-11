<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Comunidad;
use App\Proveedor;
use App\Provincia;
use App\Departamento;
use Illuminate\Http\Request;
use App\TipoServicio;
use App\TransporteExternoProveedor;
use App\GuiaProveedor;

class ProveedorController extends Controller
{
    //
    public function lista(){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        $proveedores=Proveedor::get();
        $tipo_servicios=TipoServicio::get();
        return view('admin.proveedor.lista',compact('proveedores','departamentos','provincias','distritos','comunidades','tipo_servicios'));
    }
    public function nuevo($categoria){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        return view('admin.proveedor.nuevo',compact('departamentos','provincias','distritos','categoria'));
    }
    public function mostrarComunidades(Request $request){
        if($request->ajax()){
            $comunidades = Comunidad::where('distrito_id',$request->distrito_id)->get();
            $data = view('admin.asociacion.mostrar-comunidades-ajax',compact('comunidades'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function store(Request $request){
        $categoria=$request->input('categoria');
        $ruc=$request->input('ruc');
        $razon_social=$request->input('razon_social');
        $nombre_comercial=$request->input('nombre_comercial');
        $telefono=$request->input('telefono');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $direccion=$request->input('direccion');
        $plazo=$request->input('plazo');
        $desci=$request->input('desci');
        $departamento_id=$request->input('departamento');
        $provincia_id=$request->input('provincia');
        $distrito_id=$request->input('distrito');

        $existencias=Proveedor::where('ruc',$ruc)->count();
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia,distrito y comunidad')->withInput();
        }
        if($existencias>0){
            return redirect()->back()->with('error','El proveedor con ruc '.$ruc.' ya existe')->withInput();
        }
        else{
            $proveedor=new Proveedor();
            $proveedor->categoria=$categoria;
            $proveedor->ruc=$ruc;
            $proveedor->razon_social=$razon_social;
            $proveedor->nombre_comercial=$nombre_comercial;
            $proveedor->direccion=$direccion;
            $proveedor->telefono=$telefono;
            $proveedor->celular=$celular;
            $proveedor->email=$email;
            $proveedor->plazo=$plazo;
            $proveedor->desci=$desci;
            $proveedor->departamento_id=$departamento_id;
            $proveedor->provincia_id=$provincia_id;
            $proveedor->distrito_id=$distrito_id;
            $proveedor->save();
            // Alert()->success('Datos guardados.')->autoclose(3000);
            return redirect()->route('proveedor.nuevo',$categoria)->with('success','Datos guardados');

        }
    }
    public function getFoto($filename){
        $file = Storage::disk('asociaciones')->get($filename);
        return response($file, 200);
    }
    public function getDelete($id,$tipo){
        $datos=null;
        if($tipo=='TRANSPORTE'){
            $datos=TransporteExternoProveedor::where('proveedor_id',$id)->get();
            if($datos->count()==0){
                if(Proveedor::destroy($id))
                    return 1;
                else
                    return 0;
            }
            else{
                return 2;
            }
        }elseif($tipo=='GUIA'){
            $datos=GuiaProveedor::where('proveedor_id',$id)->get();
            if($datos->count()==0){
                if(Proveedor::destroy($id))
                    return 1;
                else
                    return 0;
            }
            else{
                return 2;
            }
        }
    }
    public function editar(Request $request){

        $id=$request->input('id');
        $rol=$request->input('rol');
        $ruc=$request->input('ruc');
        $razon_social=$request->input('razon_social');
        $nombre_comercial=$request->input('nombre_comercial');
        $telefono=$request->input('telefono');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $direccion=$request->input('direccion');
        $plazo=$request->input('plazo');
        $desci=$request->input('desci');
        $departamento_id=$request->input('departamento');
        $provincia_id=$request->input('provincia');
        $distrito_id=$request->input('distrito');

        // dd($fotosExistentes);
        if(trim($distrito_id)==''||trim($distrito_id)=='0'){
            return redirect()->back()->with('error','escoja un departamento, provincia, distrito y comunidad')->withInput();
        }

        $proveedor=Proveedor::findorfail($id);
        $proveedor->ruc=$ruc;
        $proveedor->razon_social=$razon_social;
        $proveedor->nombre_comercial=$nombre_comercial;
        $proveedor->direccion=$direccion;
        $proveedor->telefono=$telefono;
        $proveedor->celular=$celular;
        $proveedor->email=$email;
        $proveedor->plazo=$plazo;
        $proveedor->desci=$desci;
        $proveedor->departamento_id=$departamento_id;
        $proveedor->provincia_id=$provincia_id;
        $proveedor->distrito_id=$distrito_id;
        $proveedor->save();
        return redirect()->route('proveedor.lista')->with('success','Datos editados');
    }
}
