<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('vehi_placa', 20)->unique();
            $table->string('vehi_tag', 12)->unique()->nullable();
            $table->string('vehi_tipo_vehi', 1);
            $table->string('vehi_tipo_comb', 1);
            $table->integer('vehi_capacidad_Lts')->length(4);
            $table->string('vehi_estado', 1);
            $table->string('vehi_observacion', 250)->nullable();

            $table->unsignedBigInteger('vehi_pers_id');
            $table->foreign('vehi_pers_id')
                ->references('id')
                ->on('personas')
                ->onDelete('cascade');

            $table->unsignedBigInteger('vehi_mod_id');
            $table->foreign('vehi_mod_id')
                ->references('id')
                ->on('modelo_vehi')
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
        Schema::dropIfExists('vehiculos');
    }
}
