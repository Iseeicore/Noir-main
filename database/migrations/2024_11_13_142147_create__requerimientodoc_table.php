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
         // Crear la tabla 'requerimiento_head'
        Schema::create('requerimiento_head', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key');
            $table->char('cod_req', 60)->comment('Código de Requerimiento');
            $table->date('fecha_req')->comment('Fecha de Requerimiento');
            $table->tinyInteger('estado')->comment('Estado del Requerimiento');
            $table->unsignedBigInteger('encargado')->comment('ID del Usuario Encargado');
            $table->unsignedBigInteger('solicitante')->comment('ID del Usuario Solicitante');
            $table->unsignedBigInteger('Area_recibida')->comment('ID del Usuario que Recoge');
            $table->unsignedBigInteger('revisado_req')->nullable()->comment('ID del Usuario que Revisó el Requerimiento');

            // Foreign keys
            
            $table->foreign('encargado')->references('id_usuario')->on('usuarios');
            $table->foreign('solicitante')->references('id_usuario')->on('usuarios');
            $table->foreign('Area_recibida')->references('id_area')->on('area');
            $table->foreign('revisado_req')->references('id_usuario')->on('usuarios');
        });

        // Crear la tabla 'requerimiento_body'
        Schema::create('requerimiento_body', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key'); 
            $table->unsignedInteger('id_requerimiento_head')->comment('ID de la tabla requerimiento_head');
            $table->string('nombre_prod', 250)->comment('Nombre del Producto');
            $table->char('unidad_medida', 10)->comment('ID de Unidad de Medida');
            $table->string('nombre_marca', 250)->comment('Nombre de la Marca');
            $table->integer('cantidad')->comment('Cantidad del Producto');
            $table->unsignedInteger('centro_costo')->comment('Centro de costo asignado');
            

            // Foreign keys
            $table->foreign('id_requerimiento_head')->references('id')->on('requerimiento_head')->onDelete('cascade');
            $table->foreign('unidad_medida')->references('id')->on('unidad_medida')->onDelete('cascade');
            $table->foreign('centro_costo')->references('id')->on('centro_costo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimiento_head');
        Schema::dropIfExists('requerimiento_body');
    }
};
