<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('inst_rif',12)->unique();
            $table->string('inst_nombre', 100); 
            $table->string('inst_tipo', 1); 
            $table->string('inst_direccion', 100); 
            $table->string('inst_telefono', 14); 
            $table->string('inst_correo', 100); 
            $table->string('inst_dependencia', 1); 
            $table->string('inst_sector', 1); 
            $table->string('inst_estado', 1); 
            $table->string('inst_observacion', 250)->nullable(); 

            $table->unsignedBigInteger('inst_par_id');
            $table->foreign('inst_par_id')
                ->references('id')
                ->on('parroquias')
                ->onDelete('cascade');

            $table->unsignedBigInteger('inst_gpo_id');
            $table->foreign('inst_gpo_id')
                ->references('id')
                ->on('grupos')
                ->onDelete('cascade');

            $table->unsignedBigInteger('inst_aser_id');
            $table->foreign('inst_aser_id')
                ->references('id')
                ->on('area_servicios')
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
        Schema::dropIfExists('instituciones');
    }
}
