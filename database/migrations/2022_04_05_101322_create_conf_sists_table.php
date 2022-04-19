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
            $table->string('cnfs_nombre', 100);
            $table->string('cnfs_rif', 12);
            $table->string('cnfs_direccion', 100);
            $table->string('cnfs_telefono', 14);
            $table->string('cnfs_sitio_web', 100);
            $table->string('cnfs_correo', 100);
            $table->string('cnfs_estado', 1);
            $table->string('cnfs_observacion', 250)->nullable();
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
