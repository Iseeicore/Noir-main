<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_operaciones';
    protected $fillable = ['descripcion', 'tipo', 'estado'];
    public $timestamps = false;

    public static function obtenerTiposFiltrados()
    {
        return self::whereIn('tipo', ['ENTRADA', 'SALDO INICIAL', 'DEVOLUCIÓN', 'NINGUNO'])->get();
    }
    public static function obtenerTiposFiltradosSalida()
    {
        return self::whereIn('tipo', ['SALIDA', 'DEVOLUCIÓN', 'NINGUNO'])->get();
    }
}
