<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilModulo extends Model
{
    use HasFactory;

    protected $table = 'perfil_modulo';

    protected $primaryKey = 'idperfil_modulo';

    protected $fillable = [
        'id_perfil',
        'id_modulo',
        'vista_inicio',
        'estado',
    ];

    public $timestamps = false;

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo', 'id');
    }
}
