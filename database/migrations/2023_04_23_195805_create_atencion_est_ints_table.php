<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionEstIntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion_est_ints', function (Blueprint $table) {
            $table->id();
            $table->integer('atei_usu_id');
            $table->integer('atei_usuins_id');
            $table->integer('atei_usui_mod_id')->nullable();
            $table->string('atei_placa', 10);
            $table->string('atei_tipo_vehi', 10)->nullable();
            $table->string('atei_tipo_comb', 10)->nullable();
            $table->integer('atei_litros')->length(3)->nullable();
            $table->integer('atei_cedula')->length(9)->nullable();
            $table->integer('atei_telefono')->length(11)->nullable();
            $table->dateTime('atei_fecha');
            $table->string('atei_estado', 1);
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
        Schema::dropIfExists('atencion_est_ints');
    }
}
