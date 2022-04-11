<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgrupacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agrupaciones', function (Blueprint $table) {
            $table->id();
            $table->string('agr_nombre', 250);
            $table->string('agr_estado', 1);
            $table->timestamps();

            $table->unsignedBigInteger('agr_par_id');
            $table->foreign('agr_par_id')
                ->references('id')
                ->on('parroquias')
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
        Schema::dropIfExists('agrupaciones');
    }
}
