<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaGuia extends Model
{
    //
    protected $table = "reserva_guia";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
