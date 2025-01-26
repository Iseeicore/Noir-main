<?php

namespace App\Models;

use App\Models\CentroCosto;
use App\Models\Producto;
use App\Models\TipoAfectacionIgv;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIngresoBody extends Model
{
    use HasFactory;
    protected $table = 'documento_ingreso_body';
    protected $fillable = [
        'documento_ingreso_head_id', 'producto','cantidad', 'centro_costos', 
        'tipo_afectacion', 'precio_unitario', 'total'
    ];
    public $timestamps = false;

    public function documentoIngresoHead()
    {
        return $this->belongsTo(DocumentoIngresoHead::class, 'documento_ingreso_head_id');
    }

    public function producto()
    {
        return $this->belongsTo(ProductoModeloreq::class, 'producto');
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costos');
    }

    public function tipoAfectacionIgv()
    {
        return $this->belongsTo(TipoAfectacionIgv::class, 'tipo_afectacion');
    }
}
