<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Tratamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('tempo_gasto');
            $table->integer('id_profissao')->unsigned();
            $table->foreign('id_profissao')->references('id')->on('profissao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tratamentos');
    }
}
