<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    //
    protected $table = "asociacion";
    public function fotos()
    {
        return $this->hasMany(AsociacionFoto::class, 'asociacion_id');
    }
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'asociacion_id');
    }
    public function reserva_actividad()
    {
        return $this->hasMany(ReservaActividad::class, 'asociacion_id');
    }
}
