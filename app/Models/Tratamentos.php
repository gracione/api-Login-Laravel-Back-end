<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Util;

class Tratamentos extends Model
{
    use HasFactory;

    public function listar($request)
    {
        $select = DB::table('tratamento')
            ->select('tratamento.nome as nome', 'tratamento.id as id')
            ->join('funcionario', 'funcionario.id_profissao', '=', 'tratamento.id_profissao')
            ->groupBy('tratamento.nome', 'tratamento.id')
            ->get();
        return $select;
    }

    public function listarById($request)
    {
        $select = DB::table('tratamento')
            ->join('funcionario', 'funcionario.id_profissao', '=', 'tratamento.id_profissao')
            ->select(DB::raw('tratamento.nome as nome,tratamento.id as id'))
            ->where('funcionario.id', '=', $request->dados['id'])
            ->get();
        return $select;
    }

    public function inserir($request)
    {
        $tratamento['nome'] = $request->tratamento;
        $tratamento['tempo_gasto'] = Util::converterHoraToMinuto($request->tempoGasto);
        $tratamento['id_profissao'] = $request->idProfissao;

        $idTratamento = DB::table('tratamento')->insertGetId($tratamento);

        foreach ($request->tipoDeFiltro as $key => $value) {
            $nomeFiltro = $request->tipoFiltro[$key];
            $filtroTipo = ['nome' => $nomeFiltro, 'id_tratamento' => $idTratamento];
            $idTipoFiltro = DB::table('filtro_tipo')->insertGetId($filtroTipo);

            foreach ($value as $valor) {
                $filtro=['nome' => $valor[0],'porcentagem_tempo' => $valor[1],'id_filtro_tipo' => $idTipoFiltro];
                DB::table('filtro')->insert($filtro);
            }
        }

        return 'cadastrado';
    }

    public function excluir($request)
    {
        DB::table('tratamento')->where('id', $request->id)->delete();
        return 'deletado';
    }
}
