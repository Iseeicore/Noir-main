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
        Schema::create('caja_chica', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_inicial', 10, 2)->comment('Monto inicial asignado a la caja chica');
            $table->decimal('monto_actual', 10, 2)->comment('Monto actual disponible en la caja chica');
            $table->decimal('monto_gastado', 10, 2)->default(0)->comment('Monto gastado hasta el momento');
            $table->string('descripcion')->nullable()->comment('Descripción o propósito de la caja chica');
            $table->unsignedBigInteger('encargado')->comment('Usuario encargado de esta caja chica');
            $table->date('fecha_creacion');
            $table->tinyInteger('estado')->default(1)->comment('Estado de la caja chica: 1 activa, 0 inactiva');
            $table->timestamps();

            // Relación con la tabla usuarios
            $table->foreign('encargado')->references('id_usuario')->on('usuarios');
        });

        Schema::create('categorias_movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->nullable()->comment('Nombre de la categoría o medio de pago');
            $table->text('descripcion')->nullable()->comment('Descripción de la categoría o medio de pago');
            $table->tinyInteger('estado')->default(1)->comment('Estado de la categoría');
        });

        Schema::create('movimientos_caja_chica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja_chica')->comment('Referencia a la caja chica relacionada');
            $table->enum('tipo_movimiento', ['ingreso', 'egreso'])->comment('Tipo de movimiento: ingreso o egreso');
            $table->decimal('monto', 10, 2)->comment('Monto del movimiento');
            $table->string('descripcion')->nullable()->comment('Descripción del movimiento');
            $table->datetime('fecha');
            $table->string('comprobante')->nullable()->comment('Ruta del comprobante adjunto');
            $table->unsignedBigInteger('usuario_id')->comment('Usuario que realizó el movimiento');
            $table->unsignedBigInteger('categoria_id')->nullable()->comment('Categoría del movimiento');
            $table->timestamps();

            // Relaciones
            $table->foreign('id_caja_chica')->references('id')->on('caja_chica')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('categoria_id')->references('id')->on('categorias_movimientos');
        });

        Schema::create('caja_contable', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_inicial', 10, 2)->comment('Monto inicial asignado a la caja contable');
            $table->decimal('monto_actual', 10, 2)->comment('Monto actual disponible en la caja contable');
            $table->decimal('monto_ingresado', 10, 2)->default(0)->comment('Monto total ingresado');
            $table->decimal('monto_gastado', 10, 2)->default(0)->comment('Monto total gastado');
            $table->unsignedBigInteger('responsable')->comment('Usuario responsable de esta caja contable');
            $table->string('descripcion')->nullable()->comment('Descripción o propósito de la caja contable');
            $table->date('fecha_creacion')->comment('Fecha de creación de la caja');
            $table->tinyInteger('estado')->default(1)->comment('Estado de la caja: 1 activa, 0 inactiva');
            $table->timestamps();

            // Relación con la tabla usuarios
            $table->foreign('responsable')->references('id_usuario')->on('usuarios');
        });

        Schema::create('movimientos_caja_contable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja_contable')->comment('Referencia a la caja contable relacionada');
            $table->enum('tipo_movimiento', ['ingreso', 'egreso'])->comment('Tipo de movimiento: ingreso o egreso');
            $table->decimal('monto', 10, 2)->comment('Monto del movimiento');
            $table->string('concepto', 255)->nullable()->comment('Monto');
            $table->string('descripcion')->nullable()->comment('Descripción del movimiento');
            $table->datetime('fecha')->comment('Fecha del movimiento');
            $table->string('referencia')->nullable()->comment('Referencia o comprobante relacionado');
            $table->unsignedBigInteger('usuario_id')->comment('Usuario que realizó el movimiento');
            $table->unsignedBigInteger('categoria_id')->nullable()->comment('Categoría del movimiento');
            $table->timestamps();

            // Relaciones
            $table->foreign('id_caja_contable')->references('id')->on('caja_contable')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('categoria_id')->references('id')->on('categorias_movimientos');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('caja_chica');
        Schema::dropIfExists('categorias_movimientos');
        Schema::dropIfExists('movimientos_caja_chica');
        Schema::dropIfExists('caja_contable');
        Schema::dropIfExists('movimientos_caja_contable');
    }

};
