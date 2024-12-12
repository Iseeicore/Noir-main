<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    use HasFactory;

    protected $table = 'caja_chica';

    protected $fillable = [
        'monto_inicial',
        'monto_actual',
        'monto_gastado',
        'descripcion',
        'encargado',
        'fecha_creacion',
        'estado'
    ];


    // Método para calcular el gasto acumulado

    public function encargadoUsuario()
    {
        return $this->belongsTo(User::class, 'encargado', 'id'); // 'encargado' coincide con el campo en la base de datos
    }
    public function movimientosPorTipo($tipo)
    {
        return $this->movimientos()->where('tipo_movimiento', $tipo)->get();
    }



    public function calcularGastoAcumulado()
        {
            return $this->movimientos()
                ->where('tipo_movimiento', 'egreso')
                ->sum('monto');
        }

        public function calcularSaldo()
        {
            $ingresos = $this->movimientos()->where('tipo_movimiento', 'ingreso')->sum('monto');
            $egresos = $this->movimientos()->where('tipo_movimiento', 'egreso')->sum('monto');
            return $this->monto_inicial + $ingresos - $egresos;
        }
        // Relación con MovimientoCajaChica
        public function movimientos()
        {
            return $this->hasMany(MovimientoCajaChica::class, 'id_caja_chica');
        }

        protected static function boot()
{
    parent::boot();

    static::creating(function ($cajaChica) {
        // Verificar que el banco asociado sea el único permitido
        $banco = Banco::find($cajaChica->banco_id);
        if (!$banco || $banco->id !== 1 || $banco->nombre_banco !== 'BBVA SOLES' || $banco->tipo_moneda !== 'Soles') {
            throw new \Exception('Solo el banco BBVA SOLES con moneda en Soles puede manejar Caja Chica.');
        }
    });
}


}
