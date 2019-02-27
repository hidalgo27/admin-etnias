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
    public function reserva_comida()
    {
        return $this->hasMany(ReservaComida::class, 'asociacion_id');
    }
    public function reserva_hospedaje()
    {
        return $this->hasMany(ReservaHospedaje::class, 'asociacion_id');
    }
    public function reserva_transporte()
    {
        return $this->hasMany(ReservaTransporte::class, 'asociacion_id');
    }
    public function reserva_servicio()
    {
        return $this->hasMany(ReservaServicio::class, 'asociacion_id');
    }
}
