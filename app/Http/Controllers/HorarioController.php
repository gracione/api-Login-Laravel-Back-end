<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Util;

class HorarioController extends Controller
{
    public $horario;

    public function __construct()
    {
        $this->horario = new Horario();
    }

    public function inserir(Request $request)
    {
        $horario = $request->horario;
        if (!empty($request->modoTradicional)) {
            if ($this->horario->verificarHorarioModoTradicional($request)) {
                $horario = $request->modoTradicional;
            } else {
                return false;
            }
        }

        $tempoGastoEmHora =  Util::calculateTimeSpent($request->idFiltro, $request->idTratamento);
        $tempoGastoEmMinutos = Util::convertHoursToMinutes($tempoGastoEmHora);
        $horarioInicioMinutos = Util::convertHoursToMinutes($horario);
        $horarioFim = Util::convertMinutesToHours($horarioInicioMinutos + $tempoGastoEmMinutos - 1);
        $ar['horario_inicio'] = $request->data . " " . $horario . ":00";
        $ar['horario_fim'] = $request->data . " " . $horarioFim . ":00";
        $ar['id_cliente'] = $request->idCliente;
        $ar['id_tratamento'] = $request->idTratamento;
        $ar['id_funcionario'] = $request->idFuncionario;
        $ar['confirmado'] = false;
        if (!empty($request->nomeCliente)) {
            $ar['nome_cliente'] = $request->nomeCliente;
            $ar['confirmado'] = true;
        } else {
            $ar['nome_cliente'] = $request->nomeUsuario;
        }

        return $this->horario->inserir($ar);
    }

    public function desmarcar(Request $request)
    {
        return $this->horario->excluir($request);
    }

    public function confirmar(Request $request)
    {
        return $this->horario->confirmar($request);
    }

    public function alterar(Request $request)
    {
        return $this->horario->alterar($request);
    }

    public function horariosMarcados(Request $request)
    {
        return $this->horario->horarioPorDia($request);
    }

    public function tempoGasto(Request $request)
    {
        return $request->filtros == 0 && $request->tratamento == 0 ? 0 :
            Util::calculateTimeSpent($request->filtros, $request->tratamento);
    }

    public function horariosDiponivel(Request $request)
    {
        return $this->horario->listar($request);
    }

    public function verificarHorario($tempo, $horario)
    {
        foreach ($horario as $key => $value) {
            $tempoSeg = Util::convertHoursToSeconds($tempo);
            $inicio = Util::convertHoursToSeconds($value['horario_inicio']);
            $fim = Util::convertHoursToSeconds($value['horario_fim']);
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
