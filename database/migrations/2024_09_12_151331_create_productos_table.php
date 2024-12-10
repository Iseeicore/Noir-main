<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //  public function up()
    // {
    //     Schema::create('producto', function (Blueprint $table) {
    //         $table->increments('id'); // int, autoincrement
    //         $table->char('Codigo_Prod', 100); // char(100)
    //         $table->char('categoria', 10); // llave foránea, char(10)
    //         $table->unsignedInteger('almacen'); // llave foránea
    //         $table->string('nomb_prod', 250); // varchar(250)
    //         $table->unsignedInteger('impuesto'); // llave foránea
    //         $table->char('unidadmedida', 10); // llave foránea, char(10)
    //         $table->integer('stock'); // int
    //         $table->integer('costounitario'); // int
    //         $table->integer('Precio_unitario_sin_igv'); // int
    //         $table->integer('Precio_unitario_con_igv'); // int
    //         $table->integer('Minimo_stock')->default(10); // int, default 10
    //         $table->integer('Costo_Total'); // int
    //         $table->text('imagen'); // text
    //         $table->timestamps();

    //         // Definir las llaves foráneas
    //         $table->foreign('categoria')->references('id')->on('categoria');
    //         $table->foreign('almacen')->references('id')->on('almacen');
    //         $table->foreign('impuesto')->references('id')->on('impuesto');
    //         $table->foreign('unidadmedida')->references('id')->on('unidad_medida');
    //     });
    // }
    public function up()
    {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
};
