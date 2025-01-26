<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMovimiento extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'categorias_movimientos';

    // Llave primaria de la tabla
    protected $primaryKey = 'id';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'nombre',        // Nombre de la categoría o medio de pago
        'descripcion',   // Descripción de la categoría
        'estado',        // Estado de la categoría (1 = Activo, 0 = Inactivo)
    ];

    // Relación con los movimientos de caja contable
    public function movimientos()
    {
        return $this->hasMany(MovimientoCajaContable::class, 'categoria_id');
    }

    // Método para obtener categorías activas
    public static function getActivas()
    {
        return self::where('estado', 1)->get();
    }
}
