<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadPrecio extends Model
{
    //
    protected $table = "actividad_precio";
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}
