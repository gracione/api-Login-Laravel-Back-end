<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expediente
{
    use HasFactory;

    protected $table = 'horario_trabalho';
    public $timestamps = false;

    protected $fillable = ['inicio1','fim1','inicio2','fim2','id_usuario'];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

    public function listar()
    {
        $resultado = DB::table('horario_trabalho')
            ->join('users', 'users.id', '=', 'horario_trabalho.id_usuario')
            ->select(
                'users.nome as funcionario',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->get();

        return $resultado;
    }

    public function getById($id)
    {
        $result = DB::table('horario_trabalho')
            ->join('users', 'users.id', '=', 'horario_trabalho.id_usuario')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->select(
                'users.nome as nome',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->where('users.id', '=', $id)
            ->first();

        return $result ? (array) $result : null;
    }

    public function getByIdUsuario($idUsuario)
    {
        $result = DB::table('horario_trabalho')
            ->join('users', 'users.id', '=', 'horario_trabalho.id_usuario')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->select(
                'users.nome as nome',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->where('users.id', '=', $idUsuario)
            ->first();

        return $result ? (array) $result : null;
    }
    public function getByIdFuncionario($id)
    {
        $result = DB::table('horario_trabalho')
            ->join('users', 'users.id', '=', 'horario_trabalho.id_usuario')
            ->join('funcionario', 'funcionario.id_usuario', '=', 'users.id')
            ->where('funcionario.id', '=', $id)
            ->select(
                'users.nome as nome',
                'horario_trabalho.id as id',
                'horario_trabalho.inicio1 as inicio_de_expediente',
                'horario_trabalho.fim1 as inicio_horario_de_almoco',
                'horario_trabalho.inicio2 as fim_horario_de_almoco',
                'horario_trabalho.fim2 as fim_de_expediente'
            )
            ->first();

        return $result;
    }

    public function inserir($request)
    {
        $data = [
            'inicio1' => $request->inicioExpediente . ":00",
            'fim1' => $request->inicioAlmoco . ":00",
            'inicio2' => $request->fimAlmoco . ":00",
            'fim2' => $request->fimExpediente . ":00",
            'id_funcionario' => $request->idFuncionario
        ];

        $this->fill($data);
        $this->save();

        return true;
    }

    public function destroy($request)
    {
        $this->destroy($request->id);

        return 'excluido';
    }
}
