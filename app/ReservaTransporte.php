<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaTransporte extends Model
{
    //
    protected $table = "reserva_transporte";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
