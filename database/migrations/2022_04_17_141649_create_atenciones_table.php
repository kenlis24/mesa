<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();

            $table->dateTime('aten_fecha');
            $table->string('aten_tipo_comb', 1);
            $table->integer('aten_lts_prog')->length(6);
            $table->integer('aten_lts_despacho')->length(6);
            $table->integer('aten_asistentes')->length(6);
            $table->integer('aten_ausentes')->length(6);
            $table->string('aten_observacion', 250)->nullable();

            $table->unsignedBigInteger('aten_inst_id');
            $table->foreign('aten_inst_id')
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
        Schema::dropIfExists('atenciones');
    }
}
