<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    use HasFactory;
     // Nombre de la tabla
     protected $table = 'impuestos';

     // Desactivar timestamps si no existen en la tabla
     public $timestamps = false;
 
     // Clave primaria de la tabla
     protected $primaryKey = 'id_tipo_operacion';
 
     // Desactivar la autoincrementación de la clave primaria
     public $incrementing = false;
 
     // Tipo de datos de la clave primaria
     protected $keyType = 'integer';
 
     // Definir los campos que se pueden asignar masivamente
     protected $fillable = [
         'id_tipo_operacion',
         'impuesto',
         'estado',
     ];
}
