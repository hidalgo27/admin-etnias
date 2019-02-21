<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospedajePrecio extends Model
{
    //
    protected $table = "hospedaje_precio";
    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class, 'hospedaje_id');
    }
}
