<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    protected $primaryKey = 'id_perfil';

    protected $fillable = [
        'descripcion',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion',
    ];

    public $timestamps = false;

    public function modulos()
{
    return $this->belongsToMany(Modulo::class, 'perfil_modulo', 'id_perfil', 'id_modulo')
                ->withPivot('vista_inicio')
                ->withTimestamps();
}
}
