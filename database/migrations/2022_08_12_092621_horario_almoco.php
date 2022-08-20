<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HorarioAlmoco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_almoco', function (Blueprint $table) {
            $table->increments('id');
            $table->time('inicio');
            $table->time('fim');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario_almoco');
    }
}
