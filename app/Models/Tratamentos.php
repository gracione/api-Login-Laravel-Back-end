<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Util;
use App\Models\FiltroTipo;

class Tratamentos extends Model
{
    use HasFactory;

    public function listar()
    {
        $select = DB::table('tratamento')
            ->select(
                'tratamento.id as id',
                'tratamento.nome as tratamento',
                'profissao.nome as profissão',
                'tratamento.tempo_gasto as tempo_gasto'
            )
            ->join('profissao', 'profissao.id', '=', 'tratamento.id_profissao')
            ->get();
        $results = $select->toArray();;

        foreach ($results as $key => $value) {
            $results[$key]->tempo_gasto = Util::converterMinutosParaHora($value->tempo_gasto);
        }

        return $results;
    }

    public function getByIdProfissao($request)
    {
        $id = !empty($request->dados['id']) ? $request->dados['id'] : $request;

        $select = DB::table('tratamento')
            ->select(DB::raw('tratamento.nome as nome,tratamento.id as id'))
            ->where('tratamento.id_profissao', '=', $id)
            ->get();
        return $select->toArray();
    }
    public function getById($request)
    {
        $id = !empty($request->id) ? $request->id : $request;

        $select = DB::table('tratamento')
            ->select(DB::raw('tratamento.nome as nome,tratamento.tempo_gasto as tempo_gasto,tratamento.id as id,tratamento.id_profissao as id_profissao'))
            ->where('tratamento.id', '=', $id)
            ->get();
        $result = $select->toArray();
        if (!empty($result[0])) {
            $result[0]->tempo_gasto = Util::converterMinutosParaHora($result[0]->tempo_gasto);
            $result[0]->id_profissao = (int)$result[0]->id_profissao;
            $result[0]->filtro = FiltroTipo::getByIdTratamento($id);
        }

        return $result[0];
    }

    public function inserir($request)
    {
        $tratamento['nome'] = $request->tratamento;
        $tratamento['tempo_gasto'] = Util::converterHoraToMinuto($request->tempoGasto);
        $tratamento['id_profissao'] = $request->idProfissao;

        $idTratamento = DB::table('tratamento')->insertGetId($tratamento);

        foreach ($request->tipoDeFiltro as $key => $value) {
            if ($value[0]) {
                $nomeFiltro = $request->tipoFiltro[$key];
                $filtroTipo = ['nome' => $nomeFiltro, 'id_tratamento' => $idTratamento];
                $idTipoFiltro = DB::table('filtro_tipo')->insertGetId($filtroTipo);

                foreach ($value as $valor) {
                    $filtro = ['nome' => $valor[0], 'porcentagem_tempo' => $valor[1], 'id_filtro_tipo' => $idTipoFiltro];
                    DB::table('filtro')->insert($filtro);
                }
            }
        }

        return true;
    }

    public function excluir($request)
    {
        $filtroTipo = DB::table('filtro_tipo')
            ->select('*')
            ->where('filtro_tipo.id_tratamento', '=', $request->id)
            ->get();

        foreach ($filtroTipo as $value) {
            if (!empty($value->id)) {
                DB::table('filtro')->where('id_filtro_tipo', $value->id)->delete();
            }
        }

        DB::table('filtro_tipo')->where('id_tratamento', $request->id)->delete();
        DB::table('tratamento')->where('id', $request->id)->delete();
        return 'deletado';
    }

    public function alterar($request)
    {
        $dadosParaAlterar['nome'] = !empty($request->nomeTratamento) ? $request->nomeTratamento : null;
        $dadosParaAlterar['tempo_gasto'] = !empty($request->tempoGasto) ? Util::converterHoraToMinuto($request->tempoGasto) : null;
        $dadosParaAlterar['id_profissao'] = !empty($request->profissao) ? $request->profissao : null;


        $filtroTipo = !empty($request->filtroTipo) ? $request->filtroTipo : [];

        foreach ($filtroTipo as $key => $value) {
            if (!empty($value['id'])) {
                DB::table('filtro_tipo')
                    ->where('id', $value['id'])
                    ->update(array_filter(['nome' => $value['nome']]));
            }
        }
        $filtro = !empty($request->filtro) ? array_filter($request->filtro) : [];
        foreach ($filtro as $key => $value) {
            if (!empty($value['id'])) {
                DB::table('filtro')
                    ->where('id', $value['id'])
                    ->update(array_filter($value));
            }
        }

        if (!empty(array_filter($dadosParaAlterar))) {
            DB::table('tratamento')
                ->where('id', $request->id)
                ->update(array_filter($dadosParaAlterar));
        }

        return true;
    }
}
