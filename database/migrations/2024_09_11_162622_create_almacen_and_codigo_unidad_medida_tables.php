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
        // Crear la tabla 'almacen'
        Schema::create('almacen', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key'); // int, autoincrement
            $table->string('nomb_almacen', 150)->comment('nombre del almacen'); // varchar(150)
            $table->string('ubic_almacen', 250)->comment('ubicacion del almacen'); // varchar(250)
            $table->integer('estado')->default(1)->comment('Estado'); // default 1
        });

        // Crear la tabla 'codigo_unidad_medida'
        Schema::create('unidad_medida', function (Blueprint $table) {
            $table->char('id', 10)->primary()->comment('Primary Key'); // char(10), no autoincrement
            $table->string('nomb_uniMed', 150)->comment('nombre de unidad de medida'); // varchar(150)
            $table->integer('estado')->default(1)->comment('Estado'); // default 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_medida');
        Schema::dropIfExists('almacen');
    }
};
