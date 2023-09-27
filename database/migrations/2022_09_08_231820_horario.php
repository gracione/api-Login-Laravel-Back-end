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
            $table->integer('id_cliente')->unsigned();
            $table->foreign('id_cliente')->references('id')->on('users');
            $table->integer('id_tratamento')->unsigned();
            $table->foreign('id_tratamento')->references('id')->on('tratamento');
            $table->integer('id_funcionario')->unsigned();
            $table->foreign('id_funcionario')->references('id')->on('funcionario');
            $table->boolean('confirmado');
            $table->string('nome_cliente');
        });
            $semanaData = [
                ['id' => 1, 'nome' => 'Domingo'],
                ['id' => 2, 'nome' => 'Segunda Feira'],
                ['id' => 3, 'nome' => 'Terça Feira'],
                ['id' => 4, 'nome' => 'Quarta Feira'],
                ['id' => 5, 'nome' => 'Quinta Feira'],
                ['id' => 6, 'nome' => 'Sexta Feira'],
                ['id' => 7, 'nome' => 'Sábado'],
            ];
            DB::table('semana')->insert($semanaData);

            $tipoUsuarioData = [
                ['id' => 1, 'nome' => 'administrativo'],
                ['id' => 2, 'nome' => 'funcionario'],
                ['id' => 3, 'nome' => 'cliente'],
            ];
            DB::table('tipo_usuario')->insert($tipoUsuarioData);

            $sexoData = [
                ['id' => 1, 'nome' => 'masculino'],
                ['id' => 2, 'nome' => 'feminino'],
                ['id' => 3, 'nome' => 'outro'],
            ];
            DB::table('sexo')->insert($sexoData);

            $servicoData = [
                ['id' => 2, 'nome' => 'funcionários', 'url' => 'funcionarios', 'id_tipo_usuario' => 1],
                ['id' => 3, 'nome' => 'feriados', 'url' => 'feriados', 'id_tipo_usuario' => 1],
                ['id' => 4, 'nome' => 'folgas', 'url' => 'folgas', 'id_tipo_usuario' => 1],
                ['id' => 5, 'nome' => 'tratamentos', 'url' => 'tratamentos', 'id_tipo_usuario' => 1],
                ['id' => 6, 'nome' => 'profissão', 'url' => 'profissao', 'id_tipo_usuario' => 1],
            ];
            DB::table('servico')->insert($servicoData);
            
            Schema::create('configuracao', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome_estabelecimento')->nullable();
                $table->string('frequencia_horario')->nullable();
                $table->string('contato_estabelcimento')->nullable();
                $table->string('localizacao')->nullable();
                $table->string('email_estabelecimento')->nullable();
                $table->string('endereco')->nullable();
                $table->boolean('cliente_agendar')->nullable();
                $table->boolean('cliente_alterar_horario')->nullable();
                $table->boolean('cliente_desmarcar_horario')->nullable();
                $table->time('inicio')->nullable();
                $table->time('inicio_almoco')->nullable();
                $table->time('fim_almoco')->nullable();
                $table->time('fim')->nullable();    
            });
            DB::table('configuracao')->insert(['nome_estabelecimento' => 'salao','frequencia_horario' => '20','contato_estabelcimento' => '99999','localizacao' => '11','email_estabelecimento' => 'teste','endereco' => 'teste','cliente_agendar' => 'teste','cliente_alterar_horario' => 'teste','cliente_desmarcar_horario' => 'teste','inicio' => 'teste','inicio_almoco' => 'teste','fim_almoco' => 'teste','fim' => 'teste']);

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
