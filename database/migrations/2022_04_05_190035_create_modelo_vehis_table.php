<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeloVehisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_vehi', function (Blueprint $table) {
            $table->id();
            $table->string('mod_nombre', 100);
            $table->string('mod_estado', 1);
            $table->timestamps();

            $table->unsignedBigInteger('mod_mca_id');
            $table->foreign('mod_mca_id')
                ->references('id')
                ->on('marca_vehi')
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
        Schema::dropIfExists('modelo_vehi');
    }
}
