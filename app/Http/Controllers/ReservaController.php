<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reserva;

class ReservaController extends Controller
{
    //
    public function lista(){
        $reservas_new=Reserva::where('estado','0')->get();
        $reservas_current=Reserva::where(function($query){
            $query->where('estado','1');
        })
        ->where(function($query){
            $query->WhereHas('actividades',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('comidas',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('hospedajes',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('transporte',function($q){
                $q->where('estado','0');
            });
            $query->orWhereHas('servicios',function($q){
                $q->where('estado','0');
            });
        })->get();

        $reservas_close=Reserva::where(function($query){
            $query->where('estado','1');
        })
        ->where(function($query){
            $query->WhereHas('actividades',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('comidas',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('hospedajes',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('transporte',function($q){
                $q->where('estado','1');
            });
            $query->WhereHas('servicios',function($q){
                $q->where('estado','1');
            });
        })->get();

        return view('admin.reserva.lista',compact('reservas_new','reservas_current','reservas_close'));
    }
    public function detalle($reserva_id){
        $reserva=Reserva::findOrFail($reserva_id);
        return view('admin.reserva.detalle',compact('reserva'));

    }
}
