<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tratamentos extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('tratamentos')
        ->select('*')
        ->where('id_funcao_tipo','=',$request->idFuncaoTipo)
        ->get();
        return $select;
    }

    public function listarPorId ($id) {
        $select = DB::table('tratamentos')
        ->select('*')
        ->where('id','=',$id)
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

}
