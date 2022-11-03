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
}
