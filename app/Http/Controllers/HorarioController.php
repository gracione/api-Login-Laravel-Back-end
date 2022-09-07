<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Tratamentos;
use App\Models\Filtro;

class HorarioController extends Controller
{
    public function horariosMarcados(Request $request) {
        return Horario::horarioPorDia($request);
    }
    
    public function separarPorHashtag($valor) {
        return explode('#',$valor);
    }

    public function converterMinutosParaHora($tempoMinutos){
        $hora = floor($tempoMinutos/60);
        $minutos = $tempoMinutos%60;    
        return $hora.":".$minutos;
    
    }

    public function calcularTempoGasto($filtros, $tratamento){
        $filtros = $this->separarPorHashtag($filtros);
        $tempoTratamento = Tratamentos::listarPorId($tratamento)[0]->tempo_gasto;
        $porcentagemFiltro = Filtro::filtroById($filtros);

        foreach ($porcentagemFiltro as $value) {
            $tempoTratamento = $this->almentarPorcentagem($tempoTratamento, $value->porcentagem_tempo);
        }

        //converterMinutosParaHora($tempoTratamento);
        return $tempoTratamento;
   }

   public function horariosDiponivel(Request $request) {

       $tempoGasto =  $this->calcularTempoGasto($request->idFiltro,$request->idTratamento);
       return Horario::buscarHorariosDisponivel($tempoGasto, $request->idFuncionario);
        
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
