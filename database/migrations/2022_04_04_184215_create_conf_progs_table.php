<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfProgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_prog', function (Blueprint $table) {
            $table->id();
            $table->string('conp_tipo_vehi', 1);
            $table->string('conp_tipo_comb', 1);
            $table->integer('conp_lts')->length(3);
            $table->string('conp_estado', 1);
            $table->string('conp_observacion', 250);
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
        Schema::dropIfExists('conf_prog');
    }
}
