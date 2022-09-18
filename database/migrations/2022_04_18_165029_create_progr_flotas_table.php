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
            $table->id();
            $table->integer('pflo_litros')->length(3);
            $table->integer('pflo_litros_paga')->length(3)->nullable();
            $table->integer('pflo_litros_desp')->length(3)->nullable();
            $table->string('pflo_condicion', 1);
            $table->string('pflo_observacion', 250)->nullable();
            $table->unsignedBigInteger('pflo_prog_id');
            $table->unsignedBigInteger('pflo_flot_id');
            $table->unique(['pflo_prog_id', 'pflo_flot_id']);

            $table->foreign('pflo_prog_id')
                ->references('id')
                ->on('programaciones')
                ->onDelete('cascade');

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
