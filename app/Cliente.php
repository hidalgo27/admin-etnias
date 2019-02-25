<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    protected $table = "clientes";
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
