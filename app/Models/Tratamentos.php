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

}
