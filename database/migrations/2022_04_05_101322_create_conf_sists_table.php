<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfSistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_sist', function (Blueprint $table) {
            $table->id();
            $table->string('confs_nombre', 100);
            $table->string('confs_rif', 12);
            $table->string('confs_direccion', 100);
            $table->string('confs_telefono', 14);
            $table->string('confs_sitio_web', 100);
            $table->string('confs_correo', 100);
            $table->string('confs_estado', 1);
            $table->string('confs_observacion', 250);
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
        Schema::dropIfExists('conf_sist');
    }
}
