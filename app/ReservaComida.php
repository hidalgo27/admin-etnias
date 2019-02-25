<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaComida extends Model
{
    //
    protected $table = "reserva_comida";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
