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

        $horariosMarcados = $this->converterJsonParaArray(Horario::horarioPorDia($request));

        while ($horas < 16) {
            $tempo =  "{$horas}:{$minutos}:00";

            if($this->verificarHorario($tempo,$horariosMarcados)) {
                $horario[] = $tempo;
            }
            $horas = $horas + $hora;
            $minutos = $minutos + $minuto;

            if($minutos > 60) {
                $horas = $horas + 1;
                $minutos = $minutos - 60;
            }
        }
        
        return $horario;
    }

    public function almentarPorcentagem($valor, $porcentagem) {
        return $valor + ($valor / 100 * $porcentagem);
    }
    public function converterHorasEmSegundos($horario) {
        return strtotime('1970-01-01 '.$horario.'UTC');
    }
    public function verificarHorario($tempo,$horario){

        foreach ($horario as $key => $value) {
            $tempoSeg = $this->converterHorasEmSegundos($tempo);
            $inicio = $this->converterHorasEmSegundos($value['horario_inicio']);
            $fim = $this->converterHorasEmSegundos($value['horario_fim']);
            if($inicio <= $tempoSeg and $fim >= $tempoSeg) {
                return false;
            }
            return true;
        }
    }
    function converterJsonParaArray($json){
        $vetor = [];
        foreach ($json as $key => $value) {
            $value= get_object_vars($value);
            $vetor[] = $value;
        }
        return $vetor;
    }
}
