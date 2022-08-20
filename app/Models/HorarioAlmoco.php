<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HorarioAlmoco extends Model
{
    use HasFactory;

    public function listar ($request) {
        $select = DB::table('horario_almoco')
        ->select('*')
        ->get();
        return $select;
    }
    public function inserir ($request) {
         DB::table('horario_almoco')->insert([
            'inicio' => $request->inicio,
            'fim' => $request->fim,
            'id_funcionario' => $request->id_funcionario
        ]);

        return 'cadastrado';
    }
}
