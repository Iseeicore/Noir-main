<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoUnidadMedida extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'unidad_medida';
    protected $primaryKey = 'id';
    public $incrementing = false; // Ya que es un char(10)
    protected $keyType = 'string';
    protected $fillable = ['id','nomb_uniMed', 'estado'];
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_unidad_medida', 'id');
    }
    public function productosmodeloreq()
{
    return $this->hasMany(ProductoModeloreq::class, 'unidad_medida', 'id');
}

}
