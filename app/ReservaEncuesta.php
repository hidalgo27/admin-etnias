<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaEncuesta extends Model
{
    //
    protected $table = "reserva_encuesta";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

}
