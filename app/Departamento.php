<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $table = "departamento";
    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'departamento_id');
    }
    public function proveedor()
    {
        return $this->hasMany(Proveedor::class, 'departamento_id');
    }
}
