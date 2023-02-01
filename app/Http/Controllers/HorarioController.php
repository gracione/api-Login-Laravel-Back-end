<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Util;

class HorarioController extends Controller
{
    public function inserir(Request $request)
    {
        $horario = $request->horario;
        if(!empty($request->modoTradicional)) {
            if(Horario::verificarHorarioModoTradicional($request)){
                $horario = $request->modoTradicional;
            } else {
                return false;
            }
        }

        $tempoGastoEmHora =  Util::calcularTempoGasto($request->idFiltro, $request->idTratamento);
        $tempoGastoEmMinutos = Util::converterHoraToMinuto($tempoGastoEmHora);
        $horarioInicioMinutos = Util::converterHoraToMinuto($horario);
        $horarioFim = Util::converterMinutosParaHora($horarioInicioMinutos + $tempoGastoEmMinutos - 1);
        $ar['horario_inicio'] = $request->data . " " . $horario . ":00";
        $ar['horario_fim'] = $request->data . " " . $horarioFim . ":00";
        $ar['id_cliente'] = $request->idCliente;
        $ar['id_tratamento'] = $request->idTratamento;
        $ar['id_funcionario'] = $request->idFuncionario;
        $ar['confirmado'] = false;
        if(!empty($request->nomeCliente)){
            $ar['nome_cliente'] = $request->nomeCliente;
            $ar['confirmado'] = true;
        } else {
            $ar['nome_cliente'] = $request->nomeUsuario;
        }

        return Horario::inserir($ar);
    }

    public function desmarcar(Request $request)
    {
        return Horario::excluir($request);
    }
    
    public function confirmar(Request $request)
    {
        return Horario::confirmar($request);
    }

    public function alterar(Request $request)
    {
        return Horario::alterar($request);
    }

    public function horariosMarcados(Request $request)
    {
        return Horario::horarioPorDia($request);
    }


    public function tempoGasto(Request $request)
    {
        return $request->filtros == 0 && $request->tratamento == 0 ? 0 :
            Util::calcularTempoGasto($request->filtros, $request->tratamento);
    }

    public function horariosDiponivel(Request $request)
    {
        return Horario::horarios($request);
    }

    public function verificarHorario($tempo, $horario)
    {
        foreach ($horario as $key => $value) {
            $tempoSeg = Util::converterHorasEmSegundos($tempo);
            $inicio = Util::converterHorasEmSegundos($value['horario_inicio']);
            $fim = Util::converterHorasEmSegundos($value['horario_fim']);
            if ($inicio <= $tempoSeg and $fim >= $tempoSeg) {
                return false;
            }
            return true;
        }
    }
    function converterJsonParaArray($json)
    {
        $vetor = [];
        foreach ($json as $key => $value) {
            $value = get_object_vars($value);
            $vetor[] = $value;
        }
        return $vetor;
    }
}
