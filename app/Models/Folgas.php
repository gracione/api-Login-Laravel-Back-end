<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folgas extends Model
{
    use HasFactory;

    public function listar()
    {
        $select = DB::table('folga')
        ->join('funcionario', 'funcionario.id', '=', 'folga.id_funcionario')
        ->join('users', 'users.id', '=', 'funcionario.id_usuario')
        ->join('semana', 'semana.id', '=', 'folga.dia_semana')
            ->select(
                'users.nome as nome',
                'semana.nome as nome2'
            )
            ->get();
        return $select;
    }
    public function listarById($request)
    {
        $idFuncionario = $request->dados['idFuncionario'];
        $select = DB::table('folga')
            ->select('*')
            ->where('id_funcionario', $idFuncionario)
            ->get();
        return $select;
    }

    public function inserir($request)
    {
        DB::table('folga')->insert([
            'dia_semana' => $request->diaSemana,
            'id_funcionario' => $request->idFuncionario
        ]);

        return 'cadastrado';
    }
    public function excluir($request)
    {
        DB::table('folga')->where('id', $request->id)->delete();
        return 'deletado';
    }
}
