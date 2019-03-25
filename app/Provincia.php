<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    //
    protected $table = "provincia";
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'provincia_id');
    }
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'provincia_id');
    }
}
