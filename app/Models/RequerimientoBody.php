<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequerimientoBody extends Model
{
    use HasFactory;

    
    protected $table = 'requerimiento_body';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_requerimiento_head',
        'nombre_prod',
        'cantidad',
        'unidad_medida',
        'nombre_marca',
        'cantidad',
        'centro_costo',
    ];

    // Relación con el modelo RequerimientoHead
    public function requerimientoHead()
    {
        return $this->belongsTo(RequerimientoHead::class, 'id_requerimiento_head', 'id');
    }

    // Relación con el modelo UnidadMedida
    public function unidadMedida()
    {
        return $this->belongsTo(CodigoUnidadMedida::class, 'unidad_medida', 'id');
    }

    // Relación con el modelo centro_costo
    public function centroCosto(){
        return $this->belongsTo(CentroCosto::class, 'centro_costo', 'id');
    }
}
