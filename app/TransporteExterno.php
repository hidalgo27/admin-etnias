<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransporteExterno extends Model
{
    //
    protected $table = "transporte_externo";
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }
    public function transporte_externo_proveedor()
    {
        return $this->hasMany(TransporteExternoProveedor::class, 'transporte_externo_id');
    }
}
