<?php

namespace App\Models;

use App\Models\Almacen;
use App\Models\TipoOperacion;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIngresoHead extends Model
{
    use HasFactory;

    protected $table = 'documento_ingreso_head';

    protected $fillable = [
        'codigo_head',
        'fecha_emision',
        'fecha_contable',
        'periodo',
        'tipo_operacion',
        'proveedor',
        'almacen',
        'comprobante_pago',
        'tipo_cambio',
        'numerodocumento',
        'numerosecundariodocumento',
        'glosario',
        'Total_efectivo_Compelto',
        'UsuarioCreacion',
        'nomb_moneda',
        'registro_cambio_al_dia'
    ];

    public $timestamps = false;

    public function tipoOperacion()
    {
        return $this->belongsTo(TipoOperacion::class, 'tipo_operacion');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen');
    }

    public function comprobantePago()
    {
        return $this->belongsTo(ComprobantePago::class, 'comprobante_pago');
    }

    public function tipoCambio()
    {
        return $this->belongsTo(TipoCambio::class, 'tipo_cambio');
    }

    public function usuarioCreacion()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioCreacion', 'id_usuario');
    }

}
