<?php

namespace App\Http\Controllers;

use App\Role;
use App\Asociacion;
use App\Departamento;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    //
    public function get(){
        $administradores = Asociacion::where('comunidad_id','=','0')->get();
        return view('admin.administrador.lista',compact(['administradores']));
    }
    public function nuevo(){
        $departamentos = Departamento::get();
        return view('admin.administrador.nuevo',compact(['departamentos']));
    }
    public function editar(Request $request){
        $nombre=$request->input('nombre');
        $id=$request->input('id');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $password=$request->input('password');
        $re_password=$request->input('re_password');
        $estado=$request->input('estado');

        if($password!=$re_password){

            return redirect()->back()->with('error','Las contraseñas no coinciden')->withInput();
        }
        $asociacion=Asociacion::find($id);
        $asociacion->nombre=$nombre;
        $asociacion->nombre=$nombre;
        $asociacion->celular=$celular;
        $asociacion->email=$email;
        $asociacion->password=bcrypt($password);
        $asociacion->password_2=$password;
        $asociacion->comunidad_id='0';
        $asociacion->estado=$estado;
        $asociacion->save();        
        $asociacion_role = Role::where('name', 'admin')->first();
        
        $asociacion->roles()->detach($asociacion_role);
        $asociacion->roles()->attach($asociacion_role);
        return redirect()->route('administrador_lista_path')->with('success','Datos editados');
    }
    public function store(Request $request){
        $nombre=$request->input('nombre');
        $celular=$request->input('celular');
        $email=$request->input('email');
        $password=$request->input('password');
        $re_password=$request->input('re_password');
        $estado=$request->input('estado');
        
        if(trim($password)!=trim($re_password)){
            return redirect()->back()->with('error','las contraseñas no coinciden, vuelva a ingresar los datos')->withInput();
        }
        $existencias=Asociacion::where('email',$email)->count();
        if($existencias>0){
            return redirect()->back()->with('error','La Asociacion con email '.$email.' ya existe')->withInput();
        }
        else{
            $comunidad=new Asociacion();
            $comunidad->ruc='01019999901';
            $comunidad->nombre=$nombre;
            $comunidad->nombre=$nombre;
            $comunidad->celular=$celular;
            $comunidad->email=$email;
            $comunidad->password=bcrypt($password);
            $comunidad->password_2=$password;
            $comunidad->comunidad_id='0';
            $comunidad->estado=$estado;
            $comunidad->save();        
            //le asignamos un rol "asociacion"
            $asociacion_role = Role::where('name', 'admin')->first();
            $comunidad->roles()->attach($asociacion_role);
            return redirect()->route('administrador_nuevo_path')->with('success','Datos guardados');

        }
    }
    public function getDelete($id){

        $asociacion=Asociacion::find($id);
        $asociacion_role = Role::where('name', 'admin')->first();
        $asociacion->roles()->detach($asociacion_role);

        if($asociacion->delete())
            return 1;
        else
            return 0;
    }
}
