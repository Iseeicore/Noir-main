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
        Schema::create('historico_carga_masivas', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key, autoincrement'); // int, autoincrement
            $table->integer('nucleos_insertados')->default(0)->comment('Número de núcleos insertados'); // int
            $table->integer('nucleos_omitidos')->default(0)->comment('Número de núcleos omitidos'); // int
            $table->integer('centros_costo_insertados')->default(0)->comment('Número de centros de costo insertados'); // int
            $table->integer('centros_costo_omitidos')->default(0)->comment('Número de centros de costo omitidos'); // int
            $table->integer('categorias_insertadas')->default(0)->comment('Número de categorías insertadas'); // int
            $table->integer('categorias_omitidas')->default(0)->comment('Número de categorías omitidas'); // int
            $table->integer('almacenes_insertados')->default(0)->comment('Número de almacenes insertados'); // int
            $table->integer('almacenes_omitidos')->default(0)->comment('Número de almacenes omitidos'); // int
            $table->integer('codigo_unidades_medida_insertadas')->default(0)->comment('Número de códigos de unidad de medida insertados'); // int
            $table->integer('codigo_unidades_medida_omitidas')->default(0)->comment('Número de códigos de unidad de medida omitidos'); // int
            $table->integer('tipo_afectacion_insertados')->default(0)->comment('Número de tipos de afectación insertados'); // int
            $table->integer('tipo_afectacion_omitidos')->default(0)->comment('Número de tipos de afectación omitidos'); // int
            $table->integer('productos_insertados')->default(0)->comment('Número de productos insertados'); // int
            $table->integer('productos_omitidos')->default(0)->comment('Número de productos omitidos'); // int
            $table->tinyInteger('estado_carga')->default(0)->comment('Estado de la carga: 0=pendiente, 1=completado'); // tinyint
            $table->timestamps(); // created_at, updated_at
        });
        
        Schema::create('kardex', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key, autoincrement'); // Primary Key
            $table->unsignedInteger('id_producto')->comment('Foreign Key: Identificador único del producto'); // Nueva columna
            $table->string('codigo_producto', 20)->nullable()->comment('Código del producto');
            $table->unsignedInteger('almacen')->comment('Foreign Key: Identificador del almacén');
            $table->unsignedInteger('almacenDestino')->comment('Foreign Key: Identificador del almacén al que se direccionara en la salida');

            $table->dateTime('fecha')->nullable()->comment('Fecha del movimiento');
            $table->string('concepto', 100)->nullable()->comment('Concepto del movimiento');
            $table->string('comprobante', 50)->nullable()->comment('Número de comprobante asociado');
            $table->unsignedInteger('centro_costo')->nullable()->comment('Foreign Key: Centro de costo'); // Nueva columna
            $table->string('descripcion_centro_costo', 150)->nullable()->comment('Nombre del centro de costo'); // Nueva columna
            $table->float('in_unidades')->nullable()->comment('Unidades que ingresan');
            $table->float('in_costo_unitario')->nullable()->comment('Costo unitario de entrada');
            $table->float('in_costo_total')->nullable()->comment('Costo total de entrada');
            $table->float('out_unidades')->nullable()->comment('Unidades que salen');
            $table->float('out_costo_unitario')->nullable()->comment('Costo unitario de salida');
            $table->float('out_costo_total')->nullable()->comment('Costo total de salida');
            $table->float('ex_unidades')->nullable()->comment('Existencias finales en unidades');
            $table->float('ex_costo_unitario')->nullable()->comment('Costo unitario de existencia final');
            $table->float('ex_costo_total')->nullable()->comment('Costo total de existencia final');
            $table->timestamps();
        
            // Definir las llaves foráneas
            $table->foreign('id_producto')->references('id')->on('producto')->onDelete('cascade')->comment('Foreign key con producto');
            $table->foreign('almacen')->references('id')->on('almacen')->onDelete('cascade')->comment('Foreign key con almacen');
            $table->foreign('almacenDestino')->references('id')->on('almacen')->onDelete('cascade')->comment('Foreign key con almacen');
            
            $table->foreign('centro_costo')->references('id')->on('centro_costo')->onDelete('cascade')->comment('Foreign key con centro_costo');
            $table->index('codigo_producto')->comment('Índice para búsqueda rápida por código de producto');
            $table->index('descripcion_centro_costo')->comment('Índice para búsqueda rápida nombre de centro costo');

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_cargas_masivas');
        
        Schema::dropIfExists('kardex');
    }
};
