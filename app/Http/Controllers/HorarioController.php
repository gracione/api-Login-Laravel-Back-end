<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Tratamentos;
use App\Models\Filtro;
use App\Models\HorarioTrabalho;

class HorarioController extends Controller
{
    public function inserir(Request $request)
    {
        $tempoGasto =  $this->calcularTempoGasto($request->idFiltro, $request->idTratamento);
        $horarioInicioMinutos = $this->converterHoraToMinuto($request->horario);
        $horarioFim = $this->converterMinutosParaHora($horarioInicioMinutos + $tempoGasto);
        $ar['horario_inicio'] = $request->data . " " . $request->horario . ":00";
        $ar['horario_fim'] = $request->data . " " . $horarioFim . ":00";
        $ar['id_cliente'] = $request->idCliente;
        $ar['id_tratamento'] = $request->idTratamento;
        $ar['id_funcionario'] = $request->idFuncionario;

        return Horario::inserir($ar);
    }
    public function desmarcar(Request $request)
    {
        return Horario::excluir($request);
    }
    public function horariosMarcados(Request $request)
    {
        return Horario::horarioPorDia($request);
    }

    public function separarPorHashtag($valor)
    {
        return explode(',', $valor);
    }

    public function converterMinutosParaHora($tempoMinutos)
    {
        $hora = floor($tempoMinutos / 60);
        $minutos = $tempoMinutos % 60;
        return $hora . ":" . $minutos;
    }
    public function converterHoraToMinuto($hora)
    {
        $arrayHm = explode(":", $hora);
        $arrayHm[0];
        $arrayHm[1];
        $minutos = ($arrayHm[0] * 60);
        $minutos = $minutos + $arrayHm[1];

        return $minutos;
    }

    public function calcularTempoGasto($filtros = 0, $tratamento)
    {
        $filtros = $this->separarPorHashtag($filtros);
        $tempoTratamento = Tratamentos::listarPorId($tratamento)[0]->tempo_gasto ?? 0;
        $porcentagemFiltro = Filtro::filtroById($filtros);

        foreach ($porcentagemFiltro as $value) {
            $tempoTratamento = $this->almentarPorcentagem($tempoTratamento, $value->porcentagem_tempo);
        }

        return $tempoTratamento;
    }

    public function horariosDiponivel(Request $request)
    {
        
        $entradaSaida = HorarioTrabalho::listarById($request->idFuncionario);
        $entrada1 = $this->converterHoraToMinuto($entradaSaida[0]->inicio1);
        $saida1 = $this->converterHoraToMinuto($entradaSaida[0]->fim1);
        $entrada2 = $this->converterHoraToMinuto($entradaSaida[0]->inicio2);
        $saida2 = $this->converterHoraToMinuto($entradaSaida[0]->fim2);



        $horariosDisponivel = [];
        $tempoContado = $entrada1;
        $tempoGasto =  $this->calcularTempoGasto($request->idFiltro, $request->idTratamento);
        $horariosMarcados = Horario::buscarHorariosDisponivel($tempoGasto, $request->idFuncionario, $request->data);
        $horariosMarcadosMinutos = [];

        foreach ($horariosMarcados as $value) {
            $horariosMarcadosMinutos[] = [
                'inicio' => $this->converterHoraToMinuto($value->horario_inicio),
                'fim' => $this->converterHoraToMinuto($value->horario_fim)
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
                    'inicio' => $this->converterMinutosParaHora($inicio),
                    'fim' => $this->converterMinutosParaHora($fim)
                ];
            }
            $verificarDisponibilidade = true;
        }
        return $horariosDisponivel;
    }

    public function almentarPorcentagem($valor, $porcentagem)
    {
        return $valor + ($valor / 100 * $porcentagem);
    }
    public function converterHorasEmSegundos($horario)
    {
        return strtotime('1970-01-01 ' . $horario . 'UTC');
    }
    public function verificarHorario($tempo, $horario)
    {

        foreach ($horario as $key => $value) {
            $tempoSeg = $this->converterHorasEmSegundos($tempo);
            $inicio = $this->converterHorasEmSegundos($value['horario_inicio']);
            $fim = $this->converterHorasEmSegundos($value['horario_fim']);
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
