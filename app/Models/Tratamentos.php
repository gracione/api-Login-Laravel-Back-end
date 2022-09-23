<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tratamentos extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('tratamento')
        ->select('tratamento.nome as nome','tratamento.id as id')
        ->join('funcionario', 'funcionario.id_profissao', '=', 'tratamento.id_profissao')
        ->where('funcionario.id_estabelecimento',$request->id_estabelecimento)
        ->groupBy('tratamento.nome','tratamento.id')
        ->get();
        return $select;
    }

    public function listarPorId ($id) {
        $select = DB::table('tratamento')
        ->select('*')
        ->where('id','=',$id)
        ->get();
        return $select;
    }
    public function listarByFuncionario ($request) {
        $select = DB::table('tratamento')
        ->join('funcionario', 'funcionario.id_profissao', '=', 'tratamento.id_profissao')
        ->select('*')
        ->where('funcionario.id','=',$request->id_profissao)
        ->where('funcionario.id_estabelecimento','=',$request->id_estabelecimento)
        ->get();
        return $select;
    }

    public function inserir ($request) {    
        DB::table('tratamento')->insert([
            'nome' => $request->nome,
            'tempo_gasto' => $request->tempo_gasto,
            'id_profissao' => $request->id_profissao
       ]);

       return 'cadastrado';
   }

   public function excluir($request)
   {
         DB::table('tratamento')->where('id', $request->id)->delete();
       return 'deletado';
   }

}
