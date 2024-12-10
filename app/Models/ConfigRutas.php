<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigRutas extends Model
{
    use HasFactory;
    protected $table = 'Config_Rutas'; // Nombre de la tabla
    protected $fillable = ['api_url', 'api_token', 'UsuarioModificar']; // Campos permitidos para asignación masiva
    public $timestamps = false; // La tabla no usa created_at ni updated_at

    /**
     * Relación con la tabla usuarios.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UsuarioModificar', 'id_usuario');
    }
}
