<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Horario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('horario_inicio');
            $table->dateTime('horario_fim');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->integer('id_tratamento')->unsigned();
            $table->foreign('id_tratamento')->references('id')->on('tratamentos');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcao_funcionario');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('users');
        });
        DB::table('horario')->insert([
            'horario_inicio' => '2022-6-21 10:00:00',
            'horario_fim' => '2022-6-21 10:30:00',
            'id_usuario' => '1',
            'id_tratamento' => '1',
            'id_funcionario' => '1'
        ]);
        DB::table('horario')->insert([
            'horario_inicio' => '2022-6-21 11:00:00',
            'horario_fim' => '2022-6-21 11:20:00',
            'id_usuario' => '1',
            'id_tratamento' => '1',
            'id_funcionario' => '1'
        ]);
        DB::table('horario')->insert([
            'horario_inicio' => '2022-6-21 12:00:00',
            'horario_fim' => '2022-6-21 12:45:00',
            'id_usuario' => '1',
            'id_tratamento' => '1',
            'id_funcionario' => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario');
    }
}
