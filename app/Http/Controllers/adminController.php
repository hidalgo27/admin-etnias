<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    public function index(Request $request)
    {

        return view('admin.index');
    }
    public function destroy(){
        // auth()->guard('admin')->logout();
        return redirect()->route('admin_index_path');
    }
}