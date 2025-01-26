<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaContable extends Model
{
    use HasFactory;

    protected $table = 'caja_contable';

    protected $fillable = [
        'monto_inicial',
        'monto_actual',
        'monto_ingresado',
        'monto_gastado',
        'responsable',
        'descripcion',
        'fecha_creacion',
        'estado',
    ];

    public function movimientos()
    {
        return $this->hasMany(MovimientoCajaContable::class, 'id_caja_contable');
    }

    public function calcularSaldo()
    {
        return $this->monto_actual;
    }

    public function calcularTotalIngresos()
    {
        return $this->movimientos()->where('tipo_movimiento', 'ingreso')->sum('monto');
    }

    public function calcularTotalEgresos()
    {
        return $this->movimientos()->where('tipo_movimiento', 'egreso')->sum('monto');
    }
}
