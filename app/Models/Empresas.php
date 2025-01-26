<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'empresas';

    // Clave primaria personalizada
    protected $primaryKey = 'id_empresa';

    // Si la clave primaria no es autoincremental o de tipo int, se podría usar la propiedad $keyType y $incrementing.
    public $incrementing = true;
    protected $keyType = 'int';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'genera_fact_electronica',
        'razon_social',
        'nombre_comercial',
        'id_tipo_documento',
        'ruc',
        'direccion',
        'simbolo_moneda',
        'email',
        'telefono',
        'certificado_digital',
        'clave_certificado',
        'usuario_sol',
        'clave_sol',
        'es_principal',
        'fact_bol_defecto',
        'logo',
        'bbva_cci',
        'bcp_cci',
        'yape',
        'estado',
        'production',
        'client_id',
        'client_secret',
        'certificado_digital_pem',
    ];

    // Desactivar timestamps si la tabla no los usa
    public $timestamps = false;
}
