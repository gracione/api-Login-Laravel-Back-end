<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HorarioTrabalho extends Model
{
    use HasFactory;
    public function listar()
    {
        $select = DB::table('horario_trabalho')
            ->select(
                'users.nome as funcionario',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->join('users', 'users.id', '=', 'horario_trabalho.id_usuario')
            ->get();
        return $select;
    }
    public function listarById($idFuncionario)
    {
        $select = DB::table('horario_trabalho')
            ->select(
                'users.nome as nome',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->join('funcionario', 'funcionario.id', '=', 'horario_trabalho.id_funcionario')
            ->join('users', 'users.id', '=', 'funcionario.id_usuario')
            ->where('funcionario.id', '=', $idFuncionario)
            ->get();
        $result = $select->toArray();
        return $result[0]??0;
    }
    public function inserir($request)
    {
        DB::table('horario_trabalho')->insert([
            'inicio1' => $request->inicioExpediente . ":00",
            'fim1' => $request->inicioAlmoco . ":00",
            'inicio2' => $request->fimAlmoco . ":00",
            'fim2' => $request->fimExpediente . ":00",
            'id_funcionario' => $request->idFuncionario
        ]);

        return 'cadastrado';
    }
    public function excluir($request)
    {

        DB::table('horario_trabalho')->delete($request->id);

        return 'excluido';
    }
}