<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $table = 'kardex'; // Nombre de la tabla
    protected $fillable = [
        'id_producto', 
        'codigo_producto', 
        'almacen',
        'almacenDestino', 
        'fecha', 
        'concepto', 
        'comprobante', 
        'centro_costo',
        'descripcion_centro_costo',
        'in_unidades', 
        'in_costo_unitario', 
        'in_costo_total', 
        'out_unidades', 
        'out_costo_unitario', 
        'out_costo_total', 
        'ex_unidades', 
        'ex_costo_unitario', 
        'ex_costo_total',
    ];
    public $timestamps = false; // La tabla usa campos created_at y updated_at

    // Relaciones

    /**
     * Relación con la tabla Producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    /**
     * Relación con la tabla Almacen.
     */
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen', 'id');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacenDestino', 'id');
    }

    /**
     * Relación con la tabla CentroCosto.
     */
    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costo', 'id');
    }
}
