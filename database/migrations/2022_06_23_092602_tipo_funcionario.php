<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TipoFuncionario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });

        Schema::create('servico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('url');
            $table->integer('id_tipo_usuario')->unsigned();
            $table->foreign('id_tipo_usuario')->references('id')->on('tipo_usuario');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_usuario');
    }
}
