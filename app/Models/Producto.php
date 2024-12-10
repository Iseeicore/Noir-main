<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = [
        'codigo_productos', 'id_categorias', 'id_almacen', 'descripcion',
        'id_tipo_afectacion_igv', 'id_unidad_medida', 'costo_unitario',
        'precio_unitario_sin_igv', 'precio_unitario_con_igv', 'stock', 
        'minimo_stock', 'costo_total', 'imagen', 'estado'
    ];

    public $timestamps = false;
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categorias', 'id');
    }

    public function tipoAfectacionIgv()
    {
        return $this->belongsTo(TipoAfectacionIgv::class, 'id_tipo_afectacion_igv', 'id');
    }
    public function unidadMedida()
    {
        return $this->belongsTo(CodigoUnidadMedida::class, 'id_unidad_medida', 'id');
    }
}
