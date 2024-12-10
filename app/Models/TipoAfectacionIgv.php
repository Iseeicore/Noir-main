<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAfectacionIgv extends Model
{
    use HasFactory;
     // Nombre de la tabla
     protected $table = 'tipo_afectacion_igv';

     // Nombre de la clave primaria
     protected $primaryKey = 'id';

     // Campos que se pueden llenar en este modelo
     protected $fillable = [
        'codigo', 'nomb_impuesto', 'letra_tributo', 'codigo_tributo',
        'nomb_tributo', 'tipo_tributo', 'porcentaje', 'estado'
    ];
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_tipo_afectacion_igv', 'id');
    }
}
