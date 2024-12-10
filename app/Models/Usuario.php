<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nomb_usuarios',
        'apellidos_usuarios',
        'dni',
        'usuario',
        'clave',
        'id_perfil_usuario',
        'id_Area_usuario',
        'id_almacen_usuario',
        'estado',
    ];

    public $timestamps = false;

    protected $hidden = [
        'clave', // Mantén la clave oculta
    ];

    // Accesor para obtener la contraseña de autenticación
    public function getAuthPassword()
    {
        return $this->clave;
    }

    /**
     * Relación con el perfil del usuario.
     */
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil_usuario', 'id_perfil');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_Area_usuario', 'id_area');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen_usuario', 'id');
    }
    
}
