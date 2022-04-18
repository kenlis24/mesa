<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->string('trab_tipo_trabajador',1); 
            $table->string('trab_cargo', 100); 
            $table->dateTime('trab_fecha_act'); 
            $table->dateTime('trab_fecha_inac');             
            $table->string('trab_estado', 1); 
            $table->string('trab_observacion', 250)->nullable(); 

            $table->unsignedBigInteger('trab_inst_id');
            $table->foreign('trab_inst_id')
                ->references('id')
                ->on('instituciones')
                ->onDelete('cascade');

            $table->unsignedBigInteger('trab_pers_id');
            $table->foreign('trab_pers_id')
                ->references('id')
                ->on('personas')
                ->onDelete('cascade');

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
        Schema::dropIfExists('trabajadores');
    }
}
