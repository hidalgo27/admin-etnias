<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    protected $table = "proveedor";
    public function transporte_externo_proveedor()
    {
        return $this->hasMany(TransporteExternoProveedor::class, 'transporte_externo_id');
    }
}
