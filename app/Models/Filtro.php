<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Filtro extends Model
{
    use HasFactory;

    public function listar () {
        $users = DB::table('filtro_tipo')
        ->join('funcao_tipo', 'funcao_tipo.id', '=', 'filtro_tipo.id_funcao_tipo')
        ->select('filtro_tipo.id','filtro_tipo.nome as filtro','funcao_tipo.nome as funcao')
        ->get();
        return $users;
    }

    public function listarFiltro ($request) {
        $users = DB::table('filtro')
        ->select('*')
        ->where('filtro.id_filtro_tipo','=',$request->id)
        ->get();
        return $users;
    }

    public function filtroById ($idFiltro) {
        $users = DB::table('filtro')
        ->select(DB::raw('SUM(porcentagem_tempo) as porcentagem_tempo'))
        ->whereIn('id',$idFiltro )
        ->get();
        return $users;
    }

}
