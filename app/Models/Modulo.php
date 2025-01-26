<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'modulos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'modulo',
        'padre_id',
        'vista',
        'icon_menu',
        'orden',
    ];

    public $timestamps = false;
    public function submodulos()
{
    return $this->hasMany(Modulo::class, 'padre_id');
}
}
