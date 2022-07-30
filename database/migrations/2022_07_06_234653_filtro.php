<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Filtro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filtro_tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('id_funcao_tipo')->unsigned();
            $table->foreign('id_funcao_tipo')->references('id')->on('funcao_tipo');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('users');
        });
        Schema::create('filtro', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('porcentagem_tempo');
            $table->integer('porcentagem_valor');
            $table->integer('id_filtro_tipo')->unsigned();
            $table->foreign('id_filtro_tipo')->references('id')->on('filtro_tipo');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('users');
        });
        DB::table('filtro_tipo')->insert([
            'nome' => 'tamanho',
            'id_funcao_tipo' => '1',
            'id_estabelecimento' => '1'

        ]);
        DB::table('filtro')->insert([
            'nome' => 'pequeno',
            'porcentagem_tempo' => 30,
            'porcentagem_valor' => 30,
            'id_filtro_tipo' => '1',
            'id_estabelecimento' => '1'

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filtro_tipo');
        Schema::dropIfExists('filtro');
    }
}
