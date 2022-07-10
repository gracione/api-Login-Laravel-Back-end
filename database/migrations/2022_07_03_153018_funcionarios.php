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
        });

        Schema::create('funcao_funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_funcao_tipo')->unsigned();
            $table->foreign('id_funcao_tipo')->references('id')->on('funcao_tipo');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
        });
        DB::table('funcao_tipo')->insert([
            'nome' => 'cabebeleiro',
            'cor' => 'rosa'
        ]);
        DB::table('funcao_funcionario')->insert([
            'id_funcao_tipo' => '1',
            'id_usuario' => '1'
        ]);
        
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
