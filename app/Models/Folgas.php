<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folgas extends Model
{
    use HasFactory;

    public function listar () {
        $select = DB::table('folga')
        ->select('*')
        ->get();
        return $select;
    }
    public function listarById ($request) {
        $select = DB::table('folga')
        ->select('*')
        ->where('id_funcionario','=',$request->idFuncionario)
        ->get();
        return $select;
    }

    public function inserir ($request) {    
        DB::table('folga')->insert([
            'dia_semana' => $request->diaSemana,
            'id_funcionario' => $request->idFuncionario
       ]);

       return 'cadastrado';
   }
   public function excluir($request)
   {
       DB::table('folgas')->where('id', $request->id)->delete();
       return 'deletado';
   }
  
}
