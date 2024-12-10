<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cod_proveedor',
        'ruc',
        'razon_social',
        'direccion',
        'contacto',
        'numero',
        'email',
        'estado'
    ];

    // Desactivar timestamps
    public $timestamps = false;
}

