<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('proveedores', function (Blueprint $table) {
        $table->increments("id")->comment('Primary Key'); // Identificador único del proveedor
        $table->char('cod_proveedor', 30)->comment('Código único del proveedor');
        $table->char('ruc', 19)->comment('RUC del proveedor');
        $table->string('razon_social', 100)->comment('Razón social del proveedor');
        $table->string('direccion', 255)->comment('Dirección del proveedor');
        $table->string('contacto', 15)->comment('Nombre del contacto principal del proveedor');
        $table->string('numero', 10)->comment('Número de contacto principal del proveedor');
        $table->string('email', 255)->comment('Correo electrónico del proveedor');
        $table->integer('estado')->default(1)->comment('Estado del proveedor (1 = Activo, 0 = Inactivo)');
    });

    Schema::create('producto_sin_ubicacion', function (Blueprint $table) {
        $table->increments("id")->comment('Primary Key'); // Identificador único del producto sin ubicación
        $table->char('cod_registro', 60)->comment('Código de registro del producto');
        $table->char('categoria', 30)->comment('ID de la categoría asociada');
        $table->string('descripcion', 255)->comment('Descripción del producto');
        $table->char('unidad_medida', 30)->comment('ID de la unidad de medida asociada');
        $table->text('imagen')->comment('Imagen del producto');
        $table->integer('minimo_stock')->default(10)->comment('Cantidad mínima de stock permitida');
        $table->integer('estado')->default(1)->comment('Estado del producto (1 = Activo, 0 = Inactivo)');

        $table->foreign('categoria')->references('id')->on('categoria')->comment('Llave foránea a la tabla categoría');
        $table->foreign('unidad_medida')->references('id')->on('unidad_medida')->comment('Llave foránea a la tabla unidad de medida');
    });

    Schema::create('empresas', function (Blueprint $table) {
        $table->increments('id_empresa')->comment('Primary Key'); // Identificador único de la empresa
        $table->tinyInteger('genera_fact_electronica')->default(1)->comment('Indica si genera facturación electrónica (1 = Sí, 0 = No)');
        $table->text('razon_social')->comment('Razón social de la empresa');
        $table->string('nombre_comercial', 255)->nullable()->comment('Nombre comercial de la empresa');
        $table->string('id_tipo_documento', 20)->nullable()->comment('Tipo de documento de identificación');
        $table->unsignedBigInteger('ruc')->comment('RUC de la empresa');
        $table->text('direccion')->comment('Dirección de la empresa');
        $table->string('simbolo_moneda', 5)->nullable()->comment('Símbolo de la moneda utilizada');
        $table->text('email')->nullable()->comment('Correo electrónico de la empresa');
        $table->string('telefono', 100)->nullable()->comment('Teléfono de contacto de la empresa');
        $table->string('certificado_digital', 255)->nullable()->comment('Archivo del certificado digital de la empresa');
        $table->string('clave_certificado', 45)->nullable()->comment('Clave del certificado digital');
        $table->string('usuario_sol', 45)->nullable()->comment('Usuario SOL para facturación');
        $table->string('clave_sol', 45)->nullable()->comment('Clave SOL para facturación');
        $table->tinyInteger('es_principal')->default(0)->comment('Indica si es la empresa principal (1 = Sí, 0 = No)');
        $table->tinyInteger('fact_bol_defecto')->default(0)->comment('Facturación y boletas por defecto (1 = Sí, 0 = No)');
        $table->string('logo', 150)->nullable()->comment('Logo de la empresa');
        $table->string('bbva_cci', 45)->nullable()->comment('Número de cuenta CCI del BBVA');
        $table->string('bcp_cci', 45)->nullable()->comment('Número de cuenta CCI del BCP');
        $table->string('yape', 45)->nullable()->comment('Número de cuenta en Yape');
        $table->tinyInteger('estado')->default(1)->comment('Estado de la empresa (1 = Activo, 0 = Inactivo)');
        $table->integer('production')->default(0)->comment('Indica si está en modo de producción (1 = Sí, 0 = No)');
        $table->string('client_id', 150)->nullable()->comment('ID del cliente para integraciones');
        $table->dateTime('client_secret')->nullable()->comment('Clave secreta del cliente para integraciones');
        $table->string('certificado_digital_pem', 255)->nullable()->comment('Certificado digital en formato PEM');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('producto_sin_ubicacion');
        Schema::dropIfExists('empresas');
    }
};
