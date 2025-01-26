<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequerimientoHead extends Model
{
    use HasFactory;

    protected $table = 'requerimiento_head';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cod_req',
        'fecha_req',
        'estado',
        'encargado',
        'solicitante',
        'Area_recibida',
        'revisado_req',
    ];

    // Relación con el modelo Usuarios (para encargado)
    public function encargado()
    {
        return $this->belongsTo(Usuario::class, 'encargado', 'id_usuario');
    }

    // Relación con el modelo Usuarios (para solicitante)
    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'solicitante', 'id_usuario');
    }

    // Relación con el modelo Usuarios (para persona que recoge)
    public function arearecibida()
    {
        return $this->belongsTo(Area::class, 'Area_recibida', 'id_area');
    }
    // Relación con el modelo Usuarios (para persona revisa )
    public function revisado_req()
    {
        return $this->belongsTo(Usuario::class, 'revisado_req', 'id_usuario');
    }

    // Relación con el modelo RequerimientoBody
    public function detalles()
    {
        return $this->hasMany(RequerimientoBody::class, 'id_requerimiento_head', 'id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_Area_usuario', 'id_area');
    }

}
