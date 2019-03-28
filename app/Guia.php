<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    //
    protected $table = "guia";
    public function guia()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function guia_proveedor()
    {
        return $this->hasMany(GuiaProveedor::class, 'guia_id');
    }
}
