<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    use HasFactory;
    protected $table = 'centro_costo';
    protected $fillable = ['Codigo','nomb_centroCos', 'nucleo', 'estado'];
    public $timestamps = false;

    public function nucleo()
    {
        return $this->belongsTo(Nucleo::class, 'nucleo', 'id');
    }
}
