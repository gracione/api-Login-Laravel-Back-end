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
        });
        if (true) {
            DB::table('semana')->insert([
                'id' => '1',
                'nome' => 'Domingo'
            ]);
            DB::table('semana')->insert([
                'id' => '2',
                'nome' => 'Segunda Feira'
            ]);
            DB::table('semana')->insert([
                'id' => '3',
                'nome' => 'Terça Feira'
            ]);
            DB::table('semana')->insert([
                'id' => '4',
                'nome' => 'Quarta Feira'
            ]);
            DB::table('semana')->insert([
                'id' => '5',
                'nome' => 'Quinta Feira'
            ]);
            DB::table('semana')->insert([
                'id' => '6',
                'nome' => 'Sexta Feira',
            ]);
            DB::table('semana')->insert([
                'id' => '7',
                'nome' => 'Sabado'
            ]);

            DB::table('tipo_usuario')->insert([
                'id' => '1',
                'nome' => 'administrativo',
            ]);
            DB::table('tipo_usuario')->insert([
                'id' => '2',
                'nome' => 'funcionario',
            ]);
            DB::table('tipo_usuario')->insert([
                'id' => '3',
                'nome' => 'cliente',
            ]);
            DB::table('sexo')->insert([
                'id' => '1',
                'nome' => 'masculino'
            ]);
            DB::table('sexo')->insert([
                'id' => '2',
                'nome' => 'feminino'
            ]);
            //            DB::table('users')->insert([
            //                'id' => '1',
            //                'nome_estabelecimento' => 'null',
            //                'nome' => 'gracione',
            //                'numero' => '(99)9 99999',
            //                'tipo_usuario' => '1',
            //                'id_sexo' => '1',
            //                'email' => 'gracione@gmail.com',
            //                'password' => '$2y$10$HzcQnbhACf/J3RXoOVCq5eduTLtDQJnxX08LZNXsEBqifn8w6eRJi'            
            //            ]);
            //            DB::table('tratamentos')->insert([
            //                'nome' => 'hidratacao',
            //                'tempo_padrao' => '30',
            //                'valor_padrao' => '30',
            //                'id_funcao_tipo' => '1',
            //            ]);
            //            DB::table('filtro_tipo')->insert([
            //                'nome' => 'tamanho',
            //                'id_funcao_tipo' => '1',
            //    
            //            ]);
            //            DB::table('filtro')->insert([
            //                'nome' => 'pequeno',
            //                'porcentagem_tempo' => 30,
            //                'porcentagem_valor' => 30,
            //                'id_filtro_tipo' => '1',
            //    
            //            ]);
            //                    
            //        DB::table('horario')->insert([
            //            'horario_inicio' => '2022-6-21 10:00:00',
            //            'horario_fim' => '2022-6-21 10:30:00',
            //            'id_usuario' => '1',
            //            'id_tratamento' => '1',
            //            'id_funcionario' => '1'
            //        ]);
            //        DB::table('horario')->insert([
            //            'horario_inicio' => '2022-6-21 11:00:00',
            //            'horario_fim' => '2022-6-21 11:20:00',
            //            'id_usuario' => '1',
            //            'id_tratamento' => '1',
            //            'id_funcionario' => '1'
            //        ]);
            //        DB::table('horario')->insert([
            //            'horario_inicio' => '2022-6-21 12:00:00',
            //            'horario_fim' => '2022-6-21 12:45:00',
            //            'id_usuario' => '1',
            //            'id_tratamento' => '1',
            //            'id_funcionario' => '1'
            //        ]);
        }
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
