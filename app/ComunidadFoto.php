<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComunidadFoto extends Model
{
    //
    protected $table = "comunidad_foto";
    public function comunidad()
    {
        return $this->belongsTo(ComunidadFoto::class, 'comunidad_id');
    }
}
