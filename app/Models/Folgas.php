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
                'users.nome as funcionario',
                'semana.nome as folga',
                'folga.id as id'
            )
            ->get();
        return $select;
    }
    public function listarById($request)
    {
        $select = DB::table('folga')
            ->join('funcionario', 'funcionario.id', '=', 'folga.id_funcionario')
            ->join('users', 'users.id', '=', 'funcionario.id_usuario')
            ->join('semana', 'semana.id', '=', 'folga.dia_semana')
            ->select(
                'users.nome as funcionario',
                'semana.nome as folga',
                'folga.id as id'
            )
            ->where('folga.id', $request->id)
            ->get();
        return $select;
    }

    public function listarByIdFuncionario($request)
    {
        $idFuncionario = $request->dados['idFuncionario'];
        $select = DB::table('folga')
            ->select('dia_semana')
            ->where('id_funcionario', $idFuncionario)
            ->get();
        $results = $select->toArray();

        $arr = [];
        foreach ($results as $value) {
            $arr[] = $value->dia_semana;
        }
        return $arr;
    }

    public function verificarFolga($request)
    {
        $diaSemana = date('w', strtotime($request->data)) + 1;
        $idFuncionario = $request->idFuncionario;

        $select = DB::table('folga')
            ->select('dia_semana')
            ->where('dia_semana', $diaSemana)
            ->where('id_funcionario', $idFuncionario)
            ->get();
        $results = $select->toArray();

        return !empty($results[0]) ? true : false;
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

    public function alterar($request)
    {
        $ar['dia_semana'] = $request->diaSemana;

        DB::table('folga')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return 'alterado';
    }
}
