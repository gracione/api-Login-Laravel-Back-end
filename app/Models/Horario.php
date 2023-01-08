<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\Constantes;
use App\Models\Funcionarios;

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
        DB::table('horario')->delete($request->id);

        return 'excluido';
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

    public function alterar($request)
    {
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

            if($request->tipoUsuario == Constantes::CLIENTE) {
                $select = $select
                ->where('horario.id_cliente',$request->idUsuario)->get();
            }
            else if($request->tipoUsuario == Constantes::FUNCIONARIO) {
                $select = $select
                ->where('func.id',$request->idUsuario)->get();
    
            }else{
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
