<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('pers_cedula', 10)->unique();
            $table->string('pers_nombres', 100);
            $table->string('pers_apellidos', 100);
            $table->string('pers_telefono', 14)->nullable();
            $table->string('pers_correo', 100)->nullable();
            $table->string('pers_estado', 1);
            $table->string('pers_observacion', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
