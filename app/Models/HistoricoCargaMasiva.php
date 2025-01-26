<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoCargaMasiva extends Model
{
    use HasFactory;
    protected $table = 'historico_carga_masivas'; // Asegúrate de que el nombre sea correcto

    protected $fillable = [
        'nucleos_insertados', 'nucleos_omitidos',
        'centros_costo_insertados', 'centros_costo_omitidos',
        'categorias_insertadas', 'categorias_omitidas',
        'almacenes_insertados', 'almacenes_omitidos',
        'codigo_unidades_medida_insertadas', 'codigo_unidades_medida_omitidas',
        'tipo_afectacion_insertados', 'tipo_afectacion_omitidos',
        'productos_insertados', 'productos_omitidos', 'estado_carga',
        'created_at'
    ];

    public $timestamps = false;
}
