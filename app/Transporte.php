<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    //
    protected $table = "transporte";
    public function fotos()
    {
        return $this->hasMany(TransporteFoto::class, 'transporte_id');
    }
    public function precios()
    {
        return $this->hasMany(TransportePrecio::class, 'transporte_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
