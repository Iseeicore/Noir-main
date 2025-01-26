<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'familias';

    // Campos que se pueden asignar masivamente
    protected $fillable = ['nomb_familia', 'cod_familia', 'estado'];

    // Definir que se utilizarán los timestamps personalizados
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Relación con el modelo Categoria
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_familias', 'id');
    } 
}
