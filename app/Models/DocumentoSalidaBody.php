<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSalidaBody extends Model
{
    use HasFactory;

    protected $table = 'documento_salida_body'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'documento_salida_head_id',
        'producto',
        'cantidad',
        'centro_costos',
        'tipo_afectacion',
        'precio_unitario',
        'total',
    ];

    public $timestamps = false;

    // Relaciones

    public function documentoSalidaHead()
    {
        return $this->belongsTo(DocumentoSalidaHead::class, 'documento_salida_head_id', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto', 'id');
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costos', 'id');
    }

    public function tipoAfectacionIgv()
    {
        return $this->belongsTo(TipoAfectacionIgv::class, 'tipo_afectacion', 'id');
    }
}
