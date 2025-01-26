<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoAcceso extends Model
{
    use HasFactory;
    protected $table = 'CodigoAcceso'; // Nombre de la tabla
    protected $fillable = ['CodigoAcceso', 'UsuarioModificar']; // Campos permitidos
    public $timestamps = false; // La tabla no usa created_at ni updated_at

    /**
     * Relación con la tabla usuarios.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioModificar', 'id_usuario');
    }
}
