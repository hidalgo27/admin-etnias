<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    //
    protected $table = "reserva";
    public function actividades()
    {
        return $this->hasMany(ReservaActividad::class, 'reserva_id');
    }
    public function comidas()
    {
        return $this->hasMany(ReservaComida::class, 'reserva_id');
    }
    public function hospedajes()
    {
        return $this->hasMany(ReservaHospedaje::class, 'reserva_id');
    }
    public function transporte()
    {
        return $this->hasMany(ReservaTransporte::class, 'reserva_id');
    }
    public function servicios()
    {
        return $this->hasMany(ReservaServicio::class, 'reserva_id');
    }
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'reserva_id');
    }
}
