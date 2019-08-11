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
use App\Reserva;

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
        $transportes_externo=TransporteExterno::get();
        $guias=Guia::get();
        return view('admin.producto.lista',compact('proveedores','departamentos','provincias','distritos','comunidades','tipo_servicios','transportes_externo','guias'));
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
    public function getDelete($id,$categoria){
        if($categoria=='TRANSPORTE'){
            $objeto=TransporteExterno::find($id);
            $reservas=Reserva::where('comunidad_id',$objeto->comunidad_id)
            ->where('categoria',$objeto->categoria)
            ->where('ruta_salida',$objeto->ruta_salida)
            ->where('ruta_llegada',$objeto->ruta_llegada)
            ->where('min',$objeto->min)->where('max',$objeto->max)
            ->where('s_p',$objeto->s_p)->get();
            if($reservas->count()==0){
                if($objeto->delete())
                    return 1;
                else
                    return 0;
            }else
                return 2;
        }
        elseif($categoria=='GUIA'){
            $objeto=Guia::find($id);
            $reservas=Reserva::where('comunidad_id',$objeto->comunidad_id)
            ->where('categoria',$objeto->categoria)
            ->where('ruta_salida',$objeto->ruta_salida)
            ->where('ruta_llegada',$objeto->ruta_llegada)
            ->where('min',$objeto->min)->where('max',$objeto->max)
            ->where('s_p',$objeto->s_p)->get();
            if($reservas->count()==0){
                if($objeto->delete())
                    return 1;
                else
                    return 0;
            }else
                return 2;
        }
    }
    public function editar(Request $request){

        $id=$request->input('id');
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

        // Listado de productos pro proveedor
        $proveedor_id=$request->input('proveedor_id');
        $precio_proveedor=$request->input('precio_proveedor');

        // listado de productos por proveedor en db
        $proveedor_id_d=$request->input('proveedor_id_d');
        $precio_proveedor_d=$request->input('precio_d');

        if($rol=='TRANSPORTE'){
            if(trim($comunidad_id)==''||trim($comunidad_id)=='0'){
                return redirect()->back()->with('error','escoja un departamento, provincia,distrito y comunidad')->withInput();
            }

            $temp= TransporteExterno::find($id);
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

            if($proveedor_id_d){
                $transporte_prooveedor=TransporteExternoProveedor::where('transporte_externo_id',$id)->get();
                foreach ($transporte_prooveedor as $key => $value) {
                    if(!in_array($value->id,$proveedor_id_d)){
                        $temp_=TransporteExternoProveedor::find($value->id);
                        $temp_->delete();
                    }
                    else{
                        $objeto=TransporteExternoProveedor::find($value->id);
                        $objeto->precio=$precio_proveedor_d[$key];
                        $objeto->save();
                    }
                }
            }
            else{
                TransporteExternoProveedor::where('transporte_externo_id',$id)->delete();
            }
            if($proveedor_id){
                if($precio_proveedor){
                    foreach($proveedor_id as $key => $value){
                        $objeto=new TransporteExternoProveedor();
                        $objeto->precio=$precio_proveedor[$key];
                        $objeto->transporte_externo_id=$temp->id;
                        $objeto->proveedor_id=$value;
                        $objeto->save();
                    }
                }
            }
            return redirect()->route('producto.lista')->with('success','Datos guardados');
        }
        elseif($rol=='GUIA'){
            if(trim($departamento_id)==''||trim($departamento_id)=='0'){
                return redirect()->back()->with('error','escoja un departamento,')->withInput();
            }

            $temp= Guia::find($id);
            $temp->codigo='001';
            $temp->nombre='001';
            $temp->idioma=$idioma;
            $temp->min=$min;
            $temp->max=$max;
            $temp->precio=$precio;
            $temp->s_p=$tipo_producto;
            $temp->departamento_id=$departamento_id;
            $temp->save();

            if($proveedor_id_d){
                $guia_prooveedor=GuiaProveedor::where('guia_id',$id)->get();
                foreach ($guia_prooveedor as $key => $value) {
                    if(!in_array($value->id,$proveedor_id_d)){
                        $temp_=GuiaProveedor::find($value->id);
                        $temp_->delete();
                    }
                    else{
                        $objeto=GuiaProveedor::find($value->id);
                        $objeto->precio=$precio_proveedor_d[$key];
                        $objeto->save();
                    }
                }
            }
            else{
                GuiaProveedor::where('guia_id',$id)->delete();
            }
            if($proveedor_id){
                if($precio_proveedor){
                    foreach($proveedor_id as $key => $value){
                        $objeto=new GuiaProveedor();
                        $objeto->precio=$precio_proveedor[$key];
                        $objeto->guia_id=$temp->id;
                        $objeto->proveedor_id=$value;
                        $objeto->save();
                    }
                }
            }
            return redirect()->route('producto.lista')->with('success','Datos guardados');
        }
    }

    public function mostrar_proveedores(Request $request){
        $departamento_id=$request->input('departamento_id');
        $categoria_id=$request->input('categoria_id');
        $producto_id=$request->input('producto_id');
        $categoria=$request->input('categoria');
        $proveedores=Proveedor::where('departamento_id',$departamento_id)->where('categoria',$categoria)->get();
        return view('admin.producto.lista-proveedores',compact('proveedores','categoria_id','producto_id'));
    }
}
