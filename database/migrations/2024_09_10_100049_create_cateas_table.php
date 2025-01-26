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
        Schema::create('nucleo', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key');
            $table->char('nomb_nucleo', 100)->comment('nombre de nucleo');
            $table->integer('estado')->default(1)->comment('Estado');
        });

        Schema::create('centro_costo', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key'); // int, autoincrement
            $table->string('Codigo', 150)->comment('Codigo'); // varchar(150)
            $table->string('nomb_centroCos', 150)->comment('nombre del centro de costo'); // varchar(150)
            $table->unsignedInteger('nucleo')->comment('llave foranea nucleo'); // foreign key
            $table->integer('estado')->default(1)->comment('Estado'); // default 1

            $table->foreign('nucleo')->references('id')->on('nucleo'); // llave foránea
        });

        Schema::create('categoria', function (Blueprint $table) {
            $table->char('id', 10)->primary()->comment('Primary Key en formato char'); // char(10), no autoincrement
            $table->string('nomb_cate', 150)->comment('nombre de la categoria'); // varchar(150)
            $table->integer('estado')->default(1)->comment('Estado'); // default 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar las tablas en el orden inverso
        Schema::dropIfExists('nucleo');
        Schema::dropIfExists('centro_costo');
        Schema::dropIfExists('categoria');
    }
};
