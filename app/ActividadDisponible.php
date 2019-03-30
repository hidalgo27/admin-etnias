<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadDisponible extends Model
{
    //
    protected $table = "actividad_disponible";
    
    public function disponible()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}
