<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaProveedor extends Model
{
    //
    protected $table = "guia_proveedor";

    public function guia()
    {
        return $this->belongsTo(Guia::class, 'guia_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
