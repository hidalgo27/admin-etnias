<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospedajeFoto extends Model
{
    //
    protected $table = "hospedaje_foto";
    public function hospedaje()
    {
        return $this->belongsTo(Hospedaje::class, 'hospedaje_id');
    }
}
