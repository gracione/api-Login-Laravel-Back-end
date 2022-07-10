<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Tratamentos;

class HorarioController extends Controller
{
    public function horariosMarcados(Request $request) {
        return Horario::horarioPorDia($request);
    }

    public function horariosDiponivel(Request $request) {
        $horarioPadrao = Tratamentos::listarPorId($request->idTratamento);

        if(empty($horarioPadrao[0])) {
            return 'horario não encontrado';
        }

        $horarioPadrao = $horarioPadrao[0]->tempo_padrao;
        $horas = 7;
        $minutos = 0;
        $horarioPadrao = $this->almentarPorcentagem($horarioPadrao,0);
        $hora = floor($horarioPadrao/60);
        $minuto =  $horarioPadrao%60;
        
        while ($horas < 10) {
            $horario[] = "{$horas} : {$minutos}";
            $horas = $horas + $hora;
            $minutos = $minutos + $minuto;
            if($minutos > 60) {
                $horas = $horas + 1;
                $minutos = $minutos - 60;
            }
        }
        
        return $horario;
    }

    function almentarPorcentagem($valor, $porcentagem) {
        return $valor + ($valor / 100 * $porcentagem);
    }

}
