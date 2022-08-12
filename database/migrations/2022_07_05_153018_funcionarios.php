<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Funcionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcao_tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cor');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('users');
        });

        Schema::create('funcao_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcao_tipo')->unsigned();
            $table->foreign('id_funcao_tipo')->references('id')->on('funcao_tipo');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('funcao_tipo');
        Schema::dropIfExists('funcao_funcionario');
    }
}
