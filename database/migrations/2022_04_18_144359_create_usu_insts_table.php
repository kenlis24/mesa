<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuInstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usu_insts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('usui_fecha_act'); 
            $table->dateTime('usui_fecha_inac'); 
            $table->string('usui_estado', 1); 
            $table->string('asig_estado', 1); 
            $table->string('usui_observacion', 250)->nullable(); 

            $table->unsignedBigInteger('usui_inst_id');
            $table->foreign('usui_inst_id')
                ->references('id')
                ->on('instituciones')
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
        Schema::dropIfExists('usu_insts');
    }
}
