<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospedaje extends Model
{
    //
    protected $table = "hospedaje";
    public function fotos()
    {
        return $this->hasMany(HospedajeFoto::class, 'hospedaje_id');
    }
    public function precios()
    {
        return $this->hasMany(HospedajePrecio::class, 'hospedaje_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
