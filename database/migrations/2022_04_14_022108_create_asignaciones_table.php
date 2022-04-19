<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->id();
            $table->string('asig_tipo_comb', 1);
            $table->string('asig_tipo_vehi', 1);
            $table->integer('asig_litros')->length(4);
            $table->string('asig_frec_despacho', 1);
            $table->string('asig_estado', 1);
            $table->string('asig_observacion', 250)->nullable();

            $table->unsignedBigInteger('asig_inst_id');
            $table->foreign('asig_inst_id')
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
        Schema::dropIfExists('asignaciones');
    }
}
