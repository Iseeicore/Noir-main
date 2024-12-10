<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    use HasFactory;

    protected $table = 'tipo_cambio';

    protected $fillable = [
        'fecha',
        'moneda_origen',
        'moneda_destino',
        'tipo_cambio_compra',
        'tipo_cambio_venta',
        'estado'
    ];

    public $timestamps = false;
    protected $casts = [
        'tipo_cambio_compra' => 'float',
        'tipo_cambio_venta' => 'float',
    ];
}
