<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
        use HasFactory;

        // Nombre de la tabla
        protected $table = 'categoria';
    protected $primaryKey = 'id';
    public $incrementing = false; // Ya que es un char(10)
    protected $keyType = 'string';
    protected $fillable = ['id','nomb_cate', 'estado'];
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categorias', 'id');
    }
    public function productosmodeloreq()
    {
        return $this->hasMany(ProductoModeloreq::class, 'categoria', 'id');
    }
}
