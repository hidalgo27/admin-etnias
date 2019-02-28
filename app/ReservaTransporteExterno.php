<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaTransporteExterno extends Model
{
    //
    protected $table = "reserva_transporte_externo";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
