<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HorarioTrabalho extends Model
{
    use HasFactory;
    public function listar ($request) {
        $select = DB::table('horario_almoco')
        ->select('*')
        ->get();
        return $select;
    }
    public function inserir ($request) {
         DB::table('horario_trabalho')->insert([
            'inicio1' => $request->inicioExpediente.":00",
            'fim1' => $request->inicioAlmoco.":00",
            'inicio2' => $request->fimAlmoco.":00",
            'fim2' => $request->fimExpediente.":00",
            'id_funcionario' => $request->idFuncionario
        ]);

        return 'cadastrado';
    }

}
