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
            ->where('id_estabelecimento', $request->id_estabelecimento)
            ->get();
        return $select;
    }

    public function prepareInsert($request)
    {
        $dados = [
            'nome' => $request->dados['nome'],
            'id_estabelecimento' => $request->id_estabelecimento
        ];

        return $dados;
    }

    public function inserir($request)
    {

        DB::table('profissao')->insert($request);

        return 'cadastrado';
    }

    public function excluir($request)
    {
          DB::table('profissao')->where('id', $request->id)->delete();
        return 'deletado';
    }

}
