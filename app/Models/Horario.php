<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Horario extends Model
{
    use HasFactory;

    public function horarioPorDia ($request) {
        $mes = empty($request->mes) ? date('m'): $request->mes;
        $ano = empty($request->ano) ? date('Y'): $request->ano;
        
        if(!empty($request->dia)) {
            $select = DB::table('horario')
            ->select(DB::raw('TIME(horario.horario_inicio) as horario_inicio'                                    
            ))
            ->whereDay('horario.horario_inicio',$request->dia)
            ->whereMonth('horario.horario_inicio',$mes)
            ->whereYear('horario.horario_inicio',$ano)
            ->get();
        } else {
            $select = DB::table('horario')
            ->select(DB::raw('TIME(horario.horario_inicio) as horario_inicio'))
//            ->whereMonth('horario.horario_inicio',$mes)
//            ->whereYear('horario.horario_inicio',$ano)
            ->get();
        }

        return $select;
    }
    public function buscarHorariosDisponivel($tempoGasto, $idFuncionario){
        $select = DB::table('horario')
        ->select(DB::raw('time(horario_inicio)'))
            ->where(DB::raw('TIME_TO_SEC(time(horario_fim) -time(horario_inicio))/60'), '>=' , $tempoGasto)
            ->where('id_funcionario', '>=' , $idFuncionario)
            ->get();
        return $select;
       }
}
