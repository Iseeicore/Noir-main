<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacen';
    protected $fillable = ['nomb_almacen', 'ubic_almacen', 'estado'];
    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_almacen', 'id');
    }
}
