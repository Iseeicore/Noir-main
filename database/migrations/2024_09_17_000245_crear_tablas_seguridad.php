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
        // Crear tabla PERFILES
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id('id_perfil')->comment('Primary Key - Identificador único del perfil');
            $table->string('descripcion', 100)->comment('Nombre o descripción del perfil');
            $table->tinyInteger('estado')->default(1)->comment('Estado del perfil: 1=Activo, 0=Inactivo');
            $table->string('fecha_creacion', 12)->default('null')->comment('Fecha de creación del perfil');
            $table->string('fecha_actualizacion', 12)->default('null')->comment('Fecha de última actualización del perfil');
        });

        // Crear la tabla MODULOS
        Schema::create('modulos', function (Blueprint $table) {
            $table->id('id')->comment('Primary Key - Identificador único del módulo');
            $table->string('modulo', 100)->default(null)->comment('Nombre del módulo');
            $table->string('padre_id', 100)->default(null)->comment('ID del módulo padre, para jerarquía');
            $table->string('vista', 46)->default(null)->comment('Nombre de la vista asociada al módulo');
            $table->string('icon_menu', 45)->default(null)->comment('Icono del menú asociado al módulo');
            $table->integer('orden')->default(null)->comment('Orden de visualización en el menú');
        });

        // Crear la tabla PERFIL_MODULO
        Schema::create('perfil_modulo', function (Blueprint $table) {
            $table->id('idperfil_modulo')->comment('Primary Key - Identificador único del perfil-módulo');
            $table->foreignId('id_perfil')
                ->constrained('perfiles', 'id_perfil')
                ->onDelete('cascade')
                ->comment('Foreign Key - Relaciona con el perfil correspondiente');
            $table->foreignId('id_modulo')
                ->constrained('modulos', 'id')
                ->onDelete('cascade')
                ->comment('Foreign Key - Relaciona con el módulo correspondiente');
            $table->tinyInteger('vista_inicio')->nullable()->comment('Indica si el módulo es vista de inicio: 1=Sí, 0=No');
            $table->tinyInteger('estado')->nullable()->comment('Estado del perfil-módulo: 1=Activo, 0=Inactivo');
        });

        // Crear tabla AREA
        Schema::create('area', function (Blueprint $table) {
            $table->id('id_area')->comment('Primary Key - Identificador único del área');
            $table->string('descripcion', 100)->nullable()->comment('Nombre o descripción del área');
            $table->tinyInteger('estado')->default(1)->comment('Estado del área: 1=Activo, 0=Inactivo');
        });

        // Crear la tabla USUARIOS
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario')->comment('Primary Key - Identificador único del usuario');
            $table->string('nomb_usuarios', 100)->nullable()->comment('Nombre del usuario');
            $table->string('apellidos_usuarios', 100)->nullable()->comment('Apellidos del usuario');
            $table->string('dni', 8)->nullable()->comment('Documento Nacional de Identidad (DNI) del usuario');
            $table->string('usuario', 100)->nullable()->comment('Nombre de usuario para acceso al sistema');
            $table->text('clave')->nullable()->comment('Contraseña del usuario encriptada');
            $table->unsignedBigInteger('id_perfil_usuario')->comment('Foreign Key - Perfil asignado al usuario');
            $table->unsignedBigInteger('id_Area_usuario')->nullable()->comment('Foreign Key - Área asignada al usuario');
            $table->unsignedInteger('id_almacen_usuario')->nullable()->comment('Foreign Key - Almacén asignado al usuario');
            $table->tinyInteger('estado')->default(1)->comment('Estado del usuario: 1=Activo, 0=Inactivo');

            $table->foreign('id_perfil_usuario')->references('id_perfil')->on('perfiles');
            $table->foreign('id_Area_usuario')->references('id_area')->on('area');
            $table->foreign('id_almacen_usuario')->references('id')->on('almacen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('perfil_modulo');
        Schema::dropIfExists('modulos');
        Schema::dropIfExists('perfiles');
        Schema::dropIfExists('area');


    }
};
