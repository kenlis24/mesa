<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flotas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('flot_fecha_act');
            $table->dateTime('flot_fecha_inac')->nullable();
            $table->string('flot_estado', 1);
            $table->string('flot_observacion', 250)->nullable();

            $table->unsignedBigInteger('flot_trab_id');
            $table->foreign('flot_trab_id')
                ->references('id')
                ->on('trabajadores')
                ->onDelete('cascade');

            $table->unsignedBigInteger('flot_vehi_id');
            $table->foreign('flot_vehi_id')
                ->references('id')
                ->on('vehiculos')
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
        Schema::dropIfExists('flotas');
    }
}
