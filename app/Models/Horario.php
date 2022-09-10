<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Horario extends Model
{
    use HasFactory;

    public function horarioPorDia($request)
    {
        $mes = empty($request->mes) ? date('m') : $request->mes;
        $ano = empty($request->ano) ? date('Y') : $request->ano;

        if (!empty($request->dia)) {
            $select = DB::table('horario')
                ->select(DB::raw(
                    'TIME(horario.horario_inicio) as horario_inicio',
                    'TIME(horario.horario_fim) as horario_fim'
                ))
                ->whereDay('horario.horario_inicio', $request->dia)
                ->whereMonth('horario.horario_inicio', $mes)
                ->whereYear('horario.horario_inicio', $ano)
                ->get();
        } else {
            $select = DB::table('horario')
                ->select(DB::raw(
                    'TIME_FORMAT(horario.horario_inicio, "%h:%i") as horario_inicio,
                DATE_FORMAT(horario.horario_inicio, " %d %M de %Y") as data,
                users.nome as cliente,
                users.numero as numero,
                func.nome as funcionario,
                t.nome as tratamento'
                ))
                ->join('users', 'users.id', '=', 'horario.id_cliente')
                ->join('users as func', 'func.id', '=', 'horario.id_funcionario')
                ->join('tratamento as t', 't.id', '=', 'horario.id_tratamento')

                //            ->where('horario.horario_inicio',$mes)
                //            ->whereYear('horario.horario_inicio',$ano)
                ->get();
        }

        return $select;
    }
    public function buscarHorariosDisponivel($tempoGasto, $idFuncionario)
    {
        $select = DB::table('horario')
            ->select(DB::raw('TIME_FORMAT(horario.horario_inicio, "%H:%i") as horario_inicio,
        TIME_FORMAT(horario.horario_fim, "%H:%i") as horario_fim'))
            ->where(DB::raw('TIME_TO_SEC(time(horario_fim) -time(horario_inicio))/60'), '>=', $tempoGasto)
            ->where('id_funcionario', '>=', $idFuncionario)
            ->get();
        return $select;
    }
}
