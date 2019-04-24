<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['user', 'admin','asociacion']);
        
        // return view('admin.index');
        return view('admin.index');

    }
    public function destroy(){
        // auth()->guard('admin')->logout();
        return redirect()->route('admin_index_path');
    }
    public function solicitudes_lista()
    {

        return view('admin.index');
    }
}
