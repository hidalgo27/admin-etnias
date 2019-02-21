<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioFoto extends Model
{
    //
    protected $table = "servicio_foto";
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
