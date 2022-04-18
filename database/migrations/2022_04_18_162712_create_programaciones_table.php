<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programaciones', function (Blueprint $table) {
            $table->id();
            $table->dateTime('prog_fecha'); 
            $table->string('prog_tipo_comb', 1);   
            $table->string('prog_lts', 1);    
            $table->string('prog_tipo_comb',1);         
            $table->string('prog_condicion', 1); 
            $table->string('prog_observacion', 250)->nullable(); 

            $table->unsignedBigInteger('prog_inst_id');
            $table->foreign('prog_inst_id')
                ->references('id')
                ->on('instituciones')
                ->onDelete('cascade');

            $table->unsignedBigInteger('prog_inst_id_es')->nullable();
            $table->foreign('prog_inst_id_es')
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
        Schema::dropIfExists('programaciones');
    }
}
