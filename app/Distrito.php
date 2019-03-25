<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    //
    protected $table = "distrito";
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
    public function comunidades()
    {
        return $this->hasMany(Comunidad::class, 'distrito_id');
    }
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'distrito_id');
    }
}
