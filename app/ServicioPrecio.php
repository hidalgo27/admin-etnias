<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioPrecio extends Model
{
    //
    protected $table = "servicio_precio";
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
