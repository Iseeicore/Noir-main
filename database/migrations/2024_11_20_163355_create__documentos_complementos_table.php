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
        // Schema::create('tipo_operaciones', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador tipo operaciones');
        //     $table->string('descripcion')->comment('Nombre de los tipo de operaciones');
        //     $table->enum('tipo', ['ENTRADA', 'SALIDA', 'DEVOLUCIÓN', 'NINGUNO'])->comment('Clasificación de las operaciones');
        //     $table->tinyInteger('estado')->default(1)->comment('Estado de la tipo de operacion');
        // });

        // Schema::create('comprobante_pago', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de comprobante de pago ');
        //     $table->string('descripcion')->comment('Nombre de los tipo de comprobante de pago');
        //     $table->tinyInteger('estado')->default(1)->comment('Estado del comprobante de pago');
        // });
        
        // Schema::create('tipo_cambio', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de comprobante de pago ');
        //     $table->date('fecha')->comment('fecha del movimiento de tipo de cambio');
        //     $table->char('moneda_origen', 3)->comment('valor de la mondea de origen');
        //     $table->char('moneda_destino', 3)->comment('valor de la mondea de origen');
        //     $table->decimal('tipo_cambio_compra ', 10, 4)->comment('valor de la moneda de origen');
        //     $table->decimal('tipo_cambio_venta ', 10, 4)->comment('valor de la moneda de origen');
        //     $table->tinyInteger('estado')->default(1)->comment('Estado del tipo de cambio');
        // });

        // Schema::create('documento_ingreso_head', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de documento de ingreso ');
        //     $table->char('codigo_head')->comment('codigo de los documentos de ingreso');
        //     $table->date('fecha_emision')->comment('fecha del documento de ingreso');
        //     $table->date('fecha_contable')->comment('fecha contable de documento');
        //     $table->char('periodo')->comment('periodo de fecha');
        //     $table->Integer('tipo_operacion')->comment('llave foranea de la tabla tipo de operaciones');
        //     $table->unsignedInteger('proveedor')->comment('llave foranea de la tabla proveedor');
        //     $table->unsignedInteger('almacen')->comment('llave foranea de la tabla almacen');
        //     $table->Integer('comprobante_pago')->comment('llave foranea de la tabla comprobante_pago');
        //     $table->Integer('tipo_cambio')->comment('llave foranea de la tabla tipo cambio');
        //     $table->char('numerodocumento')->comment('el primer numero documento');
        //     $table->char('numerosecundariodocumento')->comment('el segundo numero documento');
        //     $table->char('glosario')->comment('Glosario agrupacion comprobante de pago + primer num +segundo num');
        //     $table->integer('Total_efectivo_Compelto')->comment('Numero total de producto completo');
        //     $table->unsignedbigInteger('UsuarioCreacion')->comment('identificador del usuario que creo el documento de ingreso');
        //     $table->char('nomb_moneda', 40)->nullable()->comment('Nombre de la moneda');
        //     $table->double('registro_cambio_al_dia', 10, 4)->nullable()->comment('Registro del cambio al día');

        //     $table->foreign('tipo_operacion')->references('id')->on('tipo_operaciones')->onDelete('cascade');
        //     $table->foreign('proveedor')->references('id')->on('proveedores')->onDelete('cascade');
        //     $table->foreign('almacen')->references('id')->on('almacen')->onDelete('cascade');
        //     $table->foreign('comprobante_pago')->references('id')->on('comprobante_pago')->onDelete('cascade');
        //     $table->foreign('tipo_cambio')->references('id')->on('tipo_cambio')->onDelete('cascade');
        //     $table->foreign('UsuarioCreacion')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        // });

        // Schema::create('documento_ingreso_body', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de cuerpo del documento');
        //     $table->unsignedInteger('documento_ingreso_head_id')->comment('llave foranea de la tabla documento_ingreso_head');
        //     $table->unsignedInteger('producto')->comment('llave foranea de la tabla producto');
        //     $table->integer('cantidad')->comment('valor de la moneda de origen');
        //     $table->unsignedInteger('centro_costos')->comment('llave foranea de la tabla centro_costos');
        //     $table->unsignedInteger('tipo_afectacion')->comment('llave foranea de la tabla tipo_afectacion');
        //     $table->decimal('precio_unitario', 10, 4)->comment('precio unitario de producto');
        //     $table->decimal('total', 10, 4)->comment('total de producto');

        //     $table->foreign('documento_ingreso_head_id')->references('id')->on('documento_ingreso_head')->onDelete('cascade');
        //     $table->foreign('producto')->references('id')->on('producto_sin_ubicacion')->onDelete('cascade');
        //     $table->foreign('centro_costos')->references('id')->on('centro_costo')->onDelete('cascade');
        //     $table->foreign('tipo_afectacion')->references('id')->on('tipo_afectacion_igv')->onDelete('cascade');
            
        // });
        

        // Schema::create('documento_salida_head', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de documento de salida');
        //     $table->char('codigo_head')->comment('codigo de los documentos de salida');
        //     $table->date('fecha_emision')->comment('fecha del documento de ingreso');
        //     $table->date('fecha_contable')->comment('fecha contable de documento');
        //     $table->char('periodo')->comment('periodo de fecha');
        //     $table->Integer('tipo_operacion')->comment('llave foranea de la tabla tipo de operaciones');
        //     $table->unsignedInteger('almacenOrigenUsuario')->comment('llave foranea de la tabla almacen origen usuario');
        //     $table->unsignedInteger('almacenDestino')->comment('llave foranea de la tabla almacen destino');
        //     $table->unsignedbigInteger('UsuarioRecivir')->comment('identificador del usuario que se le asignara a recibir');
        //     $table->char('numerodocumento')->comment('el primer numero documento');
        //     $table->char('numerosecundariodocumento')->comment('el segundo numero documento');
        //     $table->char('glosario')->comment('Glosario agrupacion comprobante de pago + primer num +segundo num');
        //     $table->integer('Total_efectivo_Compelto')->comment('Numero total de producto completo');
        //     $table->unsignedbigInteger('UsuarioCreacion')->comment('identificador del usuario que creo el documento de ingreso');


            
        //     $table->foreign('tipo_operacion')->references('id')->on('tipo_operaciones')->onDelete('cascade');
        //     $table->foreign('almacenOrigenUsuario')->references('id')->on('almacen')->onDelete('cascade');
        //     $table->foreign('almacenDestino')->references('id')->on('almacen')->onDelete('cascade');
        //     $table->foreign('UsuarioRecivir')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        //     $table->foreign('UsuarioCreacion')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        // });

        // Schema::create('documento_salida_body', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador de cuerpo del documento');
        //     $table->unsignedInteger('documento_salida_head_id')->comment('llave foranea de la tabla documento_ingreso_head');
        //     $table->unsignedInteger('producto')->comment('llave foranea de la tabla producto');
        //     $table->integer('cantidad')->comment('valor de la moneda de origen');
        //     $table->unsignedInteger('centro_costos')->comment('llave foranea de la tabla centro_costos');
        //     $table->unsignedInteger('tipo_afectacion')->comment('llave foranea de la tabla tipo_afectacion');
        //     $table->decimal('precio_unitario', 10, 4)->comment('precio unitario de producto');
        //     $table->decimal('total', 10, 4)->comment('total de producto');

        //     $table->foreign('documento_salida_head_id')->references('id')->on('documento_salida_head')->onDelete('cascade');
        //     $table->foreign('producto')->references('id')->on('producto')->onDelete('cascade');
        //     $table->foreign('centro_costos')->references('id')->on('centro_costo')->onDelete('cascade');
        //     $table->foreign('tipo_afectacion')->references('id')->on('tipo_afectacion_igv')->onDelete('cascade');
            

        // });

        // Schema::create('Config_Rutas', function (Blueprint $table) {
        //     $table->increments('id')->comment('Identificador único de la configuración');
        //     $table->string('api_url', 255)->comment('URL de la API que será configurada');
        //     $table->text('api_token')->comment('Token de acceso para la API');
        //     $table->unsignedBigInteger('UsuarioModificar')->comment('Identificador del usuario que realizó la última modificación');

        //     // Relación con la tabla usuarios
        //     $table->foreign('UsuarioModificar')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        // });
    
        Schema::create('CodigoAcceso', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador único de la configuración');
            $table->string('CodigoAcceso', 255)->comment('URL de la API que será configurada');
            $table->unsignedBigInteger('UsuarioModificar')->comment('Identificador del usuario que realizó la última modificación');
        
            $table->foreign('UsuarioModificar')->references('id_usuario')->on('usuarios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('tipo_operaciones');
        // Schema::dropIfExists('comprobante_pago');
        // Schema::dropIfExists('tipo_cambio');
        // Schema::dropIfExists('documento_ingreso_head');
        // Schema::dropIfExists('documento_ingreso_body');
        // Schema::dropIfExists('documento_salida_head');
        // Schema::dropIfExists('documento_salida_body');
        // Schema::dropIfExists('Config_Rutas');
        Schema::dropIfExists('CodigoAcceso');

    }
};
