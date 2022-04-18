<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersComsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pers_coms', function (Blueprint $table) {
            $table->id();
            $table->dateTime('pcom_fecha_act');
            $table->dateTime('pcom_fecha_inac');
            $table->string('pcom_estado', 1);
            $table->timestamps();

            $table->unsignedBigInteger('pcom_agr_id');
            $table->foreign('pcom_agr_id')
                ->references('id')
                ->on('comunidades')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('pcom_pers_id');
            $table->foreign('pcom_pers_id')
                ->references('id')
                ->on('personas')
                ->onDelete('cascade');

            $table->unsignedBigInteger('pcom_car_id');
            $table->foreign('pcom_car_id')
                ->references('id')
                ->on('cargos')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pers_coms');
    }
}
