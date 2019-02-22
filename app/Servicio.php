<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    protected $table = "servicios";
    public function fotos()
    {
        return $this->hasMany(ServicioFoto::class, 'servicio_id');
    }
    public function precios()
    {
        return $this->hasMany(ServicioPrecio::class, 'servicio_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
