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
        Schema::create('tipo_afectacion_igv', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key'); // int, autoincrement
            $table->char('codigo', 7)->comment('Codigo de afectacion'); // char(7)
            $table->string('nomb_impuesto', 150)->comment('nombre de impuesto'); // varchar(150)
            $table->char('letra_tributo', 9)->comment('letra tributaria');// char(9)
            $table->char('codigo_tributo', 10)->comment('codigo tributaria'); // char(10)
            $table->string('nomb_tributo', 150)->comment('nombre del tributo'); // varchar(150)
            $table->char('tipo_tributo', 10)->comment('tipo tributo'); // char(10)
            $table->integer('porcentaje')->comment('Porcentaje'); // int
            $table->integer('estado')->default(1)->comment('Estado'); // default 1
        });

        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key: Identificador único del producto'); // int, autoincrement
            $table->char('codigo_productos', 100)->comment('Código único del producto'); // char(100)
            $table->char('id_categorias', 10)->comment('Foreign Key: Categoría del producto'); // llave foránea, char(10)
            $table->unsignedInteger('id_almacen')->comment('Foreign Key: Identificador del almacén'); // llave foránea
            $table->string('descripcion', 250)->comment('Descripción detallada del producto'); // varchar(250)
            $table->unsignedInteger('id_tipo_afectacion_igv')->comment('Foreign Key: Tipo de afectación del IGV'); // llave foránea
            $table->char('id_unidad_medida', 10)->comment('Foreign Key: Unidad de medida del producto'); // llave foránea, char(10)
            $table->double('costo_unitario', 8, 2)->comment('Costo unitario del producto'); // double
            $table->integer('Precio_unitario_sin_igv')->nullable()->comment('Precio unitario sin IGV'); // int
            $table->integer('Precio_unitario_con_igv')->nullable()->comment('Precio unitario con IGV'); // int
            $table->integer('stock')->comment('Cantidad de stock disponible'); // int
            $table->integer('minimo_stock')->default(10)->comment('Stock mínimo permitido, default 10'); // int, default 10
            $table->integer('costo_total')->comment('Costo total del producto'); // int
            $table->text('imagen')->comment('Imagen del producto'); // text
            $table->integer('estado')->default(1)->comment('Estado del producto, default 1'); // default 1
        
            // Definir las llaves foráneas
            $table->foreign('id_categorias')->references('id')->on('categoria');
            $table->foreign('id_almacen')->references('id')->on('almacen');
            $table->foreign('id_tipo_afectacion_igv')->references('id')->on('tipo_afectacion_igv');
            $table->foreign('id_unidad_medida')->references('id')->on('unidad_medida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_afectacion_igv');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('unidad_medida');
        Schema::dropIfExists('almacen');
    }
};
