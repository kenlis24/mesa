<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrFlotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progr_flotas', function (Blueprint $table) {
            //$table->id();
            $table->integer('pflo_litros'); 
            $table->string('pflo_condicion', 1); 
            $table->string('pflo_observacion', 250)->nullable(); 
            $table->integer('var')->

            $table->unsignedBigInteger('pflo_prog_id');
            $table->foreign('pflo_prog_id')
                ->references('id')
                ->on('programaciones')
                ->onDelete('cascade');

            $table->unsignedBigInteger('pflo_flot_id');
            $table->foreign('pflo_flot_id')
                ->references('id')
                ->on('flotas')
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
        Schema::dropIfExists('progr_flotas');
    }
}
