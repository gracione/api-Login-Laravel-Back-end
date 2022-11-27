<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\HorarioTrabalho;
use App\Models\Util;
use App\Models\Feriado;
use App\Models\Folgas;

class HorarioController extends Controller
{
    public function inserir(Request $request)
    {
        $tempoGastoEmHora =  Util::calcularTempoGasto($request->idFiltro, $request->idTratamento);
        $tempoGastoEmMinutos = Util::converterHoraToMinuto($tempoGastoEmHora);
        $horarioInicioMinutos = Util::converterHoraToMinuto($request->horario);
        $horarioFim = Util::converterMinutosParaHora($horarioInicioMinutos + $tempoGastoEmMinutos);
        $ar['horario_inicio'] = $request->data . " " . $request->horario . ":00";
        $ar['horario_fim'] = $request->data . " " . $horarioFim . ":00";
        $ar['id_cliente'] = $request->idCliente;
        $ar['id_tratamento'] = $request->idTratamento;
        $ar['id_funcionario'] = $request->idFuncionario;
        $ar['confirmado'] = false;

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
        if (
            Feriado::verificarFeriado($request) ||
            Folgas::verificarFolga($request)
        ) {
            return false;
        }

        $entradaSaida = HorarioTrabalho::listarByIdFuncionario($request->idFuncionario);
        $entrada1 = Util::converterHoraToMinuto($entradaSaida->inicio_de_expediente);
        $saida1 = Util::converterHoraToMinuto($entradaSaida->inicio_horario_de_almoco);
        $entrada2 = Util::converterHoraToMinuto($entradaSaida->fim_horario_de_almoco);
        $saida2 = Util::converterHoraToMinuto($entradaSaida->fim_de_expediente);

        $horariosDisponivel = [];
        $tempoContado = $entrada1;
        $tempoGasto =  Util::converterHoraToMinuto(Util::calcularTempoGasto($request->idFiltro, $request->idTratamento));
        $horariosMarcados = Horario::buscarHorariosDisponivel($tempoGasto, $request->idFuncionario, $request->data);
        $horariosMarcadosMinutos = [];

        foreach ($horariosMarcados as $value) {
            $horariosMarcadosMinutos[] = [
                'inicio' => Util::converterHoraToMinuto($value->horario_inicio),
                'fim' => Util::converterHoraToMinuto($value->horario_fim)
            ];
        }

        $verificarDisponibilidade = true;
        for ($tempoContado = $entrada1; $tempoContado < $saida2; $tempoContado += $tempoGasto) {
            $inicio = $tempoContado;
            $fim = $tempoContado + $tempoGasto;
            foreach ($horariosMarcadosMinutos as $valueMarcados) {
                $inicio = $tempoContado;
                $fim = $tempoContado + $tempoGasto;
                if ($valueMarcados['inicio'] < $inicio && $valueMarcados['fim'] > $inicio) {
                    $verificarDisponibilidade = false;
                }
                if ($valueMarcados['inicio'] < $fim && $valueMarcados['fim'] >= $fim) {
                    $verificarDisponibilidade = false;
                }
                if ($saida1 < $inicio && $entrada2 > $inicio) {
                    $verificarDisponibilidade = false;
                }
                if ($saida1 < $fim && $entrada2 > $fim) {
                    $verificarDisponibilidade = false;
                }
            }

            if ($verificarDisponibilidade) {
                $horariosDisponivel[] = [
                    'inicio' => Util::converterMinutosParaHora($inicio),
                    'fim' => Util::converterMinutosParaHora($fim)
                ];
            }
            $verificarDisponibilidade = true;
        }
        return $horariosDisponivel;
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
