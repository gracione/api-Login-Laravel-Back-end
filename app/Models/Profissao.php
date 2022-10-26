<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissao extends Model
{
    use HasFactory;

    public function listar($request)
    {
            $select = DB::table('profissao')
            ->select('*')
            ->get();
        return $select;
    }

    public function excluir($request)
    {

        DB::table('profissao')->delete($request->id);

        return 'excluido';
    }

    public function listarDadosAlterar($request) {
        $select = DB::table('profissao')
        ->select('profissao.nome as nome')
        ->where('id', $request->id)
        ->get();

        return $select;
    }

    public function prepareInsert($request)
    {
        $dados = [
            'nome' => $request->dados['nome']
        ];

        return $dados;
    }

    public function alterar($request)
    {

        if(!empty($request->nome)){
            DB::table('profissao')
            ->where('id',$request->id)
            ->update(['nome'=> $request->nome]);
        }

        return 'cadastrado';
    }

    public function inserir($request)
    {
        DB::table('profissao')->insert($request);


        return 'inserido';
    }

}
