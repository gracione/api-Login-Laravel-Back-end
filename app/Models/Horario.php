<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\Constantes;
use App\Models\Funcionarios;
use App\Models\HorarioTrabalho;
use App\Models\Util;
use App\Models\Feriado;
use App\Models\Folgas;

class Horario extends Model
{
    use HasFactory;

    public function inserir($ar)
    {
        try {
            DB::table('horario')->insert($ar);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function excluir($request)
    {
        try {
            DB::table('horario')->delete($request->id);
        } catch (Exception $e) {
            return false ;
        }

        return true;
    }

    public function confirmar($request)
    {
        try {
            DB::table('horario')
                ->where('id', $request->id)
                ->update(['confirmado' => true]);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }


    public function verificarHorarioModoTradicional($request)
    {           
        foreach (Horario::horarios((object)$request) as $key => $value) {
            return true;
        }
        return false;
    }
    public function horarios($request)
    {
        if (Feriado::verificarFeriado($request) || Folgas::verificarFolga($request)) {
            return false;
        }

        $entradaSaida = HorarioTrabalho::listarByIdFuncionario($request->idFuncionario);
        $entrada1 = Util::converterHoraToMinuto($entradaSaida->inicio_de_expediente);
        $inicioHorarioAlmoco = Util::converterHoraToMinuto($entradaSaida->inicio_horario_de_almoco);
        $fimHorarioAlmoco = Util::converterHoraToMinuto($entradaSaida->fim_horario_de_almoco);
        $saida2 = Util::converterHoraToMinuto($entradaSaida->fim_de_expediente);

        $horariosDisponivel = [];
        $tempoContado = $entrada1;
        $tempoGasto =  Util::converterHoraToMinuto(Util::calcularTempoGasto($request->idFiltro, $request->idTratamento));
        $horariosMarcados = Horario::buscarHorariosDisponivel($tempoGasto, $request->idFuncionario, $request->data);
        $horariosMarcadosMinutos = [];

        if(!empty($request->modoTradicional)){
            $horarioTradicionalInicio = Util::converterHoraToMinuto($request->modoTradicional);
            $horarioTradicionalFim = $horarioTradicionalInicio+$tempoGasto-1;
        }

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

            //expediente
            if ($inicio >= $inicioHorarioAlmoco && $fimHorarioAlmoco > $inicio) {
                $verificarDisponibilidade = false;
            }

            foreach ($horariosMarcadosMinutos as $valueMarcados) {
                if ($valueMarcados['inicio'] >= $inicio && $valueMarcados['inicio'] < $fim) {
                    $verificarDisponibilidade = false;
                }
                if ($valueMarcados['fim'] >= $inicio && $valueMarcados['fim'] < $fim) {
                    $verificarDisponibilidade = false;
                }
            }

            if(!empty($request->modoTradicional) && $verificarDisponibilidade){
                $verificarDisponibilidade = false;
                if ($horarioTradicionalInicio >= $inicio && $horarioTradicionalInicio < $fim) {
                    $verificarDisponibilidade = true;
                }
                if ($horarioTradicionalFim >= $inicio && $horarioTradicionalFim < $fim) {
                    $verificarDisponibilidade = true;
                }
            }

            if ($verificarDisponibilidade) {
                $horariosDisponivel[] = [
                    'inicio' => Util::converterMinutosParaHora($inicio),
                    'marcado' => 'nao'
                ];

            }

            $verificarDisponibilidade = true;
        }
        return $horariosDisponivel;
    }

    public function horarioPorDia($request)
    {
        $select = DB::table('horario')
            ->select(DB::raw(
                'TIME_FORMAT(horario.horario_inicio, "%h:%i") as horario,
                    TIME_FORMAT(horario.horario_inicio, "%h:%i") as horario_inicio,
                    DATE_FORMAT(horario.horario_inicio, " %d %M de %Y") as data,
                users.nome as cliente,
                users.numero as telefone,
                func.nome as funcionario,
                t.nome as tratamento,
                horario.confirmado as confirmado,
                horario.nome_cliente as nome_cliente,
                horario.id as idHorario',
            ))
            ->join('users', 'users.id', '=', 'horario.id_cliente')
            ->join('funcionario', 'funcionario.id', '=', 'horario.id_funcionario')
            ->join('users as func', 'func.id', '=', 'funcionario.id_usuario')
            ->join('tratamento as t', 't.id', '=', 'horario.id_tratamento');

        if ($request->tipoUsuario == Constantes::CLIENTE) {
            $select = $select
                ->where('horario.id_cliente', $request->idUsuario)->get();
        } else if ($request->tipoUsuario == Constantes::FUNCIONARIO) {
            $select = $select
                ->where('func.id', $request->idUsuario)->get();
        } else {
            $select = $select->get();
        }
        return $select;
    }

    public function buscarHorariosDisponivel($tempoGasto, $idFuncionario, $data = "21/8/2022")
    {
        $idUsuario = Funcionarios::getIdUsuarioByIdFuncionario($idFuncionario);
        $dataExplode = explode('-', $data);
        $select = DB::table('horario')
            ->select(DB::raw('TIME_FORMAT(horario.horario_inicio, "%H:%i") as horario_inicio,
        TIME_FORMAT(horario.horario_fim, "%H:%i") as horario_fim'))
            ->join('funcionario', 'funcionario.id', '=', 'horario.id_funcionario')
            ->where('funcionario.id_usuario', $idUsuario)
            ->whereDay('horario.horario_inicio', $dataExplode[2])
            ->whereMonth('horario.horario_inicio', $dataExplode[1])
            ->whereYear('horario.horario_inicio', $dataExplode[0])
            ->get();
        return $select;
    }
}
