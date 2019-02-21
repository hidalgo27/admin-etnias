<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    //
    protected $table = "comida";
    public function fotos()
    {
        return $this->hasMany(ComidaFoto::class, 'comida_id');
    }
    public function precios()
    {
        return $this->hasMany(ComidaPrecio::class, 'comida_id');
    }
    public function asociacion()
    {
        return $this->belongsTo(Asociacion::class, 'asociacion_id');
    }
}
