<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoModeloreq extends Model
{
    use HasFactory;
    protected $table = 'producto_sin_ubicacion'; // Nombre de la tabla en la base de datos

    public $timestamps = false;
    protected $fillable = [
        'cod_registro',
        'categoria',
        'descripcion',
        'unidad_medida',
        'imagen',
        'minimo_stock',
        'estado'
    ];

    // Definición de relaciones con las tablas `categoria` y `unidad_medida`
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria', 'id');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(CodigoUnidadMedida::class, 'unidad_medida', 'id');
    }
}
