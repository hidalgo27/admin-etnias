<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComidaPrecio extends Model
{
    //
    protected $table = "comida_precio";
    public function comida()
    {
        return $this->belongsTo(Comida::class, 'comida_id');
    }
}
