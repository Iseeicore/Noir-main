<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CajaContable;
class MovimientoCajaContable extends Model
{
    use HasFactory;

    protected $table = 'movimientos_caja_contable';
            protected $fillable = [
            'id_caja_contable',
            'tipo_movimiento',
            'monto',
            'descripcion',
            'referencia',
            'categoria_id',
            'concepto',
            'fecha',
            'usuario_id',
        ];

    // Asegurarte de que 'fecha' sea un objeto Carbon
    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function cajaContable()
    {
        return $this->belongsTo(CajaContable::class, 'id_caja_contable');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(CategoriaMovimiento::class, 'categoria_id');
    }

}
