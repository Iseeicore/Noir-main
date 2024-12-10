<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSalidaHead extends Model
{
    use HasFactory;

    protected $table = 'documento_salida_head'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'codigo_head',
        'fecha_emision',
        'fecha_contable',
        'periodo',
        'tipo_operacion',
        'almacenOrigenUsuario',
        'almacenDestino',
        'UsuarioRecivir',
        'numerodocumento',
        'numerosecundariodocumento',
        'glosario',
        'Total_efectivo_Compelto',
        'UsuarioCreacion',
    ];

    public $timestamps = false;

    // Relaciones

    public function tipoOperacion()
    {
        return $this->belongsTo(TipoOperacion::class, 'tipo_operacion', 'id');
    }

    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'almacenOrigenUsuario', 'id');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacenDestino', 'id');
    }

    public function usuarioRecibir()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioRecivir', 'id_usuario');
    }

    public function usuarioCreacion()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioCreacion', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DocumentoSalidaBody::class, 'documento_salida_head_id', 'id');
    }
}
