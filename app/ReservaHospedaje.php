<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaHospedaje extends Model
{
    //
    protected $table = "reserva_hospedaje";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
