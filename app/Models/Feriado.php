<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feriado extends Model
{
    use HasFactory;
    public function listar()
    {
        $select = DB::table('feriados')
            ->select(
                'feriados.id as id',
                'feriados.nome as nome',
                'feriados.data as data'
            )
            ->get();
        return $select;
    }
    public function listarById($request)
    {
        $select = DB::table('feriados')
            ->select('*')
            ->where('id', '=', $request->idFeriado)
            ->get();
        return $select;
    }

    public function listarFeriadoPorMes($request)
    {
        $select = DB::table('feriados')
            ->select(DB::raw('DAY(data) as dia, nome'))
            ->whereMonth('feriados.data', $request->dados['mes'])
            ->whereYear('feriados.data', $request->dados['ano'])
            ->get();
        $results = $select->toArray();

        $arr = [];
        foreach ($results as $value) {
            $arr[$value->dia] = $value->nome;
        }
        return $arr;
    }

    public function verificarFeriado($request)
    {
        $data = explode('-', $request->data);
        $select = DB::table('feriados')
            ->select(DB::raw('DAY(data) as dia, nome','feriados as feriados.id'))
            ->whereMonth('feriados.data', $data[1])
            ->whereYear('feriados.data', $data[0])
            ->whereDay('feriados.data', $data[2])
            ->get();

        $results = $select->toArray();
        return !empty($results[0]) ? true : false;
    }

    public function inserir($request)
    {
        DB::table('feriados')->insert([
            'nome' => $request->nome,
            'data' => $request->data
        ]);

        return true;
    }
    public function excluir($request)
    {
        DB::table('feriados')->where('id', $request->id)->delete();
        return 'deletado';
    }
    public function alterar($request)
    {
        foreach ($request->request as $key => $value) {
            if($value){
                $ar[$key] = $value;
            }
        }
        DB::table('feriados')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return true;
    }
}
