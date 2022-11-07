<?php

namespace App\Models;

class Util
{
    public function converterMinutosParaHora($tempoMinutos)
    {
        $hora = floor($tempoMinutos / 60);
        $hora = $hora < 10 ? "0$hora" : $hora;
        $minutos = $tempoMinutos % 60;
        $minutos = $minutos < 10 ? "0$minutos" : $minutos;
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
    public function almentarPorcentagem($valor, $porcentagem)
    {
        return $valor + ($valor / 100 * $porcentagem);
    }

    public function separarPorHashtag($valor)
    {
        if (is_array($valor)) {
            return $valor;
        }
        return explode(',', $valor);
    }

    public function calcularTempoGasto($filtros = 0, $tratamento = 0)
    {
        $filtros = Util::separarPorHashtag($filtros);
        $tempoTratamento = Tratamentos::listarById($tratamento)->tempo_gasto;
        $porcentagemFiltro = Filtro::filtroById($filtros);

        foreach ($porcentagemFiltro as $value) {
            $tempoTratamento = Util::almentarPorcentagem($tempoTratamento, $value->porcentagem_tempo);
        }

        return $tempoTratamento;
    }
}
