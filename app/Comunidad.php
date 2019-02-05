<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    //
    protected $table = "comunidad";
    public function fotos()
    {
        return $this->hasMany(ComunidadFoto::class, 'comunidad_id');
    }
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }
}
