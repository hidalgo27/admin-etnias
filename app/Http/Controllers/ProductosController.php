<?php
namespace App\Http\Controllers;

use App\Guia;
use App\Distrito;
use App\Comunidad;
use App\Proveedor;
use App\Provincia;
use App\Departamento;
use App\TipoServicio;
use App\GuiaProveedor;
use App\TransporteExterno;
use Illuminate\Http\Request;
use App\TransporteExternoProveedor;

class ProductosController extends Controller
{
    //
    public function lista(){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $comunidades = Comunidad::get();
        $proveedores=Proveedor::get();
        $tipo_servicios=TipoServicio::get();
        return view('admin.producto.lista',compact('proveedores','departamentos','provincias','distritos','comunidades','tipo_servicios'));
    }
    public function nuevo($categoria){
        $departamentos =Departamento::get();
        $provincias =Provincia::get();
        $distritos =Distrito::get();
        $proveedores=Proveedor::get();
        return view('admin.producto.nuevo',compact('departamentos','provincias','distritos','categoria','proveedores'));
    }
    public function mostrarComunidades(Request $request){
        if($request->ajax()){
            $comunidades = Comunidad::where('distrito_id',$request->distrito_id)->get();
            $data = view('admin.asociacion.mostrar-comunidades-ajax',compact('comunidades'))->render();
            return \Response::json(['options'=>$data]);
        }
    }
    public function store(Request $request){
        // dd($request->all());
        $comunidad_id=$request->input('comunidad');
        $departamento_id=$request->input('departamento');
        $categoria=$request->input('categoria');
        $idioma=$request->input('idioma');
        $ruta_salida=$request->input('ruta_salida');
        $ruta_llegada=$request->input('ruta_llegada');
        $min=$request->input('min');
        $max=$request->input('max');
        $precio=$request->input('precio');
        $tipo_producto=$request->input('tipo_producto');
        $rol=$request->input('rol');

        $proveedor_id=$request->input('proveedor_id');
        $precio_proveedor=$request->input('precio_proveedor');

        if($rol=='TRANSPORTE'){
            if(trim($comunidad_id)==''||trim($comunidad_id)=='0'){
                return redirect()->back()->with('error','escoja un departamento, provincia,distrito y comunidad')->withInput();
            }
            $existencias=TransporteExterno::where('comunidad_id',$comunidad_id)->where('categoria',$categoria)->where('ruta_salida',$ruta_salida)->where('ruta_llegada',$ruta_llegada)->count();
            if($existencias>0){
                return redirect()->back()->with('error','El producto ya existe')->withInput();
            }
            else{
                $temp=new TransporteExterno();
                $temp->codigo='001';
                $temp->nombre='001';
                $temp->categoria=$categoria;
                $temp->ruta_salida=$ruta_salida;
                $temp->ruta_llegada=$ruta_llegada;
                $temp->min=$min;
                $temp->max=$max;
                $temp->precio=$precio;
                $temp->s_p=$tipo_producto;
                $temp->comunidad_id=$comunidad_id;
                $temp->save();
                if($proveedor_id){
                    foreach($proveedor_id as $key => $value){
                        $objeto=new TransporteExternoProveedor();
                        $objeto->precio=$precio_proveedor[$key];
                        $objeto->transporte_externo_id=$temp->id;
                        $objeto->proveedor_id=$value;
                        $objeto->save();
                    }
                }
                return redirect()->route('producto.nuevo',$rol)->with('success','Datos guardados');

            }
        }
        elseif($rol=='GUIA'){
            if(trim($departamento_id)==''||trim($departamento_id)=='0'){
                return redirect()->back()->with('error','escoja un departamento,')->withInput();
            }
            $existencias=Guia::where('departamento_id',$departamento_id)->where('idioma',$idioma)->count();
            if($existencias>0){
                return redirect()->back()->with('error','El producto ya existe')->withInput();
            }
            else{
                $temp=new Guia();
                $temp->codigo='001';
                $temp->nombre='001';
                $temp->idioma=$idioma;
                $temp->min=$min;
                $temp->max=$max;
                $temp->precio=$precio;
                $temp->s_p=$tipo_producto;
                $temp->departamento_id=$departamento_id;
                $temp->save();
                if($proveedor_id){
                    foreach($proveedor_id as $key => $value){
                        $objeto=new GuiaProveedor();
                        $objeto->precio=$precio_proveedor[$key];
                        $objeto->guia_id=$temp->id;
                        $objeto->proveedor_id=$value;
                        $objeto->save();
                    }
                }
                return redirect()->route('producto.nuevo',$rol)->with('success','Datos guardados');

            }
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

    public function mostrar_proveedores(Request $request){
        $departamento_id=$request->input('departamento_id');
        $categoria=$request->input('categoria');
        $proveedores=Proveedor::where('departamento_id',$departamento_id)->where('categoria',$categoria)->get();
        return view('admin.producto.lista-proveedores',compact('proveedores'));
    }
}
