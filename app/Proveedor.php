<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    protected $table = "proveedor";
    public function transporte_externo_proveedor()
    {
        return $this->hasMany(TransporteExternoProveedor::class, 'transporte_externo_id');
    }
    public function guia_proveedor()
    {
        return $this->hasMany(GuiaProveedor::class, 'guia_id');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }
}
