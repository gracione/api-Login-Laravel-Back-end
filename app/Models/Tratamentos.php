<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tratamentos extends Model
{
    use HasFactory;

    public function listar ($request) {
        $users = DB::table('tratamentos')
        ->select('*')
        ->where('id_funcao_tipo','=',$request->idFuncaoTipo)
        ->get();
        return $users;
    }

}
