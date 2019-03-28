<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransporteExternoProveedor extends Model
{
    //
    protected $table = "transporte_externo_proveedor";

    public function transporte_externo()
    {
        return $this->belongsTo(TransporteExterno::class, 'transporte_externo_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
