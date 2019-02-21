<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadFoto extends Model
{
    //
    protected $table = "actividad_foto";
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}
