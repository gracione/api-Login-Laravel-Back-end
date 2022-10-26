<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\FiltroTipo;

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

    public function listarPorId($id)
    {
        $select = DB::table('tratamento')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        return $select;
    }
    public function listarByFuncionario($request)
    {
        $select = DB::table('tratamento')
            ->join('funcionario', 'funcionario.id_profissao', '=', 'tratamento.id_profissao')
            ->select(DB::raw('tratamento.nome as nome,tratamento.id as id'))
            ->where('funcionario.id', '=', $request->id_profissao)
            ->get();
        return $select;
    }

    public function inserir($request)
    {
        $idTratamento = DB::table('tratamento')->insertGetId([
            'nome' => $request->nome_tratamento,
            'tempo_gasto' => $request->tempo_gasto,
            'id_profissao' => $request->id_profissao
        ]);

        foreach ($request->tipo_de_filtro as $key => $value) {
            $nomeFiltro = $request->nomesTipoFiltro[$key];

            $idTipoFiltro = DB::table('filtro_tipo')->insertGetId([
                'nome' => $nomeFiltro,
                'id_tratamento' => $idTratamento
            ]);
                
            
            foreach ($value as $valor) {
                $nomeTipoFiltro = $valor[0];
                $porcentagem = $valor[1];
                DB::table('filtro')->insert([
                    'nome' => $nomeTipoFiltro,
                    'porcentagem_tempo' => $porcentagem,
                    'id_filtro_tipo' => $idTipoFiltro
                ]);
    
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
