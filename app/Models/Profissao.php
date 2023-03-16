<?php

namespace App\Models;

use Exception;
use Funcionario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissao extends Model
{
    use HasFactory;

    public function listar()
    {
        $select = DB::table('profissao')
            ->select('profissao.nome as profissão', 'profissao.id as id')
            ->get();
        return $select->toArray();
    }

    public function listarById($request)
    {
        $select = DB::table('profissao')
            ->select('profissao.nome as nome')
            ->where('id', $request->id)
            ->get();
        $result = $select->toArray();

        return $result;
    }

    public function listarByIdFuncionario($request)
    {
        $select = DB::table('profissao')
            ->select('profissao.nome as nome', 'profissao.id as id', 'funcionario.id_usuario', 'funcionario.id as id_funcionario')
            ->join('funcionario', 'funcionario.id_profissao', '=', 'profissao.id')
            ->where('funcionario.id_usuario', $request->id)
            ->get();
        $result = $select->toArray();

        return $result;
    }

    public function excluir($request)
    {
        try {
            DB::table('profissao')->delete($request->id);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }



    public function alterar($request)
    {
        if (!empty($request->nome)) {
            DB::table('profissao')
                ->where('id', $request->id)
                ->update(['nome' => $request->nome]);
        }

        return true;
    }

    public function inserir($request)
    {
        $dados = [
            'nome' => $request->nome
        ];

        DB::table('profissao')->insert($dados);
        return 'inserido';
    }
}
