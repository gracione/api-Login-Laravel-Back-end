<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profissao extends Model
{
    use HasFactory;

    public function listar()
    {
            $select = DB::table('profissao')
            ->select('profissao.nome as profissão','profissao.id as id')
            ->get();
        return $select;
    }
    
    public function listarById($request) {
        $select = DB::table('profissao')
        ->select('profissao.nome as nome')
        ->where('id', $request->id)
        ->get();

        return $select;
    }

    public function excluir($request)
    {

        DB::table('profissao')->delete($request->id);

        return 'excluido';
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
        $dados = [
            'nome' => $request->nome
        ];

        DB::table('profissao')->insert($dados);
        return 'inserido';
    }

}
