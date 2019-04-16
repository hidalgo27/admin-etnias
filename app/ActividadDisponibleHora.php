<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadDisponibleHora extends Model
{
    //
    protected $table = "actividad_disponible_horario";

    public function disponible_horas()
    {
        return $this->belongsTo(ActividadDisponible::class, 'actividad_disponible_id');
    }
}
