<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_afectacion_igv');
    }
};
