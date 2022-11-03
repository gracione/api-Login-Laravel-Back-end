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
            'feriados.nome as nome',
            'feriados.data as data')
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
        return $select;
    }

    public function inserir($request)
    {
        DB::table('feriados')->insert([
            'nome' => $request->nome,
            'data' => $request->data
        ]);

        return 'cadastrado';
    }
    public function excluir($request)
    {
        DB::table('feriados')->where('id', $request->id)->delete();
        return 'deletado';
    }
    public function alterar($request)
    {
        $ar['nome'] = $request->nome;
        $ar['data'] = $request->data;

        DB::table('feriados')
            ->where('id', $request->id)
            ->update(array_filter($ar));

        return 'alterado';
    }
}
