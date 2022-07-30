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
        Schema::create('usuario_tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });
        DB::table('usuario_tipo')->insert([
            'id' => '1',
            'nome' => 'administrativo',
        ]);
        DB::table('usuario_tipo')->insert([
            'id' => '2',
            'nome' => 'funcionario',
        ]);
        DB::table('usuario_tipo')->insert([
            'id' => '3',
            'nome' => 'cliente',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_tipo');
    }
}
