<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportePrecio extends Model
{
    //
    protected $table = "transporte_precio";
    public function transporte()
    {
        return $this->belongsTo(Transporte::class, 'transporte_id');
    }
}
