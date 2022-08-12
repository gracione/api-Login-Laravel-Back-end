<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_estabelecimento');
            $table->string('nome');
            $table->string('numero');
            $table->integer('tipo_usuario')->unsigned();
            $table->foreign('tipo_usuario')->references('id')->on('tipo_usuario');
            $table->integer('id_sexo')->unsigned();
            $table->foreign('id_sexo')->references('id')->on('sexo');
            $table->integer('id_estabelecimento')->unsigned();
            $table->foreign('id_estabelecimento')->references('id')->on('estabelecimento');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
