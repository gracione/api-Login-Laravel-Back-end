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
            ->select(DB::raw('TIME(horario.horario_inicio) as horario_inicio,
                                    TIME(horario.horario_fim) as horario_fim,
                                    DATE(horario.horario_inicio) as data'                                    
                                    ))
            ->whereDay('horario.horario_inicio',$request->dia)
            ->whereMonth('horario.horario_inicio',$mes)
            ->whereYear('horario.horario_inicio',$ano)
            ->get();
        } else {
            $select = DB::table('horario')
            ->select('*')
            ->whereMonth('horario.horario_inicio',$mes)
            ->whereYear('horario.horario_inicio',$ano)
            ->get();
        }

        return $select;
    }
}
