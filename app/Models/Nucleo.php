<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nucleo extends Model
{
    use HasFactory;
    protected $table = 'nucleo';
    protected $fillable = ['nomb_nucleo', 'estado'];
    public $timestamps = false;

    public function centrosCosto()
    {
        return $this->hasMany(CentroCosto::class, 'nucleo', 'id');
    }
}
