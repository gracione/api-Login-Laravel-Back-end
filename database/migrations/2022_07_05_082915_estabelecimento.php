<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Estabelecimento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estabelecimento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('id_proprietario')->unsigned();
            $table->foreign('id_proprietario')->references('id')->on('users');
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
    }
}
