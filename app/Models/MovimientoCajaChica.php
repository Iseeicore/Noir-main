<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CajaChica;

class MovimientoCajaChica extends Model
{
    use HasFactory;

    protected $table = 'movimientos_caja_chica';

    protected $fillable = [
        'id_caja_chica',
        'tipo_movimiento',
        'monto',
        'descripcion',
        'fecha',
        'usuario_id', // Asegúrate de incluir este campo
        'categoria_id',
    ];


    protected static function booted()
    {
        static::created(function ($movimiento) {
            $cajaChica = $movimiento->cajaChica;

            if ($movimiento->tipo_movimiento === 'egreso') {
                $cajaChica->monto_gastado += $movimiento->monto;
                $cajaChica->monto_actual -= $movimiento->monto;
            } elseif ($movimiento->tipo_movimiento === 'ingreso') {
                $cajaChica->monto_actual += $movimiento->monto;
            }

            $cajaChica->save();
        });
    }

    // Relación con caja chica
    // Relación con CajaChica
    public function cajaChica()
    {
        return $this->belongsTo(CajaChica::class, 'id_caja_chica');
    }

}
