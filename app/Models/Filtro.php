<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Filtro extends Model
{
    use HasFactory;

    public function listar()
    {
        $users = DB::table('filtro_tipo')
            ->join('funcao_tipo', 'funcao_tipo.id', '=', 'filtro_tipo.id_funcao_tipo')
            ->select('filtro_tipo.id', 'filtro_tipo.nome as filtro', 'funcao_tipo.nome as funcao')
            ->get();
        return $users;
    }

    public function listarFiltro($request)
    {
        $filtroTipo = DB::table('filtro_tipo')
            ->join('tratamento', 'filtro_tipo.id_tratamento', '=', 'tratamento.id')
            ->join('profissao', 'tratamento.id_profissao', '=', 'profissao.id')
            ->where('filtro_tipo.id_tratamento', '=', $request->id_tratamento)
            ->select(DB::raw('distinct filtro_tipo.id as id'), 'filtro_tipo.nome as nome')
            ->get();

        $filtro = [];
        foreach ($filtroTipo as $key => $value) {
            $filtro[$key]['nome'] = $value->nome;
            $filtro[$key]['id'] = $value->id;
            $filtro[$key]['filtro'] = DB::table('filtro')
                ->where('filtro.id_filtro_tipo', '=', $value->id)
                ->select('*')
                ->get();
        }
        return $filtro;
    }

    public static function filtroById($idFiltro)
    {
        $users = DB::table('filtro')
            ->select(DB::raw('porcentagem_tempo'))
            ->whereIn('id', $idFiltro)
            ->get();
        return $users;
    }
}
