<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Funcionarios extends Model
{
    use HasFactory;

    public function funcionarios () {
        $users = DB::table('users')
        ->join('funcao_funcionario', 'funcao_funcionario.id_usuario', '=', 'users.id')
        ->join('funcao_tipo', 'funcao_tipo.id', '=', 'funcao_funcionario.id_funcao_tipo')
        ->select('users.nome as nome_usuario','users.id as id_usuario', 'funcao_tipo.nome as funcao', 'funcao_tipo.id as id_funcao')
        ->get();
        return $users;
    }
}
